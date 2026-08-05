import express from "express";
import { createAddress, getAddressByUserId, updateAddress } from '../controllers/address.controller';
import { protectAuth } from '../middleware/authMiddleware';

const router = express.Router();

router.post("/add", protectAuth, createAddress);
router.get("/me", protectAuth, getAddressByUserId);
router.put("/update/:id", protectAuth, updateAddress);

export default router;
