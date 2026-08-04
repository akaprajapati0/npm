import express from "express";
import {
  submitCDEC,
  // getCDECById,
  // updateCDEC,
  // deleteCDEC,
  getCdecByUserId,
  updateCdecStatus,
  getDownloadableDocument,
  // addCdecFormByAdmin,
  uploadCdecDocumentByAdmin,
  getDownloadableDocumentByAdmin,
} from "../controllers/cdec.controller";
import { adminProtect, authorizePermissions, protectAuth } from "../middleware/authMiddleware";
import { uploadFiles } from "../middleware/multer";
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.post(
  "/upload",
  protectAuth,
  uploadFiles("cdec-documents"),
  submitCDEC
);

// router.get("/all", protectAuth, getAllCDEC);
// router.get("/admin", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllCDEC);
// router.get("/:id", protectAuth, getCDECById);
router.get("/", protectAuth, getCdecByUserId);

router.put("/status/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), updateCdecStatus)
router.put("/admin/update/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), uploadFiles("downloadable-form"), uploadCdecDocumentByAdmin)

// router.post("/admin/upload/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), uploadFiles("downloadable-form"), addCdecFormByAdmin)

router.get("/user/get", protectAuth, getDownloadableDocument)

router.get("/admin/get/:id", adminProtect, authorizePermissions(Permission.READ_ADMIN), getDownloadableDocumentByAdmin)

// router.put(
//   "/update/:id",
//   adminProtect,
//   authorizePermissions(Permission.UPDATE_ADMIN),
//   uploadFiles("cdec-documents"),
//   updateCDEC
// );

// router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteCDEC);

export default router;
