import { deletePrescription, getPrescriptionByUserId, getPrescriptionsCount, submitPrescription, updatePrescriptionStatus } from "../controllers/prescription.controller";
import express from "express";
import { adminProtect, authorizePermissions, protectAuth } from "../middleware/authMiddleware";
import { uploadFiles } from "../middleware/multer";
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.post(
  "/upload",
  protectAuth,
  uploadFiles("prescriptions"),
  submitPrescription
);

router.get("/count", protectAuth, getPrescriptionsCount);
// router.get("/all", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllPrescriptions);
router.get("/", protectAuth, getPrescriptionByUserId);
router.put("/update/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), updatePrescriptionStatus
);

// router.put(
//   "/update/:id",
//   adminProtect,
//   uploadFiles("prescriptions"),
//   updatePrescription
// );
router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deletePrescription);

export default router;
