import { Request, Response } from "express";
import mongoose from "mongoose";
import { sendSuccessResponse, sendErrorResponse } from "../utils/response";
import { extractDocuments } from "../utils/normalizeDocuments";
import {
  ImportLicenseRequest,
  MedicineQuotationRequest,
  ProformaInvoiceRequest,
} from "../models/docsRequest.model";
import User from "../models/user.model";
import { sendWhatsappEvent } from "../service/whatsApps";
import { IUser } from "../utils/status";
import { Image } from "../types/controllersTypes";
import { RequestStatus } from "../types/schemaTypes";
import fs from "fs/promises";

type DocumentType =
  | "medicine_quotation"
  | "proforma_invoice"
  | "import_license";

const DOCUMENT_TYPE_CONFIG: Record<
  DocumentType,
  { model: typeof MedicineQuotationRequest; event: string; progress: string }
> = {
  medicine_quotation: {
    model: MedicineQuotationRequest,
    event: "MEDICINE_QUOTATION",
    progress: "request_quotation",
  },
  proforma_invoice: {
    model: ProformaInvoiceRequest,
    event: "PROFORMA_INVOICE",
    progress: "request_invoice",
  },
  import_license: {
    model: ImportLicenseRequest,
    event: "IMPORT_LICENSE",
    progress: "request_license",
  },
};

const VALID_TYPES = Object.keys(DOCUMENT_TYPE_CONFIG) as DocumentType[];

export const requestDocument = async (req: Request, res: Response) => {
  try {
    const userId = (req.user as any)?.id || (req.user as any)?._id || req.user;

    const { type } = req.params as { type: DocumentType };

    if (!VALID_TYPES.includes(type)) {
      return sendErrorResponse(res, 400, "Invalid document type");
    }

    const user = await User.findById(userId).select("phone progress");

    if (!user) {
      return sendErrorResponse(res, 404, "User does not exist");
    }

    // Run all three existence checks in parallel instead of sequentially
    const [medRequest, proformaRequest, importRequest] = await Promise.all([
      MedicineQuotationRequest.findOne({ user: user._id }).select("status"),
      ProformaInvoiceRequest.findOne({ user: user._id }).select("status"),
      ImportLicenseRequest.findOne({ user: user._id }).select("status"),
    ]);

    const existingByType: Record<DocumentType, typeof medRequest> = {
      medicine_quotation: medRequest,
      proforma_invoice: proformaRequest,
      import_license: importRequest,
    };

    const existingRequest = existingByType[type];
    if (existingRequest?.status === "Requested") {
      return sendErrorResponse(res, 400, "Already requested");
    }

    if (existingRequest?.status === "Approved") {
      return sendErrorResponse(res, 400, "Already approved");
    }

    const { model, event, progress } = DOCUMENT_TYPE_CONFIG[type];

    await model.create({ user: user._id, status: "Requested" });

    if (user.phone) {
      await sendWhatsappEvent({
        mobile: user.phone,
        event: event,
        // variables: [eventData.msg],
      }).catch(() => {});
    }

    user.progress = progress;
    await user.save();

    return sendSuccessResponse(res, 200, "Document requested successfully");
  } catch (err: unknown) {
    console.error("requestDocument error:", err);
    return sendErrorResponse(res, 500, "Internal server error");
  }
};

export const getMyDocumentByUser = async (req: Request, res: Response) => {
  try {
    const userId = (req.user as any)?.id || (req.user as any)?._id || req.user;

    const { type } = req.params as { type: DocumentType };

    if (!userId) {
      return sendErrorResponse(res, 401, "Unauthorized");
    }

    if (!mongoose.Types.ObjectId.isValid(userId)) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }

    //

    if (!VALID_TYPES.includes(type)) {
      return sendErrorResponse(res, 400, "Invalid document type");
    }

    const { model: Model } = DOCUMENT_TYPE_CONFIG[type];

    const document = await Model.findOne({ user: userId })
      .sort({ createdAt: -1 })
      .lean();

    if (!document) {
      return sendErrorResponse(res, 404, "Document not found");
    }

    return sendSuccessResponse(
      res,
      200,
      "Documents fetched successfully",
      document,
    );
  } catch (error) {
    console.error("Get documents error:", error);
    return sendErrorResponse(res, 500, "Internal server error");
  }
};

export const getAllDocument = async (req: Request, res: Response) => {
  try {
    const { id } = req.params;

    if (!id) {
      return sendErrorResponse(res, 400, "User ID required");
    }

    if (!mongoose.Types.ObjectId.isValid(id as string)) {
      return sendErrorResponse(res, 400, "Invalid user ID");
    }

    const [medicineQuotation, proformaInvoice, importLicense] =
      await Promise.all([
        MedicineQuotationRequest.findOne({ user: id }).lean(),
        ProformaInvoiceRequest.findOne({ user: id }).lean(),
        ImportLicenseRequest.findOne({ user: id }).lean(),
      ]);

    return sendSuccessResponse(res, 200, "Documents fetched successfully", {
      medicineQuotation,
      proformaInvoice,
      importLicense,
    });
  } catch (error) {
    console.error("Get documents error:", error);
    return sendErrorResponse(res, 500, "Internal server error");
  }
};

export const updateDocumentStatus = async (req: Request, res: Response) => {
  let uploadedDocuments: Image[] = [];

  try {
    const { id, type } = req.params as { id: string; type: DocumentType };
    const { status, remarks } = req.body as {
      status: RequestStatus;
      remarks?: string;
    };

    if (!id) {
      return sendErrorResponse(res, 400, "Document ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    if (!VALID_TYPES.includes(type)) {
      return sendErrorResponse(res, 400, "Invalid document type");
    }

    if (
      !status ||
      ![
        "Approved",
        "Rejected",
        "Requested",
        "Pending",
        "Revise_Request",
      ].includes(status)
    ) {
      return sendErrorResponse(res, 400, "Invalid status value");
    }

    const { model: Model, event } = DOCUMENT_TYPE_CONFIG[type];

    const existing = await Model.findById(id).populate<{ user: IUser }>({
      path: "user",
      select: "phone",
    });

    if (!existing) {
      return sendErrorResponse(res, 404, "Document not found");
    }

    if (existing.status === "Approved") {
      return sendErrorResponse(
        res,
        400,
        `Cannot change status from ${existing.status}`,
      );
    }

    uploadedDocuments = extractDocuments(req) as Image[];

    if (uploadedDocuments.length) {
      existing.documents.push(...uploadedDocuments);
    }

    const now = new Date();
    existing.status = status;
    existing.remarks = remarks || existing.remarks;

    if (status === "Approved") existing.approvedAt = now;
    if (status === "Rejected") existing.rejectedAt = now;
    if (status === "Requested") existing.requestedAt = now;

    await existing.save();

    const phone = existing.user?.phone;
    // const event = events[status];

    if (phone && event) {
      sendWhatsappEvent({
        mobile: phone,
        event,
        variables: [`${type} has been ${status.toLowerCase()}`],
      }).catch((err) => console.error("WhatsApp notification failed:", err));
    }

    return sendSuccessResponse(
      res,
      200,
      `${type} ${status.toLowerCase()} successfully`,
    );
  } catch (err: unknown) {
    console.error("updateDocumentStatus error:", err);

    // Clean up any files that multer already wrote to disk
    // before the DB save failed, so they don't become orphans.
    if (uploadedDocuments.length) {
      await Promise.all(
        uploadedDocuments.map((doc) =>
          fs
            .unlink(doc.url)
            .catch((unlinkErr) =>
              console.error(
                "Failed to clean up orphaned file:",
                doc.url,
                unlinkErr,
              ),
            ),
        ),
      );
    }

    return sendErrorResponse(res, 500, "Internal server error");
  }
};

export const reviseDocumentRequest = async (req: Request, res: Response) => {
  try {
    const { id, type } = req.params as { id: string; type: DocumentType };
    const { status } = req.body as { status: RequestStatus };

    if (!id) {
      return sendErrorResponse(res, 400, "Document ID is required");
    }

    if (!mongoose.Types.ObjectId.isValid(id)) {
      return sendErrorResponse(res, 400, "Invalid ID format");
    }

    if (!VALID_TYPES.includes(type)) {
      return sendErrorResponse(res, 400, "Invalid document type");
    }

    if (
      !status ||
      ![
        "Approved",
        "Rejected",
        "Requested",
        "Pending",
        "Revise_Request",
      ].includes(status)
    ) {
      return sendErrorResponse(res, 400, "Invalid status value");
    }

    const { model: Model, event } = DOCUMENT_TYPE_CONFIG[type];

    const existing = await Model.findById(id).populate<{ user: IUser }>({
      path: "user",
      select: "phone",
    });

    if (!existing) {
      return sendErrorResponse(res, 404, "Document not found");
    }

    // if (existing.status !== "Rejected") {
    //     return sendErrorResponse(
    //         res,
    //         400,
    //         `Cannot change status from ${existing.status}`
    //     );
    // }
    if (existing.status !== "Rejected" && existing.status !== "Approved") {
      return sendErrorResponse(
        res,
        400,
        `Cannot change status from ${existing.status}`,
      );
    }

    const now = new Date();
    existing.status = status;

    if (status === "Approved") existing.approvedAt = now;
    if (status === "Rejected") existing.rejectedAt = now;
    if (status === "Requested") existing.requestedAt = now;
    if (status === "Revise_Request") existing.reviseAt = now;

    await existing.save();

    const phone = existing.user?.phone;
    // const event = events[status];

    if (phone && event) {
      sendWhatsappEvent({
        mobile: phone,
        event,
        variables: [`${type} has been ${status.toLowerCase()}`],
      }).catch((err) => console.error("WhatsApp notification failed:", err));
    }

    return sendSuccessResponse(
      res,
      200,
      `${type} ${status.toLowerCase()} successfully`,
    );
  } catch (err: unknown) {
    console.error("reviseDocumentRequest error:", err);
    return sendErrorResponse(res, 500, "Internal server error");
  }
};
