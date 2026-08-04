import { Request, Response } from "express";
import Patient from "../models/patient.model";
import { sendSuccessResponse, sendErrorResponse } from "../utils/response";


export const getAllPatients = async (req: Request, res: Response) => {
    try {
        // Get the page number from query params (e.g., /api/patients?page=2)
        // Default to page 1 if not provided
        const page = parseInt(req.query.page as string) || 1;
        const limit = 20;
        const skip = (page - 1) * limit;

        // Fetch 20 patients and the total count simultaneously
        const [patients, total] = await Promise.all([
            Patient.find()
                .populate("caretaker", "fullname phone") // Useful to know who the caretaker is
                .sort({ createdAt: -1 })
                .skip(skip)
                .limit(limit)
                .lean(),
            Patient.countDocuments()
        ]);

        // Send structured response
        return sendSuccessResponse(res, 200, "Patients retrieved successfully", {
            count: patients.length,
            total,
            currentPage: page,
            totalPages: Math.ceil(total / limit),
            patients
        });

    } catch (error) {
        console.error("Fetch Patients Error:", error);
        return sendErrorResponse(res, 500, "Internal Server Error");
    }
};

export const getPatientById = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!id) {
            return sendErrorResponse(res, 401, "Id is not exist");
        }

        // Fetch only patients where 'caretaker' field matches the ID
        const patients = await Patient.find({ caretaker: id })
            .sort({ createdAt: -1 }) // Newest patients first
            .lean(); // Faster execution, returns plain JSON

        return sendSuccessResponse(res, 200, "Patients retrieved successfully", {
            count: patients.length,
            patients
        });

    } catch (error) {
        console.error("Fetch Patients Error:", error);
        return sendErrorResponse(res, 500, "Internal Server Error");
    }
};

export const getPatientByUserId = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;


        if (!userId) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }


        const patient = await Patient.find({ user: userId })
            .sort({ createdAt: -1 })
            .lean();

        if (!patient) {
            return sendSuccessResponse(res, 200, "patient not found", null);
        }

        return sendSuccessResponse(
            res,
            200,
            "patient fetched successfully",
            patient
        );

    } catch (error: any) {
        console.error("patient error:", error);
        return sendErrorResponse(res, 500, "Server error while fetching patient");
    }
};