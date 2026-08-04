import { Request, Response } from 'express';
import mongoose from 'mongoose';
import jwt from "jsonwebtoken";
import dayjs from "dayjs";
import { compareOTP, generateOTP, generatePassword, hashOTP } from '../utils/auth.utils';

import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import { generateAccessToken, generateRefreshToken } from '../utils/token';
import Otp from '../models/otp.model';
import User from "../models/user.model";
import Caretaker from "../models/caretaker.model";
import { sendWhatsappEvent } from '../service/whatsApps';
import { PRPSmsService } from '../service/sendSMS';
import { extractDocuments } from '../utils/normalizeDocuments';
// import { sendMail } from 'service/sendMail';
import Address from "../models/address.model";
import BankReceipt from "../models/bankReceipt.model";
import CDEC from "../models/cdec.model";
import { ImportLicenseRequest, MedicineQuotationRequest, ProformaInvoiceRequest } from "../models/docsRequest.model";
import DoctorDetails from "../models/doctorDetails.model";
import KYC from "../models/kyc.model";
import Order from "../models/order.model";
import Patient from "../models/patient.model";
import PrescribedMedicine from "../models/prescribedMedicine.model";
import Prescription from "../models/prescription.model";
import { sendEmail } from '../service/sendMail';
import { otpTemplate, passwordTemplate } from '../service/emailTemplate';

const smsService = new PRPSmsService();

export const sendOtp = async (req: Request, res: Response) => {
    try {

        const { email, phone } = req.body;

        if (!email && !phone) {
            return sendErrorResponse(res, 400, "Email or phone is required");
        }

        const identifier = phone ?? email;

        /* ---------------- USER CHECK ---------------- */

        const userExists = await User.findOne(
            email ? { email } : { phone }
        ).lean();

        if (userExists) {
            return sendErrorResponse(res, 409, "User already exists");
        }

        /* ---------------- OTP RATE LIMIT ---------------- */

        const lastOtp = await Otp.findOne({ identifier })
            .sort({ createdAt: -1 })
            .lean();

        if (
            lastOtp &&
            dayjs().diff(dayjs(lastOtp.createdAt), "minute") < 2
        ) {

            const remainingTime =
                2 - dayjs().diff(dayjs(lastOtp.createdAt), "minute");

            return sendErrorResponse(
                res,
                429,
                `OTP already sent. Please try again after ${remainingTime} minute(s).`
            );
        }

        /* ---------------- OTP GENERATION ---------------- */

        const otp = generateOTP();

        const otpHash = await hashOTP(otp);

        const expiresAt = dayjs()
            .add(2, "minute")
            .toDate();

        await Otp.deleteMany({ identifier });

        await Otp.create({
            identifier,
            otp: otpHash,
            expiresAt
        });

        /* ---------------- SEND OTP ---------------- */
        if (phone) {

            const whatsappResponse = await sendWhatsappEvent({
                mobile: phone,
                event: "SEND_OTP",
                variables: [otp],
                buttonParams: [otp],
            });

            if (!whatsappResponse) {
                await Otp.deleteMany({ identifier });

                return sendErrorResponse(
                    res,
                    502,
                    "OTP not sent. Try again later"
                );
            }

            const smsResponse = await smsService.sendOtp({
                mobile: phone,
                otp,
                type: "otp"
            });

            if (!smsResponse) {
                await Otp.deleteMany({ identifier });

                return sendErrorResponse(
                    res,
                    502,
                    "OTP not sent. Try again later"
                );
            }
        } else if (email) {
            const emailResponse = await sendEmail({
                to: email,
                subject: "Named Patient Program - Verification Code",
                html: otpTemplate(otp),
            });
            if (!emailResponse.success) {
                await Otp.deleteMany({ identifier });
                return sendErrorResponse(res, 502, "OTP not sent. Try again later");
            }
        }

        return sendSuccessResponse(
            res,
            200,
            "OTP sent successfully!"
        );

    } catch (error) {

        console.error("Send OTP error:", error);

        return sendErrorResponse(
            res,
            500,
            "Failed to send OTP"
        );
    }
};

export const verifyOtp = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;
        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized user");
        }
        const { email, phone, otp } = req.body;
        const identifier = phone || email;

        if (!identifier || !otp) {
            return sendErrorResponse(res, 400, "Invalid request data")
        }
        const otpRecord = await Otp.findOne({ identifier });
        const isValid = await compareOTP(otp, otpRecord?.otp as string);

        if (
            !otpRecord ||
            !isValid ||
            otpRecord.expiresAt < new Date()
        ) {
            return sendErrorResponse(res, 400, "Invalid or expired OTP")
        }

        const user = await User.findById(userId)
        if (!user) {
            return sendErrorResponse(res, 404, "User not found");
        }

        user.phone = phone || user.phone;
        await user.save();
        await Otp.deleteMany({ identifier });
        return sendSuccessResponse(res, 200, "Otp verify successful");
    } catch (error) {
        return sendErrorResponse(res, 500, "Internal server error");
    }
};

export const registerWithOtp = async (
    req: Request,
    res: Response
) => {
    try {
        const device =
            req.body?.deviceType === "mobile"
                ? "mobile"
                : "web";

        const { email, phone, otp, country } = req.body;

        const identifier = email || phone;

        if (!identifier || !otp || !country) {
            return sendErrorResponse(
                res,
                400,
                "Invalid request data"
            );
        }

        // Verify OTP

        const otpRecord = await Otp.findOne({
            identifier,
        });

        if (!otpRecord) {
            return sendErrorResponse(
                res,
                400,
                "OTP not found"
            );
        }

        const isValid = await compareOTP(
            otp,
            otpRecord.otp
        );

        if (
            !isValid ||
            otpRecord.expiresAt < new Date()
        ) {
            return sendErrorResponse(
                res,
                400,
                "Invalid or expired OTP"
            );
        }

        // Check existing user

        const existingUser = await User.findOne({
            $or: [
                ...(email ? [{ email }] : []),
                ...(phone ? [{ phone }] : []),
            ],
        });

        if (existingUser) {
            // Optional:
            // allow reactivation flow later

            if (existingUser.isDeactivated) {
                return sendErrorResponse(
                    res,
                    403,
                    "Account is deactivated"
                );
            }

            return sendErrorResponse(
                res,
                409,
                "User already exists"
            );
        }

        // Generate Password

        const plainPassword = generatePassword();

        // Send Credentials FIRST

        if (phone) {
            const smsResponse =
                await smsService.sendOtp({
                    mobile: phone,
                    username: phone,
                    password: plainPassword,
                    type: "password",
                });

            if (!smsResponse) {
                return sendErrorResponse(
                    res,
                    502,
                    "SMS sending failed"
                );
            }
        }

        if (email) {
            const emailResponse = await sendEmail({
                to: email,
                subject:
                    "Named Patient Program - Your Username and Password",
                html: passwordTemplate(
                    plainPassword,
                    email
                ),
            });

            if (!emailResponse.success) {
                return sendErrorResponse(
                    res,
                    502,
                    "Email sending failed"
                );
            }
        }

        // Create User

        const user = await User.create({
            country,
            email,
            phone,
            password: plainPassword,
        });

        // Generate Tokens

        const accessToken = generateAccessToken(
            user.id.toString()
        );

        const refreshToken = generateRefreshToken(
            user.id.toString()
        );

        // Save refresh token
        user.refreshToken = refreshToken;

        await user.save();

        // Remove OTP

        await Otp.deleteMany({
            identifier,
        });

        // Cookie

        if (device === "web") {
            res.cookie(
                "refreshToken",
                refreshToken,
                {
                    httpOnly: true,
                    secure:
                        process.env.NODE_ENV ===
                        "production",
                    sameSite:
                        process.env.NODE_ENV ===
                            "production"
                            ? "none"
                            : "lax",
                    path: "/",
                    maxAge:
                        7 *
                        24 *
                        60 *
                        60 *
                        1000,
                }
            );
        }

        // Response

        return sendSuccessResponse(
            res,
            201,
            "Signup successful",
            {
                accessToken,

                refreshToken:
                    device === "mobile"
                        ? refreshToken
                        : undefined,

                user: {
                    id: user._id,
                    identifier:
                        user.email || user.phone,
                },
            }
        );
    } catch (error) {
        console.error(error);

        return sendErrorResponse(
            res,
            500,
            "User registration failed"
        );
    }
};

export const login = async (
    req: Request,
    res: Response
) => {
    try {
        const device =
            req.body?.deviceType === "mobile"
                ? "mobile"
                : "web";

        const { email, phone, password } =
            req.body;

        const identifier = email || phone;

        // Validation

        if (!identifier || !password) {
            return sendErrorResponse(
                res,
                400,
                "Email/Phone and password are required"
            );
        }

        // Build Query

        const query = email
            ? { email: email.toLowerCase().trim() }
            : { phone: phone.trim() };

        // Find User

        const user = await User.findOne(query)
            .select("+password +refreshToken");

        if (!user || !user.password) {
            return sendErrorResponse(
                res,
                401,
                "Invalid credentials"
            );
        }

        // Deactivated Check

        if (user.isDeactivated) {
            return sendErrorResponse(
                res,
                403,
                "Your account has been deactivated"
            );
        }

        // Password Check

        const isMatch =
            await user.comparePassword(password);

        if (!isMatch) {
            return sendErrorResponse(
                res,
                401,
                "Invalid credentials"
            );
        }

        // Generate Tokens

        const accessToken =
            generateAccessToken(
                user.id.toString()
            );

        const refreshToken =
            generateRefreshToken(
                user.id.toString()
            );

        // Save Refresh Token

        user.refreshToken = refreshToken;

        await user.save();

        // Set Cookie

        if (device === "web") {
            res.cookie(
                "refreshToken",
                refreshToken,
                {
                    httpOnly: true,

                    secure:
                        process.env.NODE_ENV ===
                        "production",

                    sameSite:
                        process.env.NODE_ENV ===
                            "production"
                            ? "none"
                            : "lax",

                    path: "/",

                    maxAge:
                        7 *
                        24 *
                        60 *
                        60 *
                        1000,
                }
            );
        }

        // Response

        return sendSuccessResponse(
            res,
            200,
            "Login successful",
            {
                accessToken,

                refreshToken:
                    device === "mobile"
                        ? refreshToken
                        : undefined,

                user: {
                    id: user._id,

                    identifier:
                        user.email ||
                        user.phone,

                    progress:
                        user.progress,

                    role: user.role,

                    device,
                },
            }
        );
    } catch (error) {
        console.error(error);

        return sendErrorResponse(
            res,
            500,
            "Internal server error"
        );
    }
};

export const getUserProfile = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;

        const caretaker = await Caretaker.findOne({ user: userId }).select("fullname")
        const user = await User.findById(userId).select("email phone _id progress image country");
        return sendSuccessResponse(res, 200, "User profile fetched successfully", {
            user: {
                id: user?._id,
                image: user?.image || null,
                name: caretaker?.fullname,
                email: user?.email,
                phone: user?.phone,
                country: user?.country,
                progress: user?.progress
            },
        });
    } catch (error) {
        return sendErrorResponse(res, 500, "Internal server error");
    }
}

export const refreshAccessToken = async (
    req: Request,
    res: Response
) => {
    try {
        // Get Refresh Token

        const refreshToken =
            req.cookies?.refreshToken ||
            req.body?.refreshToken ||
            (req.headers[
                "x-refresh-token"
            ] as string);

        if (!refreshToken) {
            return sendErrorResponse(
                res,
                401,
                "Refresh token missing"
            );
        }

        // Verify JWT

        const decoded = jwt.verify(
            refreshToken,
            process.env
                .REFRESH_TOKEN_SECRET!
        ) as {
            id: string;
        };

        // Find User

        const user = await User.findById(
            decoded.id
        ).select("+refreshToken");

        if (!user) {
            return sendErrorResponse(
                res,
                403,
                "Invalid refresh token"
            );
        }

        // Deactivated Check

        if (user.isDeactivated) {
            return sendErrorResponse(
                res,
                403,
                "Account deactivated"
            );
        }

        // Validate Stored Token

        if (
            !user.refreshToken ||
            user.refreshToken !==
            refreshToken
        ) {
            return sendErrorResponse(
                res,
                403,
                "Invalid refresh token"
            );
        }

        // Generate New Tokens

        const newAccessToken =
            generateAccessToken(
                user.id.toString()
            );

        const newRefreshToken =
            generateRefreshToken(
                user.id.toString()
            );

        // Rotate Refresh Token

        user.refreshToken =
            newRefreshToken;

        await user.save();

        // Detect Mobile Request

        const isMobileRequest =
            !req.cookies?.refreshToken &&
            (!!req.body?.refreshToken ||
                !!req.headers[
                "x-refresh-token"
                ]);

        // Set Cookie for Web

        if (!isMobileRequest) {
            res.cookie(
                "refreshToken",
                newRefreshToken,
                {
                    httpOnly: true,

                    secure:
                        process.env
                            .NODE_ENV ===
                        "production",

                    sameSite:
                        process.env
                            .NODE_ENV ===
                            "production"
                            ? "none"
                            : "lax",

                    path: "/",

                    maxAge:
                        7 *
                        24 *
                        60 *
                        60 *
                        1000,
                }
            );
        }

        // Response

        return sendSuccessResponse(
            res,
            200,
            "Token refreshed",
            {
                accessToken:
                    newAccessToken,

                ...(isMobileRequest && {
                    refreshToken:
                        newRefreshToken,
                }),
            }
        );
    } catch (error: any) {
        // Clear Invalid Cookie

        res.clearCookie(
            "refreshToken",
            {
                httpOnly: true,

                secure:
                    process.env
                        .NODE_ENV ===
                    "production",

                sameSite:
                    process.env
                        .NODE_ENV ===
                        "production"
                        ? "none"
                        : "lax",

                path: "/",
            }
        );

        // Token Expired

        if (
            error.name ===
            "TokenExpiredError"
        ) {
            return sendErrorResponse(
                res,
                401,
                "Refresh token expired"
            );
        }

        console.error(error);

        return sendErrorResponse(
            res,
            403,
            "Invalid refresh token"
        );
    }
};

export const updateUserProfile = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized user");
        }

        // Extract uploaded documents
        const documents = extractDocuments(req);

        // Validate image
        if (!documents.length) {
            return sendErrorResponse(
                res,
                400,
                "Profile image is required"
            );
        }

        // Since image expects ONE object, take first file
        const image = documents[0];

        const updatedUser = await User.findByIdAndUpdate(
            userId,
            {
                $set: { image },
            },
            { new: true }
        ).select("image");

        return sendSuccessResponse(
            res,
            200,
            "Profile updated successfully",
            updatedUser
        );

    } catch (error) {
        console.error("Update profile error:", error);
        return sendErrorResponse(res, 500, "Internal server error");
    }
};

export const updatePassword = async (req: Request, res: Response) => {
    try {
        const { email, phone, newPassword } = req.body;

        if ((!email && !phone) || !newPassword) {
            return sendErrorResponse(
                res,
                400,
                "Email or phone, old password and new password are required"
            );
        }

        if (newPassword.length < 8) {
            return sendErrorResponse(
                res,
                400,
                "New password must be at least 8 characters long"
            );
        }

        // if (oldPassword === newPassword) {
        //     return sendErrorResponse(
        //         res,
        //         400,
        //         "New password cannot be the same as the old password"
        //     );
        // }

        let query: any = {};

        if (email) {
            query.email = email.trim().toLowerCase();
        } else {
            query.phone = phone.trim();
        }

        const user = await User.findOne(query).select("+password");

        if (!user) {
            return sendErrorResponse(res, 404, "User not found");
        }

        // const isMatch = await user.comparePassword(oldPassword);

        // if (!isMatch) {
        //     return sendErrorResponse(res, 401, "Old password is incorrect");
        // }

        user.password = newPassword;
        await user.save();

        // if (user.phone) {
        //     await sendWhatsappEvent({
        //         mobile: user.phone,
        //         event: "SEND_PASSWORD",
        //         variables: [user.email || user.phone],
        //     });
        // }

        return sendSuccessResponse(res, 200, "Password updated successfully");
    } catch (error) {
        console.error("Update Password Error:", error);
        return sendErrorResponse(res, 500, "Internal Server Error");
    }
};

export const logout = async (
    req: Request,
    res: Response
) => {
    try {
        // Detect Device

        const device =
            req.body?.deviceType === "mobile"
                ? "mobile"
                : "web";

        // Get Refresh Token

        let refreshToken:
            | string
            | undefined;

        if (device === "web") {
            refreshToken =
                req.cookies?.refreshToken;
        } else {
            refreshToken =
                req.body?.refreshToken ||
                req.headers[
                    "x-refresh-token"
                ]?.toString();
        }

        // Remove Stored Token

        if (refreshToken) {
            try {
                const decoded =
                    jwt.verify(
                        refreshToken,
                        process.env
                            .REFRESH_TOKEN_SECRET!
                    ) as {
                        id: string;
                    };

                const user =
                    await User.findById(
                        decoded.id
                    ).select(
                        "+refreshToken"
                    );

                if (
                    user &&
                    user.refreshToken ===
                    refreshToken
                ) {
                    user.refreshToken =
                        null;

                    await user.save();
                }
            } catch (error) {
                // Don't fail logout
                console.error(
                    "Logout token verification failed:",
                    error
                );
            }
        }

        // Clear Cookie

        if (device === "web") {
            res.clearCookie(
                "refreshToken",
                {
                    httpOnly: true,

                    secure:
                        process.env
                            .NODE_ENV ===
                        "production",

                    sameSite:
                        process.env
                            .NODE_ENV ===
                            "production"
                            ? "none"
                            : "lax",

                    path: "/",
                }
            );
        }

        // Success Response

        return sendSuccessResponse(
            res,
            200,
            "Logout successful"
        );
    } catch (error) {
        console.error(error);

        return sendErrorResponse(
            res,
            500,
            "Internal server error"
        );
    }
};

export const getAllUsers = async (req: Request, res: Response) => {
    try {
        // Get query params (default: page=1, limit=10)
        const page = parseInt(req.query.page as string) || 1;
        const limit = parseInt(req.query.limit as string) || 10;

        // Calculate how many records to skip
        const skip = (page - 1) * limit;

        // Fetch users with pagination
        const users = await User.find()
            .sort({ createdAt: -1 })
            .skip(skip)
            .limit(limit)
            .lean()
            .select("email phone authProvider progress image isDeactivated");

        // Total count for frontend pagination
        const totalUsers = await User.countDocuments();

        return sendSuccessResponse(res, 200, "Users retrieved successfully", {
            users,
            pagination: {
                total: totalUsers,
                page,
                limit,
                totalPages: Math.ceil(totalUsers / limit),
            }

        });
    } catch (error) {
        console.error("Get All Users Error:", error);
        return sendErrorResponse(res, 500, "Internal Server Error");
    }
};

// get user data for admin uses 
export const getAllUserData = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!mongoose.Types.ObjectId.isValid(id as string)) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const userExists = await User.exists({ _id: id });
        if (!userExists) {
            return sendErrorResponse(res, 404, "User not found");
        }

        const limit = Number(req.query.limit) || 20;

        const results = await Promise.allSettled([
            Caretaker.find({ user: id }).limit(limit).lean(),
            Address.find({ user: id }).lean(),
            BankReceipt.find({ user: id }).limit(limit).lean(),
            CDEC.find({ user: id }).lean(),
            MedicineQuotationRequest.find({ user: id }).lean(),
            ProformaInvoiceRequest.find({ user: id }).lean(),
            ImportLicenseRequest.find({ user: id }).lean(),
            DoctorDetails.find({ user: id }).lean(),
            KYC.find({ user: id }).select("status documents documentType documentNumber").lean(),
            Order.find({ user: id }).sort({ createdAt: -1 }).limit(limit).lean(),
            Patient.find({ user: id }).lean(),
            PrescribedMedicine.find({ user: id }).limit(limit).lean(),
            Prescription.find({ user: id }).limit(limit).lean(),
        ]);

        const [
            caretakers,
            addresses,
            bankReceipts,
            cdecs,
            // requestDocs,
            medicineQuotation,
            proformaInvoice,
            importLicense,
            doctorDetails,
            kycs,
            orders,
            patients,
            prescribedMedicines,
            prescriptions,
        ] = results.map(r => (r.status === "fulfilled" ? r.value : []));

        return sendSuccessResponse(res, 200, "User data retrieved successfully", {
            caretakers,
            addresses,
            bankReceipts,
            cdecs,
            // requestDocuments: requestDocs,
            medicineQuotation,
            proformaInvoice,
            importLicense,
            doctorDetails,
            kycs,
            orders,
            patients,
            prescribedMedicines,
            prescriptions,
        });
    } catch (error) {
        console.error("getAllUserData Error:", error);
        return sendErrorResponse(res, 500, "Internal Server Error");
    }
};

export const updateProgress = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;
        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized user");
        }
        const { progress } = req.body;

        if (!progress) {
            return sendErrorResponse(res, 400, "Progress value is required");
        }
        const validProgressValues = ["address_skipped", "address_added"]
        if (!validProgressValues.includes(progress)) {
            return sendErrorResponse(res, 400, "Invalid progress value");
        }
        const updateProgress = await User.findByIdAndUpdate(userId, { $set: { progress: progress } }, { new: true }).select("progress");

        if (!updateProgress) {
            return sendErrorResponse(res, 404, "User not found");
        }
        return sendSuccessResponse(res, 200, "Progress updated successfully", {
            progress: updateProgress.progress,
        });
    } catch (error) {

        console.error("Update Progress Error:", error);

        return sendErrorResponse(res, 500, "Internal Server Error");
    }
}

export const deactivateAccount = async (
    req: Request,
    res: Response
) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(
                res,
                401,
                "Unauthorized"
            );
        }

        const user = await User.findById(userId);

        if (!user) {
            return sendErrorResponse(
                res,
                404,
                "User not found"
            );
        }

        if (user.isDeactivated) {
            return sendErrorResponse(
                res,
                400,
                "Account already deactivated"
            );
        }

        user.isDeactivated = true;

        user.deactivatedAt = new Date();

        user.scheduledDeletionAt = new Date(
            Date.now() + 90 * 24 * 60 * 60 * 1000
        );

        user.refreshToken = null;

        await user.save();

        return sendSuccessResponse(
            res,
            200,
            "Account deactivated successfully"
        );
    } catch (error) {
        console.error(error);

        return sendErrorResponse(
            res,
            500,
            "Failed to deactivate account"
        );
    }
};

export const reactivateAccount = async (
    req: Request,
    res: Response
) => {
    try {
        const { id } = req.params;

        const user = await User.findById(id);

        if (!user) {
            return sendErrorResponse(
                res,
                404,
                "User not found"
            );
        }

        user.isDeactivated = false;
        user.deactivatedAt = null;
        user.scheduledDeletionAt = null;

        await user.save();

        return sendSuccessResponse(
            res,
            200,
            "Account reactivated successfully"
        );
    } catch (error) {
        return sendErrorResponse(
            res,
            500,
            "Failed to reactivate account"
        );
    }
};
