import express from "express";
import {
  submitBankReceipt,
  deleteBankReceipt,
  updateBankReceiptStatus,
  getBankRecieptByUserId,
} from "../controllers/bankReceipt.controller";
import { adminProtect, authorizePermissions, protectAuth } from "../middleware/authMiddleware";
import { uploadFiles } from "../middleware/multer";
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.post(
  "/upload",
  protectAuth,
  uploadFiles("bank-receipts"),
  submitBankReceipt
);

// router.get("/all", protectAuth, getAllBankReceipt);
// router.get("/admin", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllBankReceipt);

// router.get("/:id", protectAuth, getBankReceiptById);
router.get("/", protectAuth, getBankRecieptByUserId);

router.put(
  "/status/:id",
  adminProtect,
  authorizePermissions(Permission.UPDATE_ADMIN),
  updateBankReceiptStatus
);

// router.put(
//   "/update/:id",
//   adminProtect,
//   authorizePermissions(Permission.UPDATE_ADMIN),
//   uploadFiles("bank-receipts"),
//   updateBankReceipt
// );

router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteBankReceipt);

export default router;
