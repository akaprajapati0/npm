import { Request, Response } from "express";
import fs from "fs";
import path from "path";
import ShipmentDocument, { REQUIRED_DOCUMENT_FIELDS } from "../models/document.model";
import { Image } from '../types/controllersTypes';
import { sendErrorResponse, sendSuccessResponse } from '../utils/response';

const toImage = (file: Express.Multer.File): Image => ({
    url: "/" + file.path.replace(/\\/g, "/"), // web-servable path for express.static
    mimeType: file.mimetype,
    size: file.size,
});


export const uploadAllDocuments = async (req: Request, res: Response) => {
    try {
        const files = req.files as Record<string, Express.Multer.File[]> | undefined;

        const missing = REQUIRED_DOCUMENT_FIELDS.filter((field) => !files?.[field]?.length);
        if (missing.length > 0) {
            // Clean up any files that WERE uploaded, since the request is invalid overall
            Object.values(files || {}).flat().forEach((f) => fs.unlink(f.path, () => { }));
            return sendErrorResponse(res, 400, `Missing required document(s): ${missing.join(", ")}`)
        }

        const { user } = req.body;

        const docData: Record<string, unknown> = { user };

        REQUIRED_DOCUMENT_FIELDS.forEach((field) => {
            docData[field] = toImage(files![field][0]);
        });

        if (files?.additionalDocuments) {
            docData.additionalDocuments = files.additionalDocuments.map(toImage);
        }

        const created = await ShipmentDocument.create(docData);
        if (!created) sendErrorResponse(res, 402, "Error creating documents")

        return sendSuccessResponse(res, 201, "All documents uploaded successfully.")
    } catch (error: any) {
        return sendErrorResponse(res, 500, "Server error creating document set.")
    }
};


export const getDocuments = async (req: Request, res: Response) => {
    try {
        const { id } = req.params;

        if (id) {
            const doc = await ShipmentDocument.findOne({ user: id });
            if (!doc) return sendErrorResponse(res, 404, "Document not found")
        }

        const docs = await ShipmentDocument.find().sort({ createdAt: -1 });
        return sendSuccessResponse(res, 200, "Document fetch successfully", docs)
    } catch (error: any) {
        return sendErrorResponse(res, 500, "Server error fetching document set.")
    }
};


export const getDocumentByUserId = async (req: Request, res: Response) => {
    try {
        const userId =
            (req.user as any)?.id ||
            (req.user as any)?._id ||
            req.user;

        if (!userId) {
            return sendErrorResponse(res, 401, "Unauthorized user");
        }
        const doc = await ShipmentDocument.findOne({ user: userId });

        if (!doc) {
            return sendErrorResponse(res, 401, "Documents not found");
        }
        return sendSuccessResponse(res, 200, "Document fetch successfully", doc)
    } catch (error: any) {
        return sendErrorResponse(res, 500, "Server error fetching document set.")
    }
};


export const deleteDocument = async (req: Request, res: Response) => {
    try {
        const doc = await ShipmentDocument.findById(req.params.id);
        if (!doc) {
            return res.status(404).json({ success: false, message: "Document set not found." });
        }

        const unlink = (img?: Image) => {
            if (img?.url) fs.unlink(path.join(process.cwd(), img.url), () => { });
        };

        REQUIRED_DOCUMENT_FIELDS.forEach((field) => unlink(doc[field] as Image | undefined));
        (doc.additionalDocuments || []).forEach(unlink);

        await doc.deleteOne();
        return res.status(200).json({ success: true, message: "Document set deleted." });
    } catch (error: any) {
        return res.status(500).json({ success: false, message: "Error deleting document set.", error: error.message });
    }
};