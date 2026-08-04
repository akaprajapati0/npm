import express from "express";
import { createPayment, getAllPayments, getPaymentsByAdmin, getSinglePayment } from '../controllers/payment.controller';
import { adminProtect, protectAuth } from '../middleware/authMiddleware';

const router = express.Router();

router.post("/create", adminProtect, createPayment)
router.get("/get-all", getAllPayments)
router.get("/get-single", protectAuth, getSinglePayment)
// router.get("/get-single", adminProtect, getSinglePayment)
router.get("/get-single/:id", adminProtect, getPaymentsByAdmin)

export default router;