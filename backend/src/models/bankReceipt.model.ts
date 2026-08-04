import mongoose, { Schema } from "mongoose";
import { BankRecieptTypes, ImageSchema } from '../types/schemaTypes';

const BankReceiptSchema = new Schema<BankRecieptTypes>(
    {
        user: {
            type: Schema.Types.ObjectId,
            ref: "User",
            required: true,
            index: true,
        },

        documentNumber: {
            type: String,
            // required: true,
        },

        documents: {
            type: [ImageSchema],
            required: true
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

export default mongoose.model("BankReceipt", BankReceiptSchema);
