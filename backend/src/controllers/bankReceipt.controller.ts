import { Request, Response } from 'express';
import mongoose from 'mongoose';
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';
import BankReceipt from '../models/bankReceipt.model';
import User from '../models/user.model';
import { extractDocuments } from '../utils/normalizeDocuments';
import { sendWhatsappEvent } from '../service/whatsApps';
import Caretaker from '../models/caretaker.model';
import { ALLOWED_STATUSES, IUser, STATUS } from '../utils/status';

export const submitBankReceipt = async (req: Request, res: Response) => {
  try {
    const userId =
      (req.user as any)?.id ||
      (req.user as any)?._id ||
      req.user;

    if (!userId) {
      return sendErrorResponse(res, 401, "Unauthorized caretaker");
    }

    const { documentNumber } = req.body;

    /* ---------- NORMALIZED DOCUMENTS ---------- */
    const documents = extractDocuments(req);

    // --------- Validations -------
    if (documents.length === 0) {
      return sendErrorResponse(res, 400, "Minimum 1 document is required");
    }

    // ------- Fetch caretaker + patient ------
    const user = await Caretaker.findOne({ user: userId })
      .select("fullname phone")
      .lean();

    if (!user) {
      return sendErrorResponse(res, 404, "User not found");
    }

    const bankReceipt = await BankReceipt.create({
      user: userId,
      documentNumber,
      documents
    });

    await User.findByIdAndUpdate({ _id: userId }, {
      $set: {
        progress: "bank_receipt_uploaded",
      },
    });

    await sendWhatsappEvent({
      mobile: user.phone!,
      event: "TRANSACTION_RECEIVED",
      variables: [user.fullname]
    }).catch(err => console.error("WhatsApp failed:", err));

    return sendSuccessResponse(
      res,
      201,
      "Bank receipt uploaded successfully",
      bankReceipt
    );
  } catch (error) {
    console.log(error)
    return sendErrorResponse(res, 500, "Server error while uploading bank receipt");
  }
};


export const getBankRecieptByUserId = async (req: Request, res: Response) => {
  try {
    const userId =
      (req.user as any)?.id ||
      (req.user as any)?._id ||
      req.user;

    if (!userId) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }

    const bank = await BankReceipt.findOne({ user: userId })
      .sort({ createdAt: -1 })
      .lean().select("status");

    if (!bank) {
      return sendSuccessResponse(res, 200, "Bank Reciept not found", null);
    }

    return sendSuccessResponse(
      res,
      200,
      "Bank Reciept fetched successfully",
      bank,
    );
  } catch (error: any) {
    console.error("Bank Reciept error:", error);
    return sendErrorResponse(
      res,
      500,
      "Server error while fetching Bank Reciept"
    );
  }
};


export const updateBankReceiptStatus = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;
    const { status } = req.body;

    // ---------- Validation ----------
    if (!id) {
      return sendErrorResponse(res, 400, "Bank receipt ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    if (!status || !ALLOWED_STATUSES.includes(status)) {
      return sendErrorResponse(res, 400, "Invalid status value");
    }

    // ---------- Check Existing ----------
    const existingReceipt = await BankReceipt.findById(id).select("status");

    if (!existingReceipt) {
      return sendErrorResponse(res, 404, "Bank receipt not found");
    }

    if (existingReceipt.status === STATUS.APPROVED) {
      return sendErrorResponse(res, 409, "Bank receipt already approved");
    }

    // ---------- Update ----------
    const receipt = await BankReceipt.findByIdAndUpdate(
      id,
      {
        status,
        verifiedAt: new Date(),
      },
      { new: true }
    ).populate<{ user: IUser }>({
      path: "user",
      select: "phone",
    });

    // ---------- Notification ----------
    const phone = receipt?.user?.phone;

    if (status === STATUS.APPROVED && phone) {
      sendWhatsappEvent({
        mobile: phone,
        event: "DOCUMENT_VERIFIED",
        variables: ["Bank Receipt", "CDEC"],
      }).catch(err => console.error("WhatsApp failed:", err));
    }

    return sendSuccessResponse(
      res,
      200,
      "Bank receipt status updated successfully",
      { receipt }
    );

  } catch (err) {
    console.error(err);
    return sendErrorResponse(res, 500, "Server error");
  }
};


export const deleteBankReceipt = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid Bank Receipt ID");
    }

    const deleted = await BankReceipt.findByIdAndDelete(id);

    if (!deleted) {
      return sendErrorResponse(res, 404, "Bank Receipt not found");
    }

    return sendSuccessResponse(res, 200, "Bank Receipt permanently deleted");

  } catch (error: any) {
    console.error("HARD DELETE BANK RECEIPT ERROR:", error);
    return sendErrorResponse(res, 500, "Server error while deleting Bank Receipt");
  }
};