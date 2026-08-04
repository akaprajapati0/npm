import { Request } from "express";
import { Image } from '../types/controllersTypes';


export function extractDocuments(req: Request): Image[] {
    const documents: Image[] = [];

    const normalizePath = (filePath: string) =>
        filePath.replace(/\\/g, "/"); // ✅ force forward slash

    /* -------- upload.array('documents') -------- */
    if (Array.isArray(req.files)) {
        for (const file of req.files) {
            documents.push({
                url: normalizePath(file.path), // ✅ FIXED
                mimeType: file.mimetype,
                size: file.size,
            });
        }
        return documents;
    }

    /* -------- upload.fields({ documents: [] }) -------- */
    const fieldFiles = req.files as Record<string, Express.Multer.File[]> | undefined;

    if (fieldFiles?.documents) {
        for (const file of fieldFiles.documents) {
            documents.push({
                url: normalizePath(file.path), // ✅ FIXED
                mimeType: file.mimetype,
                size: file.size,
            });
        }
        return documents;
    }

    /* -------- BASE64 ARRAY -------- */
    if (Array.isArray(req.body?.documents)) {
        for (const base64 of req.body.documents) {
            documents.push({
                url: base64,
                mimeType: "image/jpeg",
                size: Buffer.byteLength(base64, "base64"),
            });
        }
    }

    return documents;
}