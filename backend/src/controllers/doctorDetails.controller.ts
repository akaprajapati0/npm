import { Request, Response } from 'express';
import mongoose from 'mongoose';
import User from '../models/user.model';
import Caretaker from '../models/caretaker.model';
import DoctorDetails from '../models/doctorDetails.model';
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import { sendWhatsappEvent } from '../service/whatsApps';

// --------- CREATE DOCTOR ---------
export const createDoctorDetails = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        const {
            fullname,
            specialization,
            clinicName,
            country,
            city,
            doctorRegistrationNumber,
            email
        } = req.body;

        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized");
        }

        if (!fullname || !clinicName) {
            return sendErrorResponse(res, 400, "Please provide required fields");
        }

        //  Check caretaker is exists
        const user = await User.findById(userId);

        if (!user) {
            return sendErrorResponse(res, 404, "User not found");
        }

        const caretaker = await Caretaker.findOne({ user: user.id });

        const newDoctor = await DoctorDetails.create({
            user: user._id,
            fullname,
            specialization,
            clinicName,
            country,
            city,
            doctorRegistrationNumber,
            email
        });


        await User.findByIdAndUpdate(user._id, {
            $set: {
                progress: "doctor_uploaded"
            },
        });

        if (user.phone)
            await sendWhatsappEvent({
                mobile: user.phone,
                event: "DOCTOR_PROFILE_COMPLETED",
                variables: [caretaker?.fullname || "Dear"]
            });

        return sendSuccessResponse(res, 201, "Doctor added successfully", {
            doctor: newDoctor
        });
    } catch (error: any) {
        console.log(error)
        return sendErrorResponse(res, 500, "Server error");
    }
};

// ----------- GET ALL DOCTORS (BY PATIENT) -----------
export const getDoctorByUserId = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const doctor = await DoctorDetails.findOne({ user: userId })
            .sort({ createdAt: -1 })
            .lean().select("status");

        if (!doctor) {
            return sendSuccessResponse(res, 200, "Doctor details not found", null);
        }

        return sendSuccessResponse(
            res,
            200,
            "Doctor details fetched successfully",
            doctor,
        );
    } catch (error: any) {
        console.error("Doctor details error:", error);
        return sendErrorResponse(
            res,
            500,
            "Server error while fetching Doctor details"
        );
    }
};

// ------ Doctor Count ------- 
export const getDoctorCount = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized User?");
        }

        const doctor = await DoctorDetails.countDocuments({ userId });

        // If no medicines found
        if (!doctor) {
            return sendSuccessResponse(res, 200, "No Doctor found", []);
        }

        return sendSuccessResponse(
            res,
            200,
            "Doctor details fetched successfully",
            doctor
        );
    } catch (error: any) {
        console.error("Get Doctor Error:", error);
        return sendErrorResponse(
            res,
            500,
            "Server error while fetching doctor"
        );
    }
};

// ---------------------- DELETE DOCTOR ----------------------
export const deleteDoctor = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        // Validate Mongo ObjectId
        if (!mongoose.Types.ObjectId.isValid(id as string)) {
            return sendErrorResponse(res, 400, "Invalid doctor id");
        }

        // Delete doctor
        const deleted = await DoctorDetails.findByIdAndDelete(id);

        if (!deleted) {
            return sendErrorResponse(res, 404, "Doctor not found");
        }

        return sendSuccessResponse(
            res,
            200,
            "Doctor deleted successfully"
        );

    } catch (error: any) {
        console.error("deleteDoctor error:", error);
        return sendErrorResponse(res, 500, "Server error while deleting doctor");
    }
};
