import { getAllPatients, getPatientById, getPatientByUserId } from '../controllers/patient.controller';
import express from 'express';
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.get("/", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllPatients);
router.get("/:id", adminProtect, getPatientById);
router.get("/", protectAuth, getPatientByUserId);

export default router;