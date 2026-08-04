import mongoose, { Schema } from "mongoose";
import { ImageSchema } from '../types/schemaTypes';

const KYCSchema = new Schema(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true },

        documentType: {
            type: String,
            enum: ["aadhaar", "passport"],
            required: true,
        },

        documentNumber: {
            type: String,
            required: true,
        },

        documents: {
            type: [ImageSchema],
            required: true
        },
        status: {
            type: String,
            enum: ["pending", "approved", "rejected"],
            default: "pending",
        },
        rejectionReason: {
            type: String,
        },
    },
    { timestamps: true }
);

export default mongoose.model("KYC", KYCSchema);
