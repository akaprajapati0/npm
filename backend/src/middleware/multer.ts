import multer from "multer";
import path from "path";
import fs from "fs";

/* -------- CREATE STORAGE --------- */
const createStorage = (folder: string) => {
    const dir = path.join("uploads", folder);

    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
    }

    return multer.diskStorage({
        destination: (_req, _file, cb) => {
            cb(null, dir);
        },
        filename: (_req, file, cb) => {
            const name = path.parse(file.originalname).name.replace(/\s+/g, "-");
            const unique = `${name}-${Date.now()}-${Math.round(Math.random() * 1e9)}`;
            cb(null, unique + path.extname(file.originalname).toLowerCase());
        },
    });
};

/* -------- VALIDATION --------- */
const allowedMimeTypes = [
    "image/jpeg",
    "image/jpg",
    "image/png",
    "image/webp",
    "application/pdf",
    "application/msword",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
];

const allowedExtensions = [
    ".jpg",
    ".jpeg",
    ".png",
    ".webp",
    ".pdf",
    ".doc",
    ".docx",
];

/* ------- FILE FILTER -------- */
const fileFilter: multer.Options["fileFilter"] = (_req, file, cb) => {
    const ext = path.extname(file.originalname).toLowerCase();

    if (
        !allowedMimeTypes.includes(file.mimetype) ||
        !allowedExtensions.includes(ext)
    ) {
        return cb(
            new multer.MulterError(
                "LIMIT_UNEXPECTED_FILE",
                "Only image and document files are allowed"
            )
        );
    }

    cb(null, true);
};

/* ------- EXPORTS -------- */

// For prescriptions (multiple images)
export const uploadFiles = (folder = "prescriptions") =>
    multer({
        storage: createStorage(folder),
        fileFilter,
        limits: {
            fileSize: 5 * 1024 * 1024, // 5MB
            files: 12,
        },
    }).array("images", 12);

/**
* For uploading all 7 required documents in a single request.
* Each form field name below must match exactly what the client sends
* (e.g. <input name="gstBill" type="file" />).
*/
const ALL_DOCUMENT_FIELDS = [
    "proformaInvoice",
    "commercialInvoice",
    "importLicense",
    "packingList",
    "gstBill",
    "cdecForm",
    "deliveryReceipt",
];

export const uploadAllDocumentsMiddleware = multer({
    storage: createStorage("documents"),
    fileFilter,
    limits: {
        fileSize: 5 * 1024 * 1024, // 5MB per file
        files: ALL_DOCUMENT_FIELDS.length + 10, // +10 headroom for additionalDocuments
    },
}).fields([
    ...ALL_DOCUMENT_FIELDS.map((name) => ({ name, maxCount: 1 })),
    { name: "additionalDocuments", maxCount: 10 },
]);