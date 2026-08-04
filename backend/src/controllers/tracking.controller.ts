import { Request, Response } from 'express';
import Order from "../models/order.model";
import OrderTracking from "../models/orderTracking.model";
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';

export const updateOrderTracking = async (req: Request, res: Response) => {
    try {
        const { orderId } = req.params;
        const { status, message } = req.body;

        if (!status || !message) {
            return sendErrorResponse(res, 400, "Status and message required.");
        }

        // Create a new tracking entry
        const tracking = await OrderTracking.create({
            order: orderId,
            status,
            message
        });

        // Push entry into order.tracking[]
        await Order.findByIdAndUpdate(orderId, {
            $push: { tracking: tracking._id }
        });

        return sendSuccessResponse(res, 200, "Tracking updated successfully.", tracking);
    } catch (error) {
        console.error("Update tracking error:", error);
        return sendErrorResponse(res, 500, "Internal server error");
    }
};