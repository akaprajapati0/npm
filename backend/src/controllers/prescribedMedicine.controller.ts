import { Request, Response } from 'express';
import mongoose from 'mongoose';
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import PrescribedMedicine from '../models/prescribedMedicine.model';
import User from '../models/user.model';
import { sendWhatsappEvent } from '../service/whatsApps';
import { ALLOWED_STATUSES, IUser, STATUS } from '../utils/status';

// --------- Add Prescribed Medicine Details ---------
export const createPrescribedMedicine = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized User?");
        }

        const {
            medicineName,
            strength,
            dosage,
            ActiveIngredients,
            manufacturer,
            quantity,
            packSize,
            storageConditions
        } = req.body;



        // Check user is exists
        const user = await User.findById(userId);
        if (!user) {
            return sendErrorResponse(res, 404, "User not found");
        }


        // Create the medicine entry
        const prescribedMedicine = new PrescribedMedicine({
            user: user.id,
            medicineName,
            strength,
            dosage,
            ActiveIngredients,
            manufacturer,
            quantity,
            packSize,
            storageConditions
        });

        // ------ Update progress ------
        await User.findByIdAndUpdate(user._id, {
            $set: {
                progress: "prescribed_uploaded",
            },
        });
        await prescribedMedicine.save();

        return sendSuccessResponse(res, 201, "Medicine added successfully");

    } catch (error) {
        console.error(error);
        return sendErrorResponse(res, 500, "Server Error");
    }
};


// -------- GET Count MEDICINES (FOR A PATIENT) --------
export const getMedicinesCount = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized User?");
        }

        const medicines = await PrescribedMedicine.countDocuments({ userId });

        // If no medicines found
        if (!medicines) {
            return sendSuccessResponse(res, 200, "No medicines found", []);
        }

        return sendSuccessResponse(
            res,
            200,
            "Medicines fetched successfully",
            medicines
        );
    } catch (error: any) {
        console.error("Get Medicines Error:", error);
        return sendErrorResponse(
            res,
            500,
            "Server error while fetching medicines"
        );
    }
};

export const getPrescribeMedByUserId = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const prescribeMed = await PrescribedMedicine.findOne({ user: userId })
            .sort({ createdAt: -1 })
            .lean().select("status");

        if (!prescribeMed) {
            return sendSuccessResponse(res, 200, "Prescribe Medicine not found", null);
        }

        return sendSuccessResponse(
            res,
            200,
            "Prescribe Medicine fetched successfully",
            prescribeMed,
        );
    } catch (error: any) {
        console.error("Prescribe Medicine error:", error);
        return sendErrorResponse(
            res,
            500,
            "Server error while fetching Prescribe Medicine"
        );
    }
};

export const updatePresMedicineByAdmin = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;
        const { status } = req.body;

        if (!id) {
            return sendErrorResponse(res, 400, "Prescribed Medicine ID is required");
        }

        if (!mongoose.Types.ObjectId.isValid(id as string)) {
            return sendErrorResponse(res, 400, "Invalid ID format");
        }

        if (!ALLOWED_STATUSES.includes(status)) {
            return sendErrorResponse(res, 400, "Invalid status value");
        }

        // Atomic update to prevent race condition
        const medicine = await PrescribedMedicine.findOneAndUpdate(
            { _id: id, status: { $ne: STATUS.APPROVED } },
            { status },
            { new: true }
        ).populate<{ user: IUser }>({ path: "user", select: "phone" });

        if (!medicine) {
            return sendErrorResponse(res, 409, "Already approved or not found");
        }

        const phone = medicine.user?.phone;
        const whatsappEvent =
            status === STATUS.APPROVED
                ? "CARETAKER_APPROVED"
                : status === STATUS.REJECTED
                    ? "CARETAKER_REJECTED"
                    : null;

        if (phone && whatsappEvent) {
            sendWhatsappEvent({
                mobile: phone,
                event: whatsappEvent,
                variables: []
            }).catch(err => console.error("WhatsApp failed:", err));
        }

        return sendSuccessResponse(res, 200, "Prescribed Medicine updated successfully", {
            medicine
        });

    } catch (err) {
        console.error(err);
        return sendErrorResponse(res, 500, "Server error");
    }
};

// ------- DELETE MEDICINE -------
export const deleteMedicine = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!id) {
            return sendErrorResponse(res, 400, "Medicine ID is required");
        }

        const deletedMedicine = await PrescribedMedicine.findByIdAndDelete(id);

        if (!deletedMedicine) {
            return sendErrorResponse(res, 404, "Medicine not found");
        }

        return sendSuccessResponse(res, 200, "Medicine deleted successfully");
    } catch (error: any) {
        console.error(error);
        return sendErrorResponse(res, 500, "Server error");
    }
};
