import { addMedicineManually, searchMedicines, uploadMedicinesCSV, uploadMedicinesExcel, uploadMedicinesPDF } from '../controllers/allMedicines.controller';
import express from "express";
import { adminProtect } from '../middleware/authMiddleware';
import { uploadMedicineFile } from '../middleware/uploadMedicines';


const router = express.Router();

router.get("/search", searchMedicines);
router.post("/add", adminProtect, addMedicineManually);

router.post("/upload/excel", adminProtect, uploadMedicineFile, uploadMedicinesExcel);
router.post("/upload/csv", uploadMedicineFile, uploadMedicinesCSV);
router.post("/upload/pdf", adminProtect, uploadMedicineFile, uploadMedicinesPDF);

export default router;
