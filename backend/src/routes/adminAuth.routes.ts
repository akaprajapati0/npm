import express from "express";
import { adminProtect, authorizePermissions } from "../middleware/authMiddleware";
import { createAdmin, deleteAdmin, getAdminById, getAllAdmins, loginAdmin, logoutAdmin, refreshTokenHandler, updateAdmin } from "../controllers/admin.controller";
import { Permission } from '../types/adminTypes';

const router = express.Router();

router.post(
    "/create",
    adminProtect,
    authorizePermissions(Permission.CREATE_ADMIN),
    createAdmin
);

router.get(
    "/",
    adminProtect,
    authorizePermissions(Permission.READ_ADMIN),
    getAllAdmins
);

router.get(
    "/:id",
    adminProtect,
    authorizePermissions(Permission.READ_ADMIN),
    getAdminById
);

router.put(
    "/update/:id",
    adminProtect,
    authorizePermissions(Permission.UPDATE_ADMIN),
    updateAdmin
);

router.delete(
    "/delete/:id",
    adminProtect,
    authorizePermissions(Permission.DELETE_ADMIN),
    deleteAdmin
);

router.post("/login", loginAdmin);
router.post("/refresh", refreshTokenHandler);
router.post("/logout", adminProtect, logoutAdmin);

export default router;