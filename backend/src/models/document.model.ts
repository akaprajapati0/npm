import mongoose, { Schema, Document } from "mongoose";
import { Image } from '../types/controllersTypes';

const ImageSchema = new Schema<Image>(
    {
        url: { type: String, required: true },
        mimeType: { type: String, required: false },
        size: { type: Number, required: false },
    },
    { _id: false }
);

export interface IShipmentDocument extends Document {
    user: mongoose.Types.ObjectId;
    // importerName?: string;
    // exporterName?: string;
    proformaInvoice: Image;
    commercialInvoice: Image;
    importLicense: Image;
    packingList: Image;
    gstBill: Image;
    cdecForm: Image;
    deliveryReceipt: Image;
    additionalDocuments: Image[];
    // status: "pending" | "verified" | "rejected";
    createdAt: Date;
    updatedAt: Date;
}

export const REQUIRED_DOCUMENT_FIELDS = [
    "proformaInvoice",
    "commercialInvoice",
    "importLicense",
    "packingList",
    "gstBill",
    "cdecForm",
    "deliveryReceipt",
] as const;

const ShipmentDocumentSchema = new Schema<IShipmentDocument>(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true },
        // importerName: { type: String, trim: true },
        // exporterName: { type: String, trim: true },

        // Required: all 7 are uploaded together in a single request.
        proformaInvoice: { type: ImageSchema, required: true },
        commercialInvoice: { type: ImageSchema, required: true },
        importLicense: { type: ImageSchema, required: true },
        packingList: { type: ImageSchema, required: true },
        gstBill: { type: ImageSchema, required: true },
        cdecForm: { type: ImageSchema, required: true },
        deliveryReceipt: { type: ImageSchema, required: true },

        // Optional: extra documents beyond the required 7
        additionalDocuments: { type: [ImageSchema], default: [] },

        // status: {
        //     type: String,
        //     enum: ["pending", "verified", "rejected"],
        //     default: "pending",
        // },
    },
    { timestamps: true }
);

export default mongoose.model<IShipmentDocument>("ShipmentDocument", ShipmentDocumentSchema);