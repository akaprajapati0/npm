import mongoose from 'mongoose';
import { Request, Response } from "express";
import CDEC from "../models/cdec.model";
import User from "../models/user.model";
import { sendErrorResponse, sendSuccessResponse } from "../utils/response";

import { extractDocuments } from '../utils/normalizeDocuments';
import { sendWhatsappEvent } from '../service/whatsApps';
import Caretaker from '../models/caretaker.model';
// import AdminDocument from '../models/adminDocument.model';
import { ALLOWED_STATUSES, IUser, STATUS } from '../utils/status';
import fs from "fs/promises";

export const submitCDEC = async (req: Request, res: Response) => {
  try {
    const userId = (req.user as any).id || (req.user as any)._id || req.user;

    if (!userId) {
      return sendErrorResponse(res, 401, "Unauthorized");
    }

    /* ---------- NORMALIZED DOCUMENTS ---------- */
    const documents = extractDocuments(req);

    // ---------- VALIDATION ----------
    if (documents.length === 0) {
      return sendErrorResponse(
        res,
        400,
        "At least one CDEC document is required"
      );
    }

    // ------ Fetch caretaker + patient -------
    const user = await Caretaker.findOne({ user: userId })
      .select("fullname phone")
      .lean();

    if (!user) {
      return sendErrorResponse(res, 404, "User not found");
    }

    // ------ Ensure admin has uploaded the download document first ------
    const existingCdec = await CDEC.findOne({ user: userId });

    if (!existingCdec) {
      return sendErrorResponse(
        res,
        404,
        "CDEC document not yet provided by admin"
      );
    }

    // ------ Update existing record with user documents ------
    existingCdec.set("documents", documents);
    existingCdec.status = "pending";
    const cdec = await existingCdec.save();

    // ------ Update progress ------
    await User.findByIdAndUpdate(userId, {
      $set: {
        progress: "cdec_uploaded"
      },
    });

    await sendWhatsappEvent({
      mobile: user.phone!,
      event: "CDEC_UPLOADED",
      variables: [user.fullname]
    }).catch(() => { });

    // ---- Emit patient update ----
    // caretakerEvents.emit("caretaker:updated", userId);

    return sendSuccessResponse(
      res,
      201,
      "CDEC document uploaded successfully",
      cdec
    );
  } catch (error) {
    return sendErrorResponse(res, 500, "Server error while uploading CDEC");
  }
};

export const getCdecByUserId = async (req: Request, res: Response) => {
  try {
    const userId =
      (req.user as any)?.id ||
      (req.user as any)?._id ||
      req.user;

    if (!userId) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }

    // Get latest caretaker (single object)
    const cdec = await CDEC.findOne({ user: userId })
      .sort({ createdAt: -1 })
      .lean().select("status");

    if (!cdec) {
      return sendSuccessResponse(res, 200, "CDEC not found", null);
    }

    return sendSuccessResponse(
      res,
      200,
      "CDEC fetched successfully",
      cdec,
    );
  } catch (error: any) {
    console.error("cdec error:", error);
    return sendErrorResponse(
      res,
      500,
      "Server error while fetching cdec"
    );
  }
};

export const updateCdecStatus = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;
    const { status } = req.body;

    // ---------- Validation ----------
    if (!id) {
      return sendErrorResponse(res, 400, "CDEC ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    if (!ALLOWED_STATUSES.includes(status)) {
      return sendErrorResponse(res, 400, "Invalid status value");
    }

    // ---------- Atomic Update ----------
    const cdec = await CDEC.findOneAndUpdate(
      {
        _id: id,
        status: { $ne: STATUS.APPROVED },
        documents: { $exists: true, $not: { $size: 0 } },
      },
      { status },
      { new: true }
    ).populate<{ user: IUser }>({ path: "user", select: "phone" });

    if (!cdec) {
      return sendErrorResponse(
        res,
        409,
        "Already approved, not found, or user has not submitted documents yet"
      );
    }

    // ---------- Notification ----------
    const phone = cdec.user?.phone;
    const whatsappEvent =
      status === STATUS.APPROVED
        ? "CDEC_APPROVED"
        : status === STATUS.REJECTED
          ? "CDEC_REJECTED"
          : null;

    if (phone && whatsappEvent) {
      sendWhatsappEvent({
        mobile: phone,
        event: whatsappEvent,
        variables: [],
      }).catch(err => console.error("WhatsApp failed:", err));
    }

    return sendSuccessResponse(res, 200, "CDEC status updated successfully", { cdec });

  } catch (err) {
    console.error(err);
    return sendErrorResponse(res, 500, "Server error");
  }
};

export const uploadCdecDocumentByAdmin = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;

    if (!id) {
      return sendErrorResponse(res, 400, "User ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    const documents = extractDocuments(req);

    if (!documents.length) {
      return sendErrorResponse(res, 400, "Please upload a document");
    }

    // ------ Find existing CDEC record for cleanup (if any) ------
    const existingCdec = await CDEC.findOne({ user: id });
    const previousDocument = existingCdec?.downloadDocument;

    // ------ Create record if it doesn't exist, else update ------
    const cdec = await CDEC.findOneAndUpdate(
      { user: id },
      { $set: { downloadDocument: documents[0] } },
      { new: true, upsert: true, setDefaultsOnInsert: true }
    );

    // ---------- Cleanup old file ----------
    if (previousDocument?.url) {
      fs.unlink(previousDocument.url).catch((err) => {
        // Don't fail the request over a cleanup miss — log and move on.
        // Common benign case: file was already removed manually,
        // or path changed between environments.
        console.error("Failed to delete old CDEC file:", previousDocument.url, err);
      });
    }

    return sendSuccessResponse(
      res,
      200,
      "CDEC document uploaded successfully",
      cdec
    );
  } catch (error: unknown) {
    console.error("Update CDEC Document Error:", error);

    return sendErrorResponse(res, 500, "Server error while updating document");
  }
};

export const getDownloadableDocument = async (req: Request, res: Response) => {
  try {
    const userId = (req.user as any)?.id || (req.user as any)?._id;

    if (!userId) {
      return sendErrorResponse(res, 401, "Unauthorized");
    }

    const latestDocument = await CDEC.findOne({ user: userId })
      .select("_id downloadDocument")
      .lean();

    if (!latestDocument?.downloadDocument) {
      return sendErrorResponse(res, 404, "No document found");
    }

    return sendSuccessResponse(
      res,
      200,
      "Document fetched successfully",
      latestDocument
    );

  } catch (err: unknown) {
    console.error("Get Latest User Document Error:", err);
    return sendErrorResponse(res, 500, "Internal server error");
  }
};

export const getDownloadableDocumentByAdmin = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;

    if (!id) {
      return sendErrorResponse(res, 400, "User ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    const latestDocument = await CDEC.findOne({ user: id })
      .select("_id downloadDocument")
      .lean();

    if (!latestDocument?.downloadDocument) {
      return sendErrorResponse(res, 404, "No document found");
    }

    return sendSuccessResponse(
      res,
      200,
      "Document fetched successfully",
      latestDocument
    );

  } catch (err: unknown) {
    console.error("Get Latest Admin Document Error:", err);
    return sendErrorResponse(res, 500, "Internal server error");
  }
};


// export const submitCDEC = async (req: Request, res: Response) => {
//   try {
//     const userId = (req.user as any).id || (req.user as any)._id || req.user;


//     if (!userId) {
//       return sendErrorResponse(res, 401, "Unauthorized");
//     }

//     /* ---------- NORMALIZED DOCUMENTS ---------- */
//     const documents = extractDocuments(req);

//     // ---------- VALIDATION ----------
//     if (documents.length === 0) {
//       return sendErrorResponse(
//         res,
//         400,
//         "At least one CDEC document is required"
//       );
//     }

//     // ------ Fetch caretaker + patient -------
//     const user = await Caretaker.findOne({ user: userId })
//       .select("fullname phone")
//       .lean();

//     if (!user) {
//       return sendErrorResponse(res, 404, "User not found");
//     }

//     const cdec = await CDEC.create({
//       user: userId,
//       documents
//     });

//     // ------ Update progress ------
//     await User.findByIdAndUpdate(userId, {
//       $set: {
//         progress: "cdec_uploaded"
//       },
//     });

//     await sendWhatsappEvent({
//       mobile: user.phone!,
//       event: "CDEC_UPLOADED",
//       variables: [user.fullname]
//     }).catch(() => { });

//     // ---- Emit patient update ----
//     // caretakerEvents.emit("caretaker:updated", userId);

//     return sendSuccessResponse(
//       res,
//       201,
//       "CDEC document uploaded successfully",
//       cdec
//     );
//   } catch (error) {
//     return sendErrorResponse(res, 500, "Server error while uploading CDEC");
//   }
// };


// export const updateCdecStatus = async (req: Request, res: Response) => {
//   try {
//     const { id } = req.params;
//     const { status } = req.body;

//     // ---------- Validation ----------
//     if (!id) {
//       return sendErrorResponse(res, 400, "CDEC ID is required");
//     }

//     if (!mongoose.Types.ObjectId.isValid(id as string)) {
//       return sendErrorResponse(res, 400, "Invalid ID format");
//     }

//     if (!ALLOWED_STATUSES.includes(status)) {
//       return sendErrorResponse(res, 400, "Invalid status value");
//     }

//     // ---------- Atomic Update ----------
//     const cdec = await CDEC.findOneAndUpdate(
//       { _id: id, status: { $ne: STATUS.APPROVED } },
//       { status },
//       { new: true }
//     ).populate<{ user: IUser }>({ path: "user", select: "phone" });

//     if (!cdec) {
//       return sendErrorResponse(res, 409, "Already approved or not found");
//     }

//     // ---------- Notification ----------
//     const phone = cdec.user?.phone;

//     if (phone) {
//       sendWhatsappEvent({
//         mobile: phone,
//         event: "CDEC_STATUS_UPDATED",
//         variables: [status],
//       }).catch(err => console.error("WhatsApp failed:", err));
//     }

//     return sendSuccessResponse(res, 200, "CDEC status updated successfully", { cdec });

//   } catch (err) {
//     console.error(err);
//     return sendErrorResponse(res, 500, "Server error");
//   }
// };

// Admin will be upload cdec downloadable form
// export const addCdecFormByAdmin = async (req: Request, res: Response) => {
//   try {
//     const documents = extractDocuments(req);
//     const { id } = req.params;

//     if (!documents.length) {
//       return res.status(400).json({
//         success: false,
//         message: "Please upload at least one document",
//       });
//     }

//     const added = await CDEC.create({ user: id, downloadDocument: documents[0] });

//     return sendSuccessResponse(res, 200, "CDEC form uploaded successfully", added);

//   } catch (error: any) {
//     return res.status(500).json({
//       success: false,
//       message: error.message || "Server error",
//     });
//   }
// };

// export const uploadCdecDocumentByAdmin = async (req: Request, res: Response) => {
//   try {
//     const { id } = req.params;

//     if (!id) {
//       return sendErrorResponse(res, 400, "Document ID is required");
//     }

//     if (!mongoose.Types.ObjectId.isValid(id as string)) {
//       return sendErrorResponse(res, 400, "Invalid ID format");
//     }

//     const documents = extractDocuments(req);

//     if (!documents.length) {
//       return sendErrorResponse(res, 400, "Please upload a document");
//     }

//     const existingDocument = await AdminDocument.findOne({ user: id });

//     if (!existingDocument) {
//       return sendErrorResponse(res, 404, "Document not found");
//     }

//     const previousDocument = existingDocument.documents;

//     existingDocument.documents = documents[0];
//     await existingDocument.save();

//     // ---------- Cleanup old file ----------
//     if (previousDocument?.url) {
//       fs.unlink(previousDocument.url).catch((err) => {
//         // Don't fail the request over a cleanup miss — log and move on.
//         // Common benign case: file was already removed manually,
//         // or path changed between environments.
//         console.error("Failed to delete old CDEC file:", previousDocument.url, err);
//       });
//     }

//     return sendSuccessResponse(
//       res,
//       200,
//       "CDEC document uploaded successfully",
//       existingDocument
//     );
//   } catch (error: unknown) {
//     console.error("Update CDEC Document Error:", error);

//     return sendErrorResponse(res, 500, "Server error while updating document");
//   }
// };

// export const getLatestAdminDocument = async (
//   req: Request,
//   res: Response
// ) => {
//   try {
//     const latestDocument = await CDEC.findOne()
//       .sort({ createdAt: -1 })
//       .select("id downloadDocument")
//       .lean();

//     if (!latestDocument) {
//       return sendErrorResponse(res, 404, "No document found");
//     }

//     return sendSuccessResponse(
//       res,
//       200,
//       "Document fetched successfully",
//       latestDocument
//     );

//   } catch (err: unknown) {
//     console.error("Get Latest Admin Document Error:", err);

//     return sendErrorResponse(
//       res,
//       500,
//       "Internal server error"
//     );
//   }
// };
