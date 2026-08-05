import { Request, Response } from "express";
import mongoose from 'mongoose';
import { sendErrorResponse, sendSuccessResponse } from "../utils/response";
import KYCDocument from "../models/kyc.model";
import { extractDocuments } from '../utils/normalizeDocuments';
import User from '../models/user.model';
import { sendWhatsappEvent } from '../service/whatsApps';
import { ALLOWED_STATUSES, IUser, STATUS } from '../utils/status';
import { sendEmail } from '../service/sendMail';
import { kycTemplate } from '../service/emailTemplate';


export const submitKYC = async (req: Request, res: Response) => {
  try {
    const userId = (req.user as any).id || (req.user as any)._id || req.user;

    if (!userId) {
      return sendErrorResponse(res, 401, "Unauthorized User?");
    }

    const { documentNumber, documentType } = req.body;

    if (!documentNumber) {
      return sendErrorResponse(res, 400, "Invalid or missing documentNumber");
    }

    if (!documentType) {
      return sendErrorResponse(res, 400, "Document Type is required");
    }

    /* ---------- NORMALIZED DOCUMENTS ---------- */
    const documents = extractDocuments(req);

    // --------- Validations -------
    if (documents.length === 0) {
      return sendErrorResponse(res, 400, "Both document is required");
    }

    if (documents.length !== 2) {
      return sendErrorResponse(res, 400, "Requires front & back images");
    }

    // ------- Fetch Caretaker & Patient ---------
    const user = await User.findById(userId)
      .select("phone email");

    if (!user) {
      return sendErrorResponse(
        res,
        404,
        "User not found"
      );
    }

    // ----- Create KYC Entry -----
    const kyc = await KYCDocument.create({
      user: user._id,
      documentType,
      documentNumber,
      documents,
    });

    await User.updateOne(
      { _id: user._id },
      {
        $set: {
          progress: "kyc_uploaded",
        },
      }
    );

    // ----- Notifications (non-blocking) -----
    try {
      if (user.phone) {
        await sendWhatsappEvent({
          mobile: user.phone,
          event: "KYC_UPLOADED",
          variables: [
            documentType,
            "KYC Document Uploaded",
          ],
        });
      } else if (user.email) {
        await sendEmail({
          to: user.email,
          subject: "Named Patient Program - KYC",
          html: kycTemplate("Uploaded"),
        });
      }
    } catch (notificationError) {
      console.error(
        "KYC notification failed:",
        notificationError
      );
    }

    return sendSuccessResponse(res, 201, "KYC uploaded successfully", kyc);

  } catch (error) {
    console.error("KYC Upload Error:", error);
    return sendErrorResponse(res, 500, "Server Error");
  }
};


export const getKycByUserId = async (req: Request, res: Response) => {
  try {
    const userId =
      (req.user as any)?.id ||
      (req.user as any)?._id ||
      req.user;

    if (!userId) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }

    const kyc = await KYCDocument.findOne({ user: userId })
      .sort({ createdAt: -1 })
      .lean().select("status");

    if (!kyc) {
      return sendSuccessResponse(res, 200, "KYC not found", null);
    }

    return sendSuccessResponse(
      res,
      200,
      "KYC fetched successfully",
      kyc,
    );
  } catch (error: any) {
    console.error("KYC error:", error);
    return sendErrorResponse(
      res,
      500,
      "Server error while fetching KYC"
    );
  }
};

export const kycStatusUpdate = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;
    const { status } = req.body;

    // ---------- Validation ----------
    if (!id) {
      return sendErrorResponse(res, 400, "KYC ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    if (!ALLOWED_STATUSES.includes(status)) {
      return sendErrorResponse(res, 400, "Invalid status value");
    }

    // ---------- Atomic Update ----------
    const kyc = await KYCDocument.findOneAndUpdate({ _id: id, status: { $ne: STATUS.APPROVED, }, },
      { $set: { status }, },
      {
        new: true,
        runValidators: true,
      }
    ).populate<{
      user: IUser;
    }>({
      path: "user",
      select: "phone email",
    });

    if (!kyc) {
      return sendErrorResponse(
        res,
        409,
        "KYC already approved or not found"
      );
    }

    // ---------- Notifications (non-blocking) ----------
    const phone = kyc.user?.phone;
    const email = kyc.user?.email;
    const whatsappEvent =
      status === STATUS.APPROVED
        ? "KYC_APPROVED"
        : status === STATUS.REJECTED
          ? "KYC_REJECTED"
          : null;

    if (phone && whatsappEvent) {
      void sendWhatsappEvent({
        mobile: phone,
        event: whatsappEvent,
        variables: [],
      }).catch((err) => {
        console.error(
          "WhatsApp notification failed:",
          err
        );
      });
    } else if (email) {
      void sendEmail({
        to: email,
        subject: `KYC Status Updated - ${status}`,
        html: kycTemplate(status),
      }).catch((err) => {
        console.error(
          "Email notification failed:",
          err
        );
      });
    }
    return sendSuccessResponse(res, 200, "KYC status updated successfully", { kyc });

  } catch (err) {
    console.error(err);
    return sendErrorResponse(res, 500, "Server error");
  }
};

export const deleteKYC = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;

    const deleted = await KYCDocument.findByIdAndDelete(id);

    if (!deleted) {
      return sendErrorResponse(res, 404, "KYC not found");
    }

    return sendSuccessResponse(res, 200, "KYC deleted successfully");
  } catch (error) {
    console.error("DELETE KYC ERROR:", error);
    return sendErrorResponse(res, 500, "Server Error");
  }
};
