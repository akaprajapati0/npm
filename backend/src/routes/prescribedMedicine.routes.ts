import express from "express";
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { createPrescribedMedicine, deleteMedicine, getMedicinesCount, getPrescribeMedByUserId, updatePresMedicineByAdmin } from "../controllers/prescribedMedicine.controller";
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.post("/add", protectAuth, createPrescribedMedicine);
router.get("/count", protectAuth, getMedicinesCount);
router.get("/", protectAuth, getPrescribeMedByUserId);
// router.get("/admin", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllMedicine);
router.put("/update/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), updatePresMedicineByAdmin);
router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteMedicine);

export default router;
