import { Request, Response } from 'express';
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import Order from "../models/order.model";
import mongoose from 'mongoose';
import User from '../models/user.model';

export const createOrderDetailsByAdmin = async (req: Request, res: Response) => {
    try {
        const { userId, invoiceAmount, payments } = req.body as {
            userId: string;
            invoiceAmount: number;
            payments?: { amount: number; receivedOn?: string }[];
        };

        if (!userId) {
            return sendErrorResponse(res, 400, "User ID is required");
        }

        if (!mongoose.Types.ObjectId.isValid(userId)) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        if (invoiceAmount === undefined || invoiceAmount === null || isNaN(Number(invoiceAmount))) {
            return sendErrorResponse(res, 400, "Invoice amount is required");
        }

        if (Number(invoiceAmount) < 0) {
            return sendErrorResponse(res, 400, "Invoice amount cannot be negative");
        }

        if (payments && !Array.isArray(payments)) {
            return sendErrorResponse(res, 400, "Payments must be an array");
        }

        const sanitizedPayments = (payments ?? []).map((p, index) => {
            const amount = Number(p?.amount);

            if (isNaN(amount) || amount <= 0) {
                throw new Error(`Invalid amount at payment index ${index}`);
            }

            // receivedOn is admin-supplied (backdating is a real use case here),
            // but still validated — never trust a raw string straight into Mongo.
            const receivedOn = p?.receivedOn ? new Date(p.receivedOn) : new Date();

            if (isNaN(receivedOn.getTime())) {
                throw new Error(`Invalid date at payment index ${index}`);
            }

            return { amount, receivedOn };
        });

        const user = await User.findById(userId).select("_id");

        if (!user) {
            return sendErrorResponse(res, 404, "User does not exist");
        }

        const order = await Order.create({
            user: user._id,
            invoiceAmount: Number(invoiceAmount),
            payments: sanitizedPayments,
        });

        return sendSuccessResponse(res, 201, "Order details created successfully", order);
    } catch (error: unknown) {
        console.error("createOrderDetailsByAdmin error:", error);

        if (error instanceof Error && (error.message.startsWith("Invalid amount") || error.message.startsWith("Invalid date"))) {
            return sendErrorResponse(res, 400, error.message);
        }

        return sendErrorResponse(res, 500, "Server error creating the order details");
    }
};

export const getOrdersByUser = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;


        if (!userId) {
            return sendErrorResponse(res, 400, "User ID is required");
        }

        if (!mongoose.Types.ObjectId.isValid(userId)) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const orders = await Order.find({ user: userId }).lean();

        return sendSuccessResponse(
            res,
            200,
            "Orders retrieved successfully",
            orders
        );
    } catch (error: unknown) {
        console.error("getOrdersByUser error:", error);
        return sendErrorResponse(res, 500, "Server error fetching orders");
    }
};

export const getOrdersByAdmin = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (!id) {
            return sendErrorResponse(res, 400, "User ID is required");
        }

        if (!mongoose.Types.ObjectId.isValid(id as string)) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const orders = await Order.find({ user: id }).lean();

        return sendSuccessResponse(
            res,
            200,
            "Orders retrieved successfully",
            orders
        );
    } catch (error) {
        console.error("getOrdersByAdmin error:", error);
        return sendErrorResponse(res, 500, "Server error fetching orders");
    }
};
