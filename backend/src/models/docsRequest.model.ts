import mongoose, { Schema, Model } from "mongoose";
import { IDocumentRequest, ImageSchema, STATUS_VALUES } from "../types/schemaTypes";



function createDocumentRequestSchema(): Schema<IDocumentRequest> {
    return new Schema<IDocumentRequest>(
        {
            user: {
                type: Schema.Types.ObjectId,
                ref: "User",
                required: true,
                index: true, // requests are almost always queried by user
            },
            status: {
                type: String,
                enum: STATUS_VALUES,
                default: "Pending",
                index: true, // and often filtered by status
            },
            documents: {
                type: [ImageSchema],
                default: [],
            },

            remarks: {
                type: String,
                default: "",
            },

            requestedAt: Date,
            approvedAt: Date,
            rejectedAt: Date,
            reviseAt: Date,
        },
        {
            timestamps: true,
        }
    );
}

// --- Model registration guard (prevents OverwriteModelError on hot-reload) ---
function getOrCreateModel(
    name: string,
    schema: Schema<IDocumentRequest>
): Model<IDocumentRequest> {
    return (mongoose.models[name] as Model<IDocumentRequest>) ??
        mongoose.model<IDocumentRequest>(name, schema);
}

export const MedicineQuotationRequest = getOrCreateModel(
    "MedicineQuotationRequest",
    createDocumentRequestSchema()
);

export const ProformaInvoiceRequest = getOrCreateModel(
    "ProformaInvoiceRequest",
    createDocumentRequestSchema()
);

export const ImportLicenseRequest = getOrCreateModel(
    "ImportLicenseRequest",
    createDocumentRequestSchema()
);

// const DocsSchema = new Schema(
//     {
//         status: {
//             type: String,
//             enum: [
//                 "Pending",
//                 "Requested",
//                 "Approved",
//                 "Rejected",
//             ],
//             default: "Pending",
//         },

//         documents: {
//             type: [ImageSchema],
//             default: [],
//         },

//         requestedAt: Date,
//         approvedAt: Date,
//         rejectedAt: Date,
//     },
//     { _id: false }
// );

// const DocsRequestSchema = new Schema(
//     {
//         user: {
//             type: Schema.Types.ObjectId,
//             ref: "User",
//             required: true,
//         },

//         // Status of the entire request cycle
//         status: {
//             type: String,
//             enum: ["Pending", "Completed"],
//             default: "Pending",
//         },

//         medicineQuotation: {
//             type: DocsSchema,
//             default: () => ({}),
//         },

//         proformaInvoice: {
//             type: DocsSchema,
//             default: () => ({}),
//         },

//         importLicense: {
//             type: DocsSchema,
//             default: () => ({}),
//         },

//         remarks: {
//             type: [String],
//             enum: [
//                 "none",
//                 "quotation_requested",
//                 "invoice_requested",
//                 "proforma_requested",
//                 "license_requested",
//             ],
//             default: ["none"],
//         },
//     },
//     {
//         timestamps: true,
//     }
// );

// // Only one active request per user
// DocsRequestSchema.index(
//     { user: 1 },
//     {
//         unique: true,
//         partialFilterExpression: {
//             status: "Pending",
//         },
//     }
// );

// export default mongoose.model(
//     "RequestDocument",
//     DocsRequestSchema
// );

// import mongoose, { Schema } from 'mongoose';
// import { ImageSchema } from "../types/schemaTypes";


// const DocsSchema = new Schema(
//     {
//         status: {
//             type: String,
//             enum: [
//                 "Pending",
//                 "Requested",
//                 "Approved",
//                 "Rejected",
//             ],
//             default: "Pending",
//         },

//         documents: {
//             type: [ImageSchema],
//             default: [],
//         },

//         requestedAt: Date,
//         approvedAt: Date,
//         rejectedAt: Date,
//     },
//     { _id: false }
// );



// const DocsRequestSchema = new Schema(
//     {
//         user: {
//             type: Schema.Types.ObjectId,
//             ref: "User",
//             required: true,
//             index: true,
//         },

//         medicineQuotation: {
//             type: DocsSchema,
//             default: () => ({}),
//         },

//         proformaInvoice: {
//             type: DocsSchema,
//             default: () => ({}),
//         },

//         importLicense: {
//             type: DocsSchema,
//             default: () => ({}),
//         },

//         remarks: {
//             type: [String],
//             enum: ["none", "quotation_requested", "invoice_requested", "proforma_requested", "license_requested"],
//             default: ["none"],
//         }

//     },
//     { timestamps: true }
// );

// // Only one Pending request per user allowed at a time
// DocsRequestSchema.index(
//     { user: 1 },
//     { unique: true, partialFilterExpression: { status: "Pending" } }
// );

// export default mongoose.model(
//     "RequestDocument",
//     DocsRequestSchema
// );
