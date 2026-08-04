import jwt from 'jsonwebtoken';
import bcrypt from "bcryptjs";
import { Request, Response } from "express";
import Admin from "../models/admin.model";
import { adminAccessToken, adminRefreshToken } from '../utils/token';
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import User from '../models/user.model';
import { AuthRequest } from '../middleware/authMiddleware';

export const createAdmin = async (req: Request, res: Response) => {
    try {
        const { fullname, email, password, role, expiresAt } = req.body;

        // Validate role
        if (!["ADMIN", "TEMP_ADMIN"].includes(role)) {
            return sendErrorResponse(res, 400, "Invalid role");
        }

        // Validate required fields
        if (!email || !password || !fullname) {
            return sendErrorResponse(res, 400, "Email and password are required");
        }

        // Check duplicate email
        const existing = await Admin.findOne({ email });
        if (existing) {
            return sendErrorResponse(res, 409, "Admin already exists");
        }

        // Validate TEMP_ADMIN expiry
        let parsedExpiry: Date | undefined;

        if (role === "TEMP_ADMIN") {
            if (!expiresAt) {
                return sendErrorResponse(res, 400, "expiresAt is required for TEMP_ADMIN");
            }

            parsedExpiry = new Date(expiresAt);

            if (isNaN(parsedExpiry.getTime())) {
                return sendErrorResponse(res, 400, "Invalid expiresAt format");
            }

            if (parsedExpiry <= new Date()) {
                return sendErrorResponse(res, 400, "Expiry must be in the future");
            }
        }

        // Hash password
        const hashedPassword = await bcrypt.hash(password, 10);

        // Create admin
        const newAdmin = await Admin.create({
            fullname,
            email,
            password: hashedPassword,
            role,
            expiresAt: parsedExpiry,
        });

        console.log("MODEL FILE:", require.resolve('../models/admin.model'));
        // Remove sensitive data
        const adminResponse = {
            id: newAdmin._id,
            fullname: newAdmin.fullname,
            email: newAdmin.email,
            role: newAdmin.role,
            expiresAt: newAdmin.expiresAt,
        };

        // Consistent response shape
        return sendSuccessResponse(
            res,
            201,
            "Admin created successfully",
            { admin: adminResponse }
        );
    } catch (err) {
        console.error("Create admin error:", err);
        return sendErrorResponse(res, 500, "Error creating admin");
    }
};

export const loginAdmin = async (req: Request, res: Response) => {
    try {
        const { email, password } = req.body;

        const admin = await Admin.findOne({ email });

        if (!admin) {
            return sendErrorResponse(res, 401, "Invalid credentials");
        }

        // Check active
        if (!admin.isActive) {
            return sendErrorResponse(res, 403, "Account is inactive");
        }

        // TEMP_ADMIN expiry check
        if (
            admin.role === "TEMP_ADMIN" &&
            admin.expiresAt &&
            admin.expiresAt < new Date()
        ) {
            return sendErrorResponse(res, 403, "Temporary admin access expired");
        }

        // Password match
        const isMatch = await bcrypt.compare(password, admin.password);
        if (!isMatch) {
            return sendErrorResponse(res, 401, "Invalid credentials");
        }

        // Tokens
        const accessToken = adminAccessToken(admin);
        const refreshToken = adminRefreshToken(admin);

        // Store refresh token in DB
        admin.refreshToken = refreshToken;
        await admin.save();

        // Set HTTP-only cookie (DO NOT return token in body)
        res.cookie(
            "adminRefreshToken",
            refreshToken,
            {
                httpOnly: true,
                secure: true,
                sameSite: "none",
                maxAge:
                    7 * 24 * 60 * 60 * 1000,
            }
        );

        // Clean admin response (NO password, NO refreshToken)
        const adminResponse = {
            id: admin._id,
            fullname: admin.fullname,
            email: admin.email,
            role: admin.role,
            expiresAt: admin.expiresAt,
        };

        // Correct response shape (frontend-compatible)
        return sendSuccessResponse(res, 200, "Login successful", {
            accessToken,
            admin: adminResponse,
        });
    } catch (error) {
        console.error("Login error:", error);
        return sendErrorResponse(res, 500, "Error logging in admin");
    }
};

export const getAllAdmins = async (req: Request, res: Response) => {
    try {
        const now = new Date();

        // "expiring soon" window (3 days)
        const SOON_DAYS = 2;
        const soonDate = new Date();
        soonDate.setDate(now.getDate() + SOON_DAYS);

        // last 7 days window
        const lastWeekDate = new Date();
        lastWeekDate.setDate(now.getDate() - 7);

        // Fetch active admins
        const adminsRaw = await Admin.find({ isActive: true })
            .select("-password -refreshToken")
            .sort({ createdAt: -1 });

        // Add expiry flags
        const admins = adminsRaw.map((admin) => {
            const isTemp = admin.role === "TEMP_ADMIN";

            let isExpired = false;
            let isExpiringSoon = false;

            if (isTemp && admin.expiresAt) {
                isExpired = admin.expiresAt < now;

                isExpiringSoon =
                    admin.expiresAt >= now && admin.expiresAt <= soonDate;
            }

            return {
                ...admin.toObject(),
                isExpired,
                isExpiringSoon,
            };
        });

        // Expiring soon count
        const expiringSoonCount = admins.filter(
            (admin) => admin.isExpiringSoon
        ).length;

        // Counts (parallel)
        const [
            totalAdmins,
            totalUsers,
            activeAdmins,
            inActiveAdmins,
            totalTempAdmins,
            totalPermanentAdmins,
            lastWeekUsers,
        ] = await Promise.all([
            Admin.countDocuments(),
            User.countDocuments(),
            Admin.countDocuments({ isActive: true }),
            Admin.countDocuments({ isActive: false }),
            Admin.countDocuments({ role: "TEMP_ADMIN", isActive: true }),
            Admin.countDocuments({ role: "ADMIN", isActive: true }),

            // last week users
            User.countDocuments({
                createdAt: { $gte: lastWeekDate },
            }),
        ]);

        return sendSuccessResponse(
            res,
            200,
            "Admins fetched successfully",
            {
                admins,
                stats: {
                    totalAdmins,
                    totalUsers,
                    activeAdmins,
                    inActiveAdmins,
                    totalPermanentAdmins,
                    totalTempAdmins,
                    expiringSoon: expiringSoonCount,
                    lastWeekUsers,
                },
            }
        );
    } catch (error) {
        console.error("Get admins error:", error);
        return sendErrorResponse(res, 500, "Error fetching admins");
    }
};

export const getAdminById = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        const admin = await Admin.findById(id).select(
            "-password -refreshToken"
        );

        if (!admin || !admin.isActive) {
            return sendErrorResponse(res, 404, "Admin not found or inactive");
        }

        // expiry flags (same logic as list)
        const now = new Date();
        const soonDate = new Date();
        soonDate.setDate(now.getDate() + 2);

        let isExpired = false;
        let isExpiringSoon = false;

        if (admin.role === "TEMP_ADMIN" && admin.expiresAt) {
            isExpired = admin.expiresAt < now;
            isExpiringSoon =
                admin.expiresAt >= now && admin.expiresAt <= soonDate;
        }

        return sendSuccessResponse(
            res,
            200,
            "Admin fetched successfully",
            {
                admin: {
                    ...admin.toObject(),
                    isExpired,
                    isExpiringSoon,
                },
            }
        );
    } catch (error) {
        console.error("Get admin error:", error);
        return sendErrorResponse(res, 500, "Error fetching admin");
    }
};

export const updateAdmin = async (req: AuthRequest, res: Response) => {
    try {
        const adminId = req.params.id;
        const requester = req.admin;

        const { fullname, email, password, role, expiresAt, isActive } = req.body;

        // Only SUPER_ADMIN can update
        if (requester.role !== "SUPER_ADMIN") {
            return sendErrorResponse(res, 403, "Only Super Admin can update admins");
        }

        const admin = await Admin.findById(adminId);

        if (!admin) {
            return sendErrorResponse(res, 404, "Admin not found");
        }

        // Prevent updating SUPER_ADMIN
        if (admin.role === "SUPER_ADMIN") {
            return sendErrorResponse(res, 403, "Super Admin cannot be updated");
        }

        // Prevent self-update (optional but safer)
        if (admin._id.toString() === requester._id.toString()) {
            return sendErrorResponse(res, 400, "You cannot update yourself");
        }

        // Update fields (only if provided)
        if (fullname) admin.fullname = fullname;

        if (email) admin.email = email;

        if (role) {
            if (!["ADMIN", "TEMP_ADMIN"].includes(role)) {
                return sendErrorResponse(res, 400, "Invalid role");
            }

            admin.role = role;

            // handle expiry based on role
            if (role === "TEMP_ADMIN") {
                if (!expiresAt) {
                    return sendErrorResponse(
                        res,
                        400,
                        "Expiry date is required for TEMP_ADMIN"
                    );
                }
                admin.expiresAt = new Date(expiresAt);
            } else {
                admin.expiresAt = undefined;
            }
        }

        if (typeof isActive === "boolean") {
            admin.isActive = isActive;
        }

        // Password update
        if (password) {
            const hashed = await bcrypt.hash(password, 10);
            admin.password = hashed;
        }

        admin.refreshToken = undefined;
        await admin.save();

        return sendSuccessResponse(res, 200, "Admin updated successfully", {
            admin,
        });
    } catch (error) {
        console.error("Update admin error:", error);
        return sendErrorResponse(res, 500, "Error updating admin");
    }
};

export const deleteAdmin = async (req: any, res: Response) => {
    try {
        const adminId = req.params.id;

        // requester (from auth middleware)
        const requester = req.admin;

        // Only SUPER_ADMIN can delete
        if (requester.role !== "SUPER_ADMIN") {
            return sendErrorResponse(res, 403, "Only Super Admin can delete admins");
        }

        const admin = await Admin.findById(adminId);

        if (!admin) {
            return sendErrorResponse(res, 404, "Admin not found");
        }

        // Prevent deleting SUPER_ADMIN
        if (admin.role === "SUPER_ADMIN") {
            return sendErrorResponse(res, 403, "Super Admin cannot be deleted");
        }

        // Prevent self-delete (recommended)
        if (admin._id.toString() === requester._id.toString()) {
            return sendErrorResponse(res, 400, "You cannot delete yourself");
        }

        // Soft delete (recommended)
        admin.isActive = false;
        admin.refreshToken = undefined;
        await admin.save();

        // 🔥 OR hard delete (if you prefer)
        // await Admin.findByIdAndDelete(adminId);

        return sendSuccessResponse(res, 200, "Admin deleted successfully");
    } catch (error) {
        console.error("Delete admin error:", error);
        return sendErrorResponse(res, 500, "Error deleting admin");
    }
};

export const refreshTokenHandler = async (req: Request, res: Response) => {
    const refreshToken = req.cookies?.adminRefreshToken;

    if (!refreshToken) {
        return sendErrorResponse(
            res,
            401,
            "Refresh token missing"
        );
    }

    try {
        const decoded = jwt.verify(
            refreshToken,
            process.env.ADMIN_REFRESH_SECRET!
        ) as { id: string };

        const admin = await Admin.findById(
            decoded.id
        ).select("+refreshToken");

        if (
            !admin ||
            admin.refreshToken !== refreshToken
        ) {
            return sendErrorResponse(
                res,
                403,
                "Invalid refresh token"
            );
        }

        const newAccessToken =
            adminAccessToken(admin);

        const newRefreshToken =
            adminRefreshToken(admin);

        admin.refreshToken =
            newRefreshToken;

        await admin.save();

        res.cookie(
            "adminRefreshToken",
            newRefreshToken,
            {
                httpOnly: true,
                secure: true,
                sameSite: "none",
                maxAge:
                    7 * 24 * 60 * 60 * 1000,
            }
        );

        return sendSuccessResponse(
            res,
            200,
            "Token refreshed successfully",
            {
                accessToken:
                    newAccessToken,
            }
        );
    } catch {
        return sendErrorResponse(
            res,
            403,
            "Invalid or expired token"
        );
    }
};

export const logoutAdmin = async (req: any, res: any) => {
    try {
        const admin = await Admin.findById(req.admin._id).select("+refreshToken");
        if (!admin) {
            return res.status(404).json({ message: "Admin not found" });
        }

        admin.refreshToken = undefined;
        await admin.save();

        res.clearCookie("refreshToken", {
            httpOnly: true,
            secure: true,
            sameSite: "none",
        });

        return sendSuccessResponse(res, 200, "Logged out successfully");
    } catch (error) {
        return sendErrorResponse(res, 500, "Error logging out admin");
    }
};