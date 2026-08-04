// import express from "express";
// import axios from "axios";

// const router = express.Router();

// router.post("/send-medicine-quotation", async (req, res) => {
//     try {
//         const { mobile } = req.body; // example: "919876543210"

//         const data = {
//             mobile,
//             templateid: process.env.CUNNEKT_TEMPLATE_ID, // your approved template ID
//         };

//         const response = await axios.post(
//             "https://app2.cunnekt.com/v1/sendnotification",
//             data,
//             {
//                 headers: {
//                     "API-KEY": process.env.CUNNEKT_API_KEY,
//                 },
//             }
//         );

//         return res.json({
//             success: true,
//             message: "Template message sent",
//             data: response.data,
//         });
//     } catch (err) {
//         console.log(err);
//         return res.status(500).json({
//             success: false,
//             message: "Failed to send WhatsApp template",
//         });
//     }
// });

// export default router;


//

// import { Router } from "express";
// import axios from "axios";

// const router = Router();

// router.post("/send-quotation", async (req, res) => {
//     try {
//         const { mobile, imageUploaded } = req.body;

//         const message = `
// Medicine Quotation Request Received

// Prescription: ${imageUploaded ? "Uploaded" : "Not Uploaded"}

// Our team will share pricing & availability soon.
//     `;

//         const payload = {
//             mobile,
//             message,
//             campaignid: process.env.CUNNEKT_CAMPAIGN_ID, // If you use bot flow
//         };

//         const response = await axios.post(
//             "https://app2.cunnekt.com/v1/sendnotification",
//             payload,
//             {
//                 headers: {
//                     "API-KEY": process.env.CUNNEKT_API_KEY,
//                 },
//             }
//         );

//         res.json({
//             success: true,
//             data: response.data,
//         });
//     } catch (err: any) {
//         res.status(500).json({
//             error: err.response?.data || err.message,
//         });
//     }
// });

// export default router;
