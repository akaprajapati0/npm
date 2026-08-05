import { Request, Response } from "express";
import { sendSuccessResponse, sendErrorResponse } from "../utils/response";
import Caretaker from "../models/caretaker.model";
import Patient from "../models/patient.model";
import User from "../models/user.model";
import patientModel from '../models/patient.model';
import { extractDocuments } from '../utils/normalizeDocuments';
import { generatePatientPassword } from "../utils/auth.utils";
import { PRPSmsService } from "../service/sendSMS";
import { sendEmail } from "../service/sendMail";
import { passwordTemplate } from "../service/emailTemplate";

const smsService = new PRPSmsService();

export const registerCaretaker = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Please login first");
        }

        const {
            fullname,
            email,
            relationship,
            country,
            city,
            pincode,
            phone,
            patient: patientPayload,
        } = req.body;

        // ---------- Basic Validation ----------
        if (
            !fullname ||
            !relationship ||
            !country ||
            !city ||
            !pincode ||
            // !phone ||
            !patientPayload
        ) {
            return sendErrorResponse(res, 400, "All fields are required");
        }

        // if (!/^\+\d{10,15}$/.test(phone)) {
        //     return sendErrorResponse(res, 400, "Invalid phone number format");
        // }

        if (email && !/^\S+@\S+\.\S+$/.test(email)) {
            return sendErrorResponse(res, 400, "Invalid email format");
        }

        // ---------- Patient Validation ----------
        const { fullname: pName, dateOfBirth, gender } = patientPayload;

        if (!pName || !dateOfBirth || !gender) {
            return sendErrorResponse(
                res,
                400,
                "Patient fullname, dateOfBirth and gender are required"
            );
        }

        let initialPassword: string;
        try {
            initialPassword = generatePatientPassword(pName, dateOfBirth);
        } catch {
            return sendErrorResponse(res, 400, "Invalid patient date ofBirth");
        }

        // ---------- Check User ----------
        const user = await User.findById(userId);
        if (!user) {
            return sendErrorResponse(res, 404, "User not found");
        }

        // ---------- Create Caretaker ----------
        const caretaker = await Caretaker.create({
            user: user._id,
            fullname,
            email,
            relationship,
            country,
            city,
            pincode,
            phone,
        });

        // ---------- Create Patient ----------
        const patient = await Patient.create({
            user: user._id,
            caretaker: caretaker._id,
            fullname: pName,
            dateOfBirth,
            gender,
        });

        // ---------- Update User ----------
        if (!user.patients.some((id: any) => id.toString() === patient._id.toString())) {
            user.patients.push(patient._id);
        }
        user.email = email || user.email;
        user.progress = "caretaker_uploaded";
        user.password = initialPassword;
        await user.save();

        const username = user.phone || user.email;
        if (user.phone) {
            smsService.sendOtp({
                mobile: user.phone,
                username,
                password: initialPassword,
                type: "password",
            }).catch((error) => {
                console.error("Initial password SMS failed:", error);
            });
        } else if (user.email) {
            sendEmail({
                to: user.email,
                subject: "Named Patient Program - Your Username and Password",
                html: passwordTemplate(initialPassword, username),
            }).catch((error) => {
                console.error("Initial password email failed:", error);
            });
        }

        return sendSuccessResponse(
            res,
            201,
            "Caretaker registered successfully",
            {
                caretaker: {
                    id: caretaker._id,
                    name: caretaker.fullname,
                    email: caretaker.email,
                },
            }
        );
    } catch (err) {
        console.error("Register caretaker error:", err);
        return sendErrorResponse(res, 500, "Internal server error");
    }
};

export const getCaretakerProfile = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;
        if (!userId) {
            return sendErrorResponse(res, 401, "You have not caretaker id");
        }
        const caretaker = await Caretaker.findOne({ user: userId }).lean();
        const patient = await patientModel.findOne({ user: userId }).lean()
        if (!caretaker) return sendErrorResponse(res, 404, "Data is not found");
        return sendSuccessResponse(res, 200, "User fetched", { patient, caretaker });
    } catch (error) {
        console.error("auth/me error:", error);
        return sendErrorResponse(res, 500, "Server Error");
    }
}

export const updateCaretaker = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any)?.id || (req.user as any)?._id || req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Please login first");
        }

        const { caretakerId } = req.params;
        if (!caretakerId) {
            return sendErrorResponse(res, 400, "Caretaker ID is required");
        }

        const { fullname, email, relationship, country, city, pincode, phone } = req.body;

        const parsedPatient = JSON.parse(req.body.patient);
        const { fullname: patientName, dateOfBirth, gender, patientId } = parsedPatient;

        // ---------- Basic Validation ----------
        if (!fullname || !relationship || !country || !city || !pincode || !phone || !parsedPatient) {
            return sendErrorResponse(res, 400, "All fields are required");
        }

        const phoneRegex = /^\+\d{10,15}$/;
        const emailRegex = /^\S+@\S+\.\S+$/;

        if (!phoneRegex.test(phone)) {
            return sendErrorResponse(res, 400, "Invalid phone number format");
        }

        if (email && !emailRegex.test(email)) {
            return sendErrorResponse(res, 400, "Invalid email format");
        }

        // ---------- Patient Validation ----------
        if (!patientId || !patientName || !dateOfBirth || !gender) {
            return sendErrorResponse(res, 400, "Patient ID, fullname, dateOfBirth and gender are required");
        }

        // ---------- Extract Documents ----------
        const documents = extractDocuments(req);
        const image = documents?.[0];

        // ---------- Find User ----------
        const user = await User.findById(userId);
        if (!user) {
            return sendErrorResponse(res, 404, "User not found");
        }

        // ---------- Find Caretaker ----------
        const caretaker = await Caretaker.findOne({ _id: caretakerId, user: user._id });
        if (!caretaker) {
            return sendErrorResponse(res, 404, "Caretaker not found");
        }

        // ---------- Find Patient ----------
        const patient = await Patient.findOne({
            _id: patientId,
            caretaker: caretaker._id,
            user: user._id,
        });
        if (!patient) {
            return sendErrorResponse(res, 404, "Patient not found");
        }

        // ---------- Update User ----------
        if (image) user.image = image;
        if (email) user.email = email;
        await user.save();

        // ---------- Update Caretaker ----------
        caretaker.fullname = fullname;
        caretaker.email = email;
        caretaker.relationship = relationship;
        caretaker.country = country;
        caretaker.city = city;
        caretaker.pincode = pincode;
        caretaker.phone = phone;
        await caretaker.save();

        // ---------- Update Patient ----------
        patient.fullname = patientName;
        patient.dateOfBirth = dateOfBirth;
        patient.gender = gender;
        await patient.save();

        return sendSuccessResponse(res, 200, "Caretaker updated successfully", {
            caretaker: {
                id: caretaker._id,
                fullname: caretaker.fullname,
                email: caretaker.email,
            },
            patient: {
                id: patient._id,
                fullname: patient.fullname,
            },
        });

    } catch (err) {
        console.error("Update caretaker error:", err);
        return sendErrorResponse(res, 500, "Internal server error");
    }
};

export const deleteCaretaker = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!id) {
            return sendErrorResponse(res, 401, "Unauthorized caretaker");
        }

        // Find caretaker
        const caretaker = await Caretaker.findById(id);
        if (!caretaker) {
            return sendErrorResponse(res, 404, "Caretaker not found");
        }

        //    Delete all patients linked to caretaker
        await Patient.deleteMany({ caretaker: id });

        //  Delete caretaker

        await Caretaker.findByIdAndDelete(id);

        return sendSuccessResponse(res, 200, "Caretaker deleted successfully");
    } catch (err: any) {
        return sendErrorResponse(res, 500, "Server error");
    }
};
