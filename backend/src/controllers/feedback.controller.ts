import mongoose from 'mongoose';
import { Request, Response } from "express";
import { Feedback } from "../models/feedback.model";
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';

export const submitFeedback = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Please login first");
        }

        const { rating, feedback, followUp } = req.body;

        // Validation
        if (!rating) {
            return sendErrorResponse(res, 400, "Rating is required")
        }

        if (rating < 1 || rating > 5) {
            return sendErrorResponse(res, 400, "Rating must be between 1 and 5")
        }

        // Save to DB
        await Feedback.create({
            user: userId,
            rating,
            feedback,
            followUp,
        });

        return sendSuccessResponse(
            res,
            201, "Feedback submitted successfully", {
            success: true
        })
    } catch (error) {
        console.error("Feedback Error:", error);

        return res.status(500).json({
            success: false,
            message: "Something went wrong",
        });
    }
};

export const getUserFeedback = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!id) {
            return sendErrorResponse(res, 400, "User ID is required");
        }

        if (!mongoose.Types.ObjectId.isValid(id as string)) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const feedback = await Feedback.find({ user: id })
            .sort({ createdAt: -1 })
            .lean();

        return sendSuccessResponse(
            res,
            200,
            "Feedback retrieved successfully",
            feedback
        );
    } catch (error: unknown) {
        console.error("getUserFeedback error:", error);

        return sendErrorResponse(res, 500, "Something went wrong while fetching feedback");
    }
};
