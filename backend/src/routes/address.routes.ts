import express from "express";
import { createAddress } from '../controllers/address.controller';
import { protectAuth } from '../middleware/authMiddleware';

const router = express.Router();

router.post("/add", protectAuth, createAddress);

export default router;
