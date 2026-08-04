import { createDoctorDetails, deleteDoctor, getDoctorByUserId, getDoctorCount } from '../controllers/doctorDetails.controller';
import express from "express";
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { Permission } from '../types/adminTypes';


const router = express.Router();

router.post("/add", protectAuth, createDoctorDetails);
router.get("/", protectAuth, getDoctorByUserId);
router.get("/count", protectAuth, getDoctorCount);
// router.get("/doctor/:id", protectAuth, getDoctorById);
// router.get("/doctors", protectAuth, getAllDoctors);
// router.get("/admin", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllDoctors);
// router.put("/update/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), updateDoctorByAdmin);
router.delete("/delete/:id", adminProtect, authorizePermissions(Permission.DELETE_ADMIN), deleteDoctor);

export default router;