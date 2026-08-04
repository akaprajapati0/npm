import { Router } from "express";
import { updateOrderTracking } from "../controllers/tracking.controller";

const router = Router();

router.post("/update/:orderId", updateOrderTracking);

export default router;
