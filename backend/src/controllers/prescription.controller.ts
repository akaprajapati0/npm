import { Request, Response } from "express";
import mongoose from 'mongoose';
import { sendErrorResponse, sendSuccessResponse } from "../utils/response";
import Prescription from "../models/prescription.model";
import { extractDocuments } from '../utils/normalizeDocuments';
import User from '../models/user.model';
import { sendWhatsappEvent } from '../service/whatsApps';
import { ALLOWED_STATUSES, IUser, STATUS } from '../utils/status';

// Submit a new prescription
export const submitPrescription = async (req: Request, res: Response) => {
  try {
    const userId = (req.user as any).id || (req.user as any)._id || req.user;

    if (!userId) {
      return sendErrorResponse(res, 401, "Unauthorized User?");
    }

    //  -------- NORMALIZED DOCUMENTS --------
    const documents = extractDocuments(req);

    // ---------- VALIDATION ----------
    if (documents.length === 0) {
      return sendErrorResponse(
        res,
        400,
        "At least one prescription document is required"
      );
    }

    // ---------- CHECK User & PATIENT ----------
    const user = await User.findById(userId)
      .select("_id phone email")
      .lean<{
        _id: string;
        phone?: string;
        email?: string;
      }>();

    if (!user) {
      return sendErrorResponse(res, 404, "User not found");
    }

    // ---------- CREATE PRESCRIPTION ----------
    const prescription = await Prescription.create({
      user: user._id,
      documents,
    });

    await User.findByIdAndUpdate(user._id, {
      $set: {
        progress: "prescription_uploaded",
      },
    });

    if (user.phone)
      await sendWhatsappEvent({
        mobile: user.phone,
        event: "PRESCRIPTION_UPLOADED",
        // variables: ["Prescription Documents", "test"]
      });

    return sendSuccessResponse(
      res,
      201,
      "Prescription uploaded successfully",
      prescription
    );
  } catch (error) {
    console.error("PRESCRIPTION CREATE ERROR:", error);
    return sendErrorResponse(res, 500, "Server Error");
  }
};

// Get prescription by ID
export const getPrescriptionByUserId = async (req: Request, res: Response) => {
  try {
    const userId =
      (req.user as any)?.id ||
      (req.user as any)?._id ||
      req.user;

    if (!userId) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }

    const prescription = await Prescription.findOne({ user: userId })
      .sort({ createdAt: -1 })
      .lean().select("status");

    if (!prescription) {
      return sendSuccessResponse(res, 200, "prescription not found", null);
    }

    return sendSuccessResponse(
      res,
      200,
      "Prescribe fetched successfully",
      prescription,
    );
  } catch (error: any) {
    console.error("prescription error:", error);
    return sendErrorResponse(
      res,
      500,
      "Server error while fetching prescription"
    );
  }
};

// Get prescriptions by patient ID (admin only)
export const getPrescriptionsCount = async (req: Request, res: Response) => {
  try {
    const userId =
      (req.user as any)?.id ||
      (req.user as any)?._id ||
      req.user;

    if (!userId) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }
    const count = await Prescription.countDocuments({ user: userId, });

    return sendSuccessResponse(
      res,
      200,
      "Prescription fetched successfully",
      count
    );

  } catch (error: any) {
    console.error("getPrescriptions error:", error);
    return sendErrorResponse(res, 500, "Server error while fetching prescriptions");
  }
};

// Update prescription status
export const updatePrescriptionStatus = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;
    const { status } = req.body;

    // ---------- Validation ----------
    if (!id) {
      return sendErrorResponse(res, 400, "Prescription ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    if (!ALLOWED_STATUSES.includes(status)) {
      return sendErrorResponse(res, 400, "Invalid status value");
    }

    // ---------- Atomic Update ----------
    const prescription = await Prescription.findOneAndUpdate(
      { _id: id, status: { $ne: STATUS.APPROVED } },
      { status },
      { new: true }
    ).populate<{ user: IUser }>({ path: "user", select: "phone" });

    if (!prescription) {
      return sendErrorResponse(res, 409, "Already approved or not found");
    }

    // ---------- Notification ----------
    const phone = prescription.user?.phone;
    const whatsappEvent =
      status === STATUS.APPROVED
        ? "PRESCRIPTION_APPROVED"
        : status === STATUS.REJECTED
          ? "PRESCRIPTION_REJECTED"
          : null;

    if (phone && whatsappEvent) {
      sendWhatsappEvent({
        mobile: phone,
        event: whatsappEvent,
        variables:
          whatsappEvent === "PRESCRIPTION_APPROVED"
            ? ["prescription and KYC", "request a quotation"]
            : [],
      }).catch(err => console.error("WhatsApp failed:", err));
    }

    return sendSuccessResponse(res, 200, "Prescription status updated successfully", { prescription });

  } catch (err) {
    console.error(err);
    return sendErrorResponse(res, 500, "Server error");
  }
};

// Delete a prescription
export const deletePrescription = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;

    // Validate ID
    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid prescription ID");
    }

    // Check prescription exists
    const prescription = await Prescription.findById(id as string);
    if (!prescription) {
      return sendErrorResponse(res, 404, "Prescription not found");
    }

    // OPTIONAL: Delete uploaded file (Cloudinary / local)
    // if (prescription.document?.url) {
    //   await deleteFile(prescription.document.url);
    // }

    // Hard delete
    await Prescription.findByIdAndDelete(id);

    return sendSuccessResponse(
      res,
      200,
      "Prescription deleted successfully"
    );

  } catch (error) {
    console.error("DELETE PRESCRIPTION ERROR:", error);
    return sendErrorResponse(res, 500, "Server error while deleting prescription");
  }
};
