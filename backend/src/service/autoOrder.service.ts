import { Types } from "mongoose";
import PrescribedMedicine from "../models/prescribedMedicine.model";
import DoctorDetails from "../models/doctorDetails.model";
import Prescription from "../models/prescription.model";
import KYC from "../models/kyc.model";
import CDEC from "../models/cdec.model";
import Order from "../models/order.model";
import OrderTracking from "../models/orderTracking.model";
import User from '../models/user.model';

function generateOrderNumber(): string {
    return `ORD-${Date.now()}-${Math.random().toString(36).slice(2, 6)}`;
}

export const autoOrderCheck = async (userId: string) => {
    try {
        if (!Types.ObjectId.isValid(userId)) {
            return { success: false, message: "Invalid userId" };
        }

        // Fetch minimal required data in parallel
        const [
            user,
            medicines,
            doctor,
            prescription,
            kyc,
            cdec,
            // bankReceipt
        ] = await Promise.all([
            User.findById(userId, { patients: 1, orders: 1 }).lean(),
            PrescribedMedicine.find({ user: userId }).lean(),
            DoctorDetails.exists({ user: userId }),
            Prescription.exists({ user: userId }),
            KYC.exists({ user: userId }),
            CDEC.exists({ user: userId }),
            // BankReceipt.exists({ user: userId }),
        ]);

        // Fast exits (cheap checks first)
        if (!user) {
            return { success: false, message: "No patient assigned" };
        }

        if (!medicines.length || !prescription) {
            return { success: false, message: "Prescription incomplete" };
        }

        // Missing checks (no full docs needed)
        const missing: string[] = [];
        if (!doctor) missing.push("Doctor Details");
        if (!kyc) missing.push("KYC");
        if (!cdec) missing.push("CDEC");
        // if (!bankReceipt) missing.push("Bank Receipt");

        if (missing.length > 0) {
            return { success: false, message: "Missing requirements", missing };
        }

        // Prepare items safely
        const items = medicines.map(med => ({
            medicineId: med._id,
            medicineName: med.medicineName,
            dosage: med.dosage || "",
            quantity: med.packSize ?? "1"
        }));

        if (!items.length) {
            return { success: false, message: "No valid medicines found" };
        }

        // Idempotent order creation (relies on DB unique index)
        const orderNumber = generateOrderNumber();
        let order;
        try {
            order = await Order.create({
                user: userId,
                orderNumber,
                status: "pending",
                items
            });
        } catch (err: any) {
            // Duplicate order prevented by unique index
            if (err.code === 11000) {
                return {
                    success: false,
                    message: "Active order already exists (idempotent protection)"
                };
            }
            throw err;
        }

        // Fire-and-forget tracking (non-blocking)
        OrderTracking.create({
            order: order._id,
            orderNumber,
            status: "order_created",
            message: "Order auto-generated after completing all required steps."
        }).catch(err => {
            console.error("Tracking creation failed:", err);
        });

        // Async user update (non-blocking)
        User.updateOne(
            { _id: userId },
            { $addToSet: { orders: order._id } }
        ).catch(err => {
            console.error("User update failed:", err);
        });

        return { success: true, orderId: order._id };

    } catch (error) {
        console.error("Auto order failed:", error);

        return {
            success: false,
            message: "Auto order failed",
            error: error instanceof Error ? error.message : error
        };
    }
};