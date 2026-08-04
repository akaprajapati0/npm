import { Request, Response } from "express";
import User from "../models/user.model";
import { sendErrorResponse, sendSuccessResponse } from "../utils/response";
import Address from '../models/address.model';

export const createAddress = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;


        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized");
        }

        if (req.body.checkMark !== true) {
            return sendErrorResponse(
                res,
                400,
                "Delivery address confirmation is required"
            );
        }

        const user = await User.findById(userId).populate("patients");

        if (!user) {
            return sendErrorResponse(res, 404, "Caretaker not found");
        }


        const address = await Address.create(
            {
                ...req.body,
                user: userId,
            },
        );

        // ------- Update  progress -------
        const updatedUser = await User.findByIdAndUpdate(user._id, {
            $set: {
                progress: "address_added",
            },
        });

        if (!updatedUser) {
            return sendErrorResponse(res, 404, "Address not added");
        }


        return sendSuccessResponse(
            res,
            201,
            "Address added successfully",
            address
        );
    } catch (error: any) {

        console.error("CREATE ADDRESS ERROR:", error);

        return sendErrorResponse(res, 500, "Server Error");
    }
};

export const getAddressByUserId = async (req: Request, res: Response) => {
    try {
        const userId = (req.user as any).id || (req.user as any)._id || req.user;

        if (!userId) {
            return sendErrorResponse(res, 400, "Invalid user ID");
        }

        const address = await Address.find({ user: userId })
            .sort({ createdAt: -1 })
            .lean();

        if (!address) {
            return sendSuccessResponse(res, 200, "address details not found", null);
        }

        return sendSuccessResponse(
            res,
            200,
            "address details fetched successfully",
            address
        );

    } catch (error: any) {
        console.error("address error:", error);
        return sendErrorResponse(res, 500, "Server error while fetching address details");
    }
}