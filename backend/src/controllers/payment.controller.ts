import { Request, Response } from "express";
import Payment from "../models/payment.model";
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import mongoose from 'mongoose';

// Create Payment Details
export const createPayment = async (req: Request, res: Response) => {
    try {
        const {
            user,
            paymentReceived,
            paymentLeft,
            accountNumber,
            ifsc,
            branch,
        } = req.body;

        if (!user) {
            return res.status(400).json({
                success: false,
                message: "User ID is required",
            });
        }

        await Payment.create({
            user,
            paymentReceived,
            paymentLeft,
            accountNumber,
            ifsc,
            branch,
        });

        return sendSuccessResponse(res, 201, "Payment details created successfully")
    } catch (error: any) {
        console.log("Create Payment Error:", error);

        return sendErrorResponse(res, 500, "Error in payment creation")
    }
};

// Get All Payments
export const getAllPayments = async (
    req: Request,
    res: Response
) => {
    try {
        const payments = await Payment.find()
            .sort({ createdAt: -1 }).lean();

        return sendSuccessResponse(res, 200, "Payment details retrieved successfully", payments)
    } catch (error: any) {
        console.log("Get Payments Error:", error);

        return sendErrorResponse(res, 500, "Error in payment fetching")

    }
};

// Get Single Payment
export const getSinglePayment = async (
    req: Request,
    res: Response
) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;


        const payment = await Payment.findOne({ user: userId })
            .sort({ createdAt: -1 })
            .lean();

        if (!payment) {
            return sendErrorResponse(
                res,
                404,
                "Payment Details is not exist"
            );
        }

        return sendSuccessResponse(
            res,
            200,
            "Payment retrieved successfully",
            payment
        );

    } catch (error: any) {
        console.log("Get Single Payment Error:", error);

        return sendErrorResponse(res, 500, "Error in payment fetching")

    }
};

export const getPaymentsByAdmin = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!id) {
            return sendErrorResponse(res, 400, "User ID is required");
        }

        if (!mongoose.Types.ObjectId.isValid(id as string)) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const payments = await Payment.find({ user: id })
            .sort({ createdAt: -1 })
            .lean();

        if (!payments.length) {
            return sendErrorResponse(res, 404, "No payment records found");
        }

        return sendSuccessResponse(
            res,
            200,
            "Payments retrieved successfully",
            payments
        );
    } catch (error: unknown) {
        console.error("getPaymentsByAdmin error:", error);
        return sendErrorResponse(res, 500, "Error fetching payments");
    }
};
