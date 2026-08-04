import mongoose, { Document, Schema } from "mongoose";

export interface ImageType {
    url: string;
    mimeType?: string;
    size?: number;
}

export interface UserTypes extends Document {
    image?: ImageType,
    email?: string,
    phone?: string,
    password?: string,
    googleId?: string,
    country?: string,
    authProvider: "local" | "google";
    role: "user",
    progress: "none" | "caretaker_uploaded" | "prescribed_uploaded" | "doctor_uploaded" | "prescription_uploaded" | "kyc_uploaded" | "request_quotation" | "request_invoice" | "request_license" | "bank_receipt_uploaded" | "cdec_uploaded" | "address_added" | "address_skipped" | "completed";
    patients: mongoose.Types.ObjectId[];
    orders?: mongoose.Types.ObjectId[];
    isDeactivated: boolean,
    deactivatedAt: Date,
    scheduledDeletionAt: Date,

    refreshToken?: string,

    comparePassword(candidatePassword: string): Promise<boolean>;
}

export interface CaretakerTypes extends Document {
    user: mongoose.Types.ObjectId;

    fullname: string;
    email?: string;
    relationship: string;
    country: string;
    city: string;
    pincode: string;
    phone: string;
    status: "pending" | "approved" | "rejected";

    // orders: mongoose.Types.ObjectId[];
    // resetPasswordToken?: string;
    // resetPasswordExpires?: Date;
    // role: "string";

    // refreshToken?: string;
    // comparePassword(candidatePassword: string): Promise<boolean>;
}

export interface PresMedicineTypes extends Document {
    user: mongoose.Types.ObjectId;
    medicineName?: string;
    strength?: string;
    dosage?: string;
    ActiveIngredients?: string;
    manufacturer?: string;
    quantity?: string;
    packSize?: string;
    storageConditions?: string;
    status: "pending" | "approved" | "rejected";
}

export interface DoctorDetailsTypes extends Document {
    user: mongoose.Types.ObjectId;

    fullname: string;
    specialization: string;
    clinicName: string;
    country: string;
    city: string;
    doctorRegistrationNumber?: string;
    email?: string;
    status: "pending" | "approved" | "rejected";
}

// export interface SchemaTypes extends Document {
//     user: mongoose.Types.ObjectId;
//     documents: ImageType[];
//     status: "pending" | "approved" | "rejected";
// }
// --- Shared types ---
export type RequestStatus = "Pending" | "Requested" | "Approved" | "Rejected" | "Revise_Request";

export interface IDocumentRequest extends Document {
    user: mongoose.Types.ObjectId;
    status: RequestStatus;
    documents: ImageType[];
    remarks?: string;
    requestedAt?: Date;
    approvedAt?: Date;
    rejectedAt?: Date;
    reviseAt?: Date;
    createdAt: Date;
    updatedAt: Date;
}

export const STATUS_VALUES: RequestStatus[] = [
    "Pending",
    "Requested",
    "Approved",
    "Rejected",
    "Revise_Request"
];

export interface BankRecieptTypes extends Document {
    user: mongoose.Types.ObjectId;
    documentNumber: string;
    documents: ImageType[];
    status: "pending" | "approved" | "rejected";
}

export interface AddressDocument extends Document {
    user: mongoose.Types.ObjectId;
    name?: string;
    phone: string;
    houseName: string;
    roadName: string;
    city: string;
    state: string;
    country: string;
    pincode: string;
    landmark?: string;
    checkMark: boolean;
    isDefault: boolean;
}

export interface IPatientProgress extends Document {
    patient: mongoose.Types.ObjectId;
    prescribedMedicinesAdded: boolean;
    doctorAdded: boolean;
    prescriptionApproved: boolean;
    kycCompleted: boolean;
    bankReceiptUploaded: boolean;
    cdecUploaded: boolean;
    autoOrderPlaced: boolean;
}

export interface ICurrentDeliveryAddress extends Document {
    patient: Schema.Types.ObjectId
    caretaker: Schema.Types.ObjectId
    user: Schema.Types.ObjectId;
    address: string;
    city: string;
    state: string;
    pinCode: string;
    country: string;
    phone: string;
    declaration: boolean;
}

// export interface IOrder extends Document {
//     caretaker: mongoose.Types.ObjectId;
//     patient: mongoose.Types.ObjectId;
//     doctor: mongoose.Types.ObjectId;
//     prescription: mongoose.Types.ObjectId;
//     kyc: mongoose.Types.ObjectId;
//     // medicineQuotation: mongoose.Types.ObjectId,
//     bankReceipt?: mongoose.Types.ObjectId;
//     cdec?: mongoose.Types.ObjectId;

//     status: string;
//     tracking: Array<any>;

//     addTrackingEvent(event: {
//         eventStatus: string;
//         note?: string;
//         updatedBy?: string;
//         location?: { coordinates?: number[]; address?: string };
//         meta?: any;
//     }): Promise<void>;
// }

export const ImageSchema = new Schema(
    {
        url: { type: String, required: true },
        mimeType: { type: String, required: false },
        size: { type: Number, required: false },
    },
    { _id: false }
);

// Feedback controller types
export interface IFeedback extends Document {
    user: mongoose.Types.ObjectId;
    rating: number;
    feedback?: string;
    followUp?: boolean;
}