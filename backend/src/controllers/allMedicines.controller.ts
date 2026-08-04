import { Request, Response } from "express";
import Medicine from "../models/medicines.model";
import csv from "csv-parser";
import ExcelJS from "exceljs";
import fs from "fs";
import { detectMedicineHeaders, MedicineInput } from '../utils/medicineHeaderAliases';
const pdfParse = require("pdf-parse");



/* -------- SEARCH MEDICINES (unchanged) -------- */
export const searchMedicines = async (req: Request, res: Response) => {
    try {
        const q = (req.query.q as string)?.trim();

        if (!q || q.length < 2) {
            return res.json({ success: true, data: [] });
        }

        const data = await Medicine.find(
            {
                $or: [
                    { medicineName: { $regex: q, $options: "i" } },
                    { ActiveIngredients: { $regex: q, $options: "i" } },
                ],
            },
            {
                medicineName: 1,
                ActiveIngredients: 1,
                strength: 1,
                dosage: 1,
                packSize: 1,
                storageConditions: 1,
                manufacturer: 1,
            }
        )
            .limit(10)
            .lean();

        res.json({ success: true, data });
    } catch (err) {
        res.status(500).json({ success: false, message: "Search failed" });
    }
};

/* ------- ADD MEDICINE MANUALLY (unchanged) ---------- */
export const addMedicineManually = async (req: Request, res: Response) => {
    try {
        const payload = req.body;

        if (!payload.medicineName || !payload.ActiveIngredients) {
            return res.status(400).json({
                success: false,
                message: "Medicine name & ingredients required",
            });
        }

        const exists = await Medicine.findOne({
            medicineName: payload.medicineName,
            ActiveIngredients: payload.ActiveIngredients,
        });

        if (exists) {
            return res.status(409).json({
                success: false,
                message: "Medicine already exists",
            });
        }

        const medicine = await Medicine.create(payload);

        res.status(201).json({
            success: true,
            data: medicine,
        });
    } catch {
        res.status(500).json({ success: false, message: "Add failed" });
    }
};

//  -------- CSV UPLOAD -------- 
const safeUnlink = (path?: string) => {
    if (!path) return;
    if (fs.existsSync(path)) fs.unlinkSync(path);
};


export const uploadMedicinesCSV = async (
    req: Request,
    res: Response
) => {
    if (!req.file) {
        return res
            .status(400)
            .json({ success: false, message: "CSV file required" });
    }

    const filePath = req.file.path;
    const medicines: MedicineInput[] = [];

    try {
        const rows: Record<string, string>[] = [];

        await new Promise<void>((resolve, reject) => {
            fs.createReadStream(filePath)
                .pipe(csv())
                .on("data", (row: Record<string, string>) => {
                    rows.push(row);
                })
                .on("end", () => resolve())
                .on("error", reject);
        });

        if (rows.length === 0) {
            safeUnlink(filePath);
            return res
                .status(400)
                .json({ success: false, message: "CSV is empty" });
        }

        const headers = Object.keys(rows[0]);
        const headerMap = detectMedicineHeaders(headers);

        if (
            !headerMap.medicineName ||
            !headerMap.ActiveIngredients
        ) {
            safeUnlink(filePath);
            return res.status(400).json({
                success: false,
                message:
                    "Required headers not detected (medicine name, ingredients)",
                detectedHeaders: headers,
            });
        }

        for (const row of rows) {
            const medicine: MedicineInput = {
                medicineName: String(
                    row[headerMap.medicineName]
                ).trim(),
                ActiveIngredients: String(
                    row[headerMap.ActiveIngredients]
                ).trim(),
                strength: headerMap.strength
                    ? String(row[headerMap.strength]).trim()
                    : undefined,
                dosage: headerMap.dosage
                    ? String(row[headerMap.dosage]).trim()
                    : undefined,
                packSize: headerMap.packSize
                    ? String(row[headerMap.packSize]).trim()
                    : undefined,
                quantity: headerMap.quantity
                    ? String(row[headerMap.quantity]).trim()
                    : undefined,
                storageConditions: headerMap.storageConditions
                    ? String(
                        row[headerMap.storageConditions]
                    ).trim()
                    : undefined,
                manufacturer: headerMap.manufacturer
                    ? String(row[headerMap.manufacturer]).trim()
                    : undefined,
            };

            if (
                medicine.medicineName &&
                medicine.ActiveIngredients
            ) {
                medicines.push(medicine);
            }
        }

        if (medicines.length === 0) {
            safeUnlink(filePath);
            return res.status(400).json({
                success: false,
                message: "No valid medicine records found in CSV",
            });
        }

        //  --------- DUPLICATE DETECTION (name + ingredients) --------- 
        const existing = await Medicine.find({
            medicineName: {
                $in: medicines.map((m) => m.medicineName),
            },
        }).select("medicineName ActiveIngredients");

        const existingSet = new Set(
            existing.map(
                (e) =>
                    `${e.medicineName}|${e.ActiveIngredients}`
            )
        );

        const uniqueMedicines = medicines.filter(
            (m) =>
                !existingSet.has(
                    `${m.medicineName}|${m.ActiveIngredients}`
                )
        );

        if (uniqueMedicines.length === 0) {
            safeUnlink(filePath);
            return res.status(409).json({
                success: false,
                message:
                    "All medicines already exist in database",
            });
        }

        await Medicine.insertMany(uniqueMedicines, {
            ordered: false,
        });

        safeUnlink(filePath);

        return res.json({
            success: true,
            inserted: uniqueMedicines.length,
            skipped: medicines.length - uniqueMedicines.length,
        });
    } catch (error) {
        console.error("CSV upload error:", error);
        safeUnlink(filePath);
        return res.status(500).json({
            success: false,
            message: "Failed to process CSV file",
        });
    }
};

/* ------- EXCEL UPLOAD (unchanged logic) -------- */
export const uploadMedicinesExcel = async (req: Request, res: Response) => {
    try {
        if (!req.file) {
            return res.status(400).json({ success: false, message: "File required" });
        }

        const workbook = new ExcelJS.Workbook();
        await workbook.xlsx.readFile(req.file.path);

        const worksheet = workbook.worksheets[0];
        const medicines: MedicineInput[] = [];

        worksheet.eachRow((row, rowNumber) => {
            if (rowNumber === 1) return; // skip header

            const medicine: MedicineInput = {
                medicineName: String(row.getCell(1).value || "").trim(),
                ActiveIngredients: String(row.getCell(2).value || "").trim(),
                strength: String(row.getCell(3).value || "").trim(),
                dosage: String(row.getCell(4).value || "").trim(),
                packSize: String(row.getCell(5).value || "").trim(),
                storageConditions: String(row.getCell(6).value || "").trim(),
                manufacturer: String(row.getCell(7).value || "").trim(),
            };

            if (medicine.medicineName && medicine.ActiveIngredients) {
                medicines.push(medicine);
            }
        });

        if (medicines.length === 0) {
            return res.status(400).json({ success: false, message: "No valid data found in file" });
        }

        await Medicine.insertMany(medicines, { ordered: false });
        fs.unlinkSync(req.file.path);

        res.json({ success: true, count: medicines.length });
    } catch (error) {
        console.error("Excel upload error:", error);
        res.status(500).json({ success: false, message: "Failed to upload Excel" });
    }
};


/* ------- PDF PARSING SUPPORT -------- */
export const uploadMedicinesPDF = async (req: Request, res: Response) => {
    try {
        if (!req.file) return res.status(400).json({ success: false, message: "PDF required" });

        const buffer = fs.readFileSync(req.file.path);
        const data = await pdfParse(buffer);

        const lines: string[] = data.text.split("\n");

        const medicines: MedicineInput[] = lines
            .map((line: string) => {
                const parts = line.split("|").map((p: string) => p.trim());
                if (parts.length < 2) return null;

                return {
                    medicineName: parts[0],
                    ActiveIngredients: parts[1],
                    strength: parts[2] || "",
                    dosage: parts[3] || "",
                    manufacturer: parts[4] || "",
                };
            })
            .filter(Boolean) as MedicineInput[];

        if (medicines.length === 0) {
            fs.unlinkSync(req.file.path);
            return res.status(400).json({ success: false, message: "No valid data in PDF" });
        }

        await Medicine.insertMany(medicines, { ordered: false });
        fs.unlinkSync(req.file.path);

        res.json({ success: true, count: medicines.length });
    } catch (error) {
        console.error("PDF upload error:", error);
        res.status(500).json({ success: false, message: "Failed to parse PDF" });
    }
};

