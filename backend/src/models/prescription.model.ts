import mongoose, { Schema } from "mongoose";
import { ImageSchema } from "../types/schemaTypes";

const PrescriptionSchema = new Schema(
    {
        user: {
            type: Schema.Types.ObjectId,
            ref: "User",
            required: true,
            index: true,
        },

        documents: {
            type: [ImageSchema],
            required: true,
            validate: {
                validator: (v: any[]) => Array.isArray(v) && v.length > 0,
                message: "At least one prescription document is required",
            },
        },

        status: {
            type: String,
            enum: ["pending", "approved", "rejected"],
            default: "pending",
            index: true,
        },
    },
    { timestamps: true }
);

export default mongoose.model(
    "Prescription",
    PrescriptionSchema
);
