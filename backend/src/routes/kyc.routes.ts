import express from "express";
import { deleteKYC, getKycByUserId, kycStatusUpdate, submitKYC, } from "../controllers/kyc.controller";
import { adminProtect, authorizePermissions, protectAuth } from "../middleware/authMiddleware";
import { uploadFiles } from "../middleware/multer";
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.post(
  "/upload",
  protectAuth,
  uploadFiles("kyc"),
  submitKYC
);
// router.get("/all", protectAuth, getAllKYC);
// router.get("/admin", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllKYC);
// router.get("/:id", protectAuth, getKYCById);
router.get("/", protectAuth, getKycByUserId);
router.put(
  "/status/:id",
  adminProtect,
  authorizePermissions(Permission.UPDATE_ADMIN),
  kycStatusUpdate
);
// router.put(
//   "/update/:id",
//   adminProtect,
//   authorizePermissions(Permission.UPDATE_ADMIN),
//   uploadFiles("kyc"),
//   updateKYC
// );
router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteKYC)

export default router;
