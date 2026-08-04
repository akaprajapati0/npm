import { Router } from "express";
import { deleteCaretaker, getCaretakerProfile, registerCaretaker, updateCaretaker } from "../controllers/caretaker.controller";
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { Permission } from '../types/adminTypes';
import { uploadFiles } from '../middleware/multer';

const router = Router();

router.post("/register", protectAuth, registerCaretaker);
router.get("/me", protectAuth, getCaretakerProfile);
router.put("/update/:caretakerId", protectAuth, uploadFiles("profile-image"), updateCaretaker);
// router.get("/all", protectAuth, getAllCaretaker);
// router.get("/", protectAuth, getCaretakerByUserId);
// router.put("/update/:id", protectAuth, updateCaretakerByUser);

// router.get("/admin", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllCaretaker);
// router.get("/admin/:id", adminProtect, authorizePermissions(Permission.READ_ADMIN), getCaretakerById);
// router.put("/admin/update/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), updateCaretakerByAdmin);
router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteCaretaker);


export default router;