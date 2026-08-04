import { Router } from "express";
import { getUserFeedback, submitFeedback } from "../controllers/feedback.controller";
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { Permission } from '../types/adminTypes';

const router = Router();

router.post("/feedback", protectAuth, submitFeedback);
router.get("/feedback-get/:id", adminProtect, authorizePermissions(Permission.READ_ADMIN), getUserFeedback);

export default router;