import mongoose, { Schema } from "mongoose";
import { ImageSchema } from "../types/schemaTypes";

const CDECSchema = new Schema(
    {
        user: {
            type: Schema.Types.ObjectId,
            ref: "User",
            required: true,
            index: true,
        },

        documents: {
            type: [ImageSchema],
            default: [],
        },

        downloadDocument: {
            type: ImageSchema
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

export default mongoose.model("CDEC", CDECSchema);