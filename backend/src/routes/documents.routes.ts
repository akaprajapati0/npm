import { Router } from "express";
import {
    uploadAllDocuments,
    getDocuments,
    getDocumentByUserId,
    deleteDocument,
} from "../controllers/document.controller";
import { uploadAllDocumentsMiddleware } from '../middleware/multer';
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { Permission } from '../types/adminTypes';

const router = Router();

// Single call: uploads all 7 required documents (+ optional additionalDocuments[])
// and creates the record in one request.
router.post("/upload", adminProtect, authorizePermissions(Permission.READ_ADMIN), uploadAllDocumentsMiddleware, uploadAllDocuments);

// Fetch: list all, or one by ?reference=
router.get("/", getDocuments);
// Fetch one by Mongo _id
router.get("/user-document", protectAuth, getDocumentByUserId);

// Delete
router.delete("/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteDocument);

export default router;