import { Router } from "express";
import { createOrderDetailsByAdmin, getOrdersByAdmin, getOrdersByUser } from '../controllers/order.controller';
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { Permission } from '../types/adminTypes';

const router = Router();

router.post("/create", adminProtect, authorizePermissions(Permission.CREATE_ADMIN), createOrderDetailsByAdmin);
router.get("/get", protectAuth, getOrdersByUser);
router.get("/get/:id", adminProtect, authorizePermissions(Permission.READ_ADMIN), getOrdersByAdmin);
// router.put("/update/:id", adminProtect, authorizePermissions(Permission.UPDATE_ADMIN), getOrderDetails);

export default router;
