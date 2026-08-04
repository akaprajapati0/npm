import multer from "multer";
import path from "path";
import fs from "fs";

/* -------- STORAGE -------- */
const storage = multer.diskStorage({
    destination: (_req, _file, cb) => {
        const dir = path.join("uploads", "medicines");
        if (!fs.existsSync(dir)) {
            fs.mkdirSync(dir, { recursive: true });
        }
        cb(null, dir);
    },

    filename: (_req, file, cb) => {
        const name = path.parse(file.originalname).name.replace(/\s+/g, "-");
        const unique = `${name}-${Date.now()}`;
        cb(null, unique + path.extname(file.originalname).toLowerCase());
    },
});

/* -------- FILE FILTER -------- */
const fileFilter: multer.Options["fileFilter"] = (_req, file, cb) => {
    const allowed = [
        "application/pdf",
        "text/csv",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    ];

    if (!allowed.includes(file.mimetype)) {
        return cb(
            new multer.MulterError(
                "LIMIT_UNEXPECTED_FILE",
                "Only PDF, CSV, or Excel files are allowed"
            )
        );
    }

    cb(null, true);
};

/* -------- EXPORT -------- */
export const uploadMedicineFile = multer({
    storage,
    fileFilter,
    limits: {
        fileSize: 5 * 1024 * 1024,
        files: 1,
    },
}).single("file");
