import express, { Application } from "express";
import cookieParser from "cookie-parser";
import "dotenv/config";
import "./config/passport";
import cors from "cors";
import passport from "passport";
import helmet from "helmet";
import morgan from "morgan";
import compression from "compression";

import { detectDevice } from "./middleware/detectDevice";
// Init listeners
import "./listeners/caretaker.listener";


// Routes
import adminRouter from "./routes/adminAuth.routes";
import userRoute from "./routes/userAuth.routes";
import caretakerRoute from "./routes/caretaker.routes";
import patientRouter from "./routes/patient.routes"
import prescribedRouter from "./routes/prescribedMedicine.routes";
import doctorRouter from "./routes/doctorDetails.routes";
import prescriptionRouter from "./routes/prescription.routes";
import kycRouter from "./routes/kyc.routes";
import docsRequestRouter from "./routes/docsRequest.routes"
import bankRecieptRouter from "./routes/bankReciept.routes";
import cdecRouter from "./routes/cdec.routes";
import orderRouter from "./routes/order.routes";
import trackingRouter from "./routes/tracking.routes";
// import chatbotRouter from "./routes/chatbot.routes";
import medicinesRouter from "./routes/medicines.routes";
import addressRouter from "./routes/address.routes"
import feedbackRoutes from "./routes/feedback.routes"
import paymentRouter from "./routes/payment.routes";
import documentRoutes from "./routes/documents.routes";
import path from 'path';

const app: Application = express();

app.use(
  "/uploads",
  express.static(path.join(process.cwd(), "uploads"))
);

// app.use(helmet());
app.use(
  helmet({
    crossOriginResourcePolicy: false,
  })
);

app.use(compression());
app.use(cookieParser());
app.use(morgan("combined"));
app.use(express.json({ limit: "10mb" }));
app.use(express.urlencoded({ extended: true }));

// CORS
const allowedOrigins = process.env.CORS_ORIGINS?.split(",") || [];

app.use(
  cors({
    origin: (origin, callback) => {
      if (!origin || allowedOrigins.includes(origin)) {
        callback(null, true);
      } else {
        callback(new Error("CORS not allowed"));
      }
    },
    credentials: true,
  })
);

// Auth
app.use(passport.initialize());

// Custom middleware
app.use(detectDevice);

// Routes
app.use("/api/admin", adminRouter);
app.use("/api/auth", userRoute);
app.use("/api/caretaker", caretakerRoute);
app.use("/api/patient", patientRouter);
app.use("/api/prescribed-medicine", prescribedRouter);
app.use("/api/doctor-details", doctorRouter);
app.use("/api/prescription", prescriptionRouter);
app.use("/api/kyc", kycRouter);
app.use("/api/request", docsRequestRouter)
app.use("/api/bank-receipt", bankRecieptRouter);
app.use("/api/cdec", cdecRouter);
// app.use("/api/chatbot", chatbotRouter);
app.use("/api/delivery-address", addressRouter)
app.use("/api/order", orderRouter);
app.use("/api/tracking", trackingRouter);
app.use("/api/medicines", medicinesRouter)
app.use("/api", feedbackRoutes);
app.use("/api/payment", paymentRouter);
app.use("/api/documents", documentRoutes);


app.use("/api/test", (req, res) => {
  return res.status(200).json({ message: "Server is live" });
});

// 404
app.use((req, res) => {
  res.status(404).json({ message: "Route not found" });
});

// Error handler
app.use((err: any, req: any, res: any, next: any) => {
  console.error(err);

  if (err instanceof SyntaxError && "body" in err) {
    return res.status(400).json({ message: "Invalid JSON body" });
  }

  res.status(err.status || 500).json({
    message: err.message || "Internal Server Error",
  });
});


export default app;
