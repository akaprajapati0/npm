import mongoose, { Schema } from "mongoose";
import bcrypt from "bcryptjs";

import { ImageSchema, UserTypes } from "../types/schemaTypes";

const UserSchema = new Schema<UserTypes>(
    {
        image: {
            type: ImageSchema,
            default: null,
        },

        email: {
            type: String,
            lowercase: true,
            trim: true,
            unique: true,
            sparse: true,
            index: true,
        },

        phone: {
            type: String,
            trim: true,
            match: [/^\+\d{10,15}$/, "Invalid phone number"],
            sparse: true,
            index: true,
        },

        password: {
            type: String,
            minlength: 6,
            select: false,
        },

        googleId: {
            type: String,
            unique: true,
            sparse: true,
        },

        authProvider: {
            type: String,
            enum: ["local", "google"],
            default: "local",
        },

        progress: {
            type: String,
            enum: [
                "none",
                "caretaker_uploaded",
                "prescribed_uploaded",
                "doctor_uploaded",
                "prescription_uploaded",
                "kyc_uploaded",
                "request_quotation",
                "request_invoice",
                "request_license",
                "bank_receipt_uploaded",
                "cdec_uploaded",
                "address_added",
                "address_skipped",
                "completed",
            ],
            default: "none",
        },

        role: {
            type: String,
            enum: ["user"],
            default: "user",
        },

        country: {
            type: String,
            trim: true,
        },

        patients: [
            {
                type: Schema.Types.ObjectId,
                ref: "Patient",
            },
        ],

        orders: [
            {
                type: Schema.Types.ObjectId,
                ref: "Order",
            },
        ],

        isDeactivated: {
            type: Boolean,
            default: false,
            index: true,
        },

        deactivatedAt: {
            type: Date,
            default: null,
        },

        scheduledDeletionAt: {
            type: Date,
            default: null,
        },

        refreshToken: {
            type: String,
            select: false,
            default: null,
        },
    },
    {
        timestamps: true,
    }
);

/* Hash password before save */
UserSchema.pre("save", async function (next) {
    try {
        if (!this.isModified("password") || !this.password) {
            return next();
        }

        const salt = await bcrypt.genSalt(10);

        this.password = await bcrypt.hash(this.password, salt);

        next();
    } catch (error) {
        next(error as Error);
    }
});

/* Compare password */
UserSchema.methods.comparePassword = async function (
    candidatePassword: string
): Promise<boolean> {
    if (!this.password) return false;

    return bcrypt.compare(candidatePassword, this.password);
};

const User =
    mongoose.models.User ||
    mongoose.model<UserTypes>("User", UserSchema);

export default User;

// import mongoose, { Schema } from "mongoose";
// import bcrypt from "bcryptjs";
// import { ImageSchema, UserTypes } from "../types/schemaTypes";

// const UserSchema = new Schema<UserTypes>(
//     {
//         image: {
//             type: ImageSchema,
//             default: null,
//         },
//         email: {
//             type: String,
//             lowercase: true,
//             trim: true,
//             unique: true,
//             sparse: true,
//         },

//         phone: {
//             type: String,
//             match: [/^\+\d{10,15}$/, "Invalid phone number"],
//             index: true,
//         },

//         password: {
//             type: String,
//         },


//         googleId: {
//             type: String,
//             unique: true,
//             sparse: true,
//         },

//         authProvider: {
//             type: String,
//             enum: ["local", "google"],
//             default: "local",
//         },

//         progress: {
//             type: String,
//             enum: ["none", "caretaker_uploaded", "prescribed_uploaded", "doctor_uploaded", "prescription_uploaded", "kyc_uploaded", "request_quotation", "request_invoice", "request_license", "bank_receipt_uploaded", "cdec_uploaded", "address_added", "address_skipped", "completed"],
//             default: "none"
//         },

//         role: {
//             type: String,
//             enum: ["user"],
//             default: "user",
//         },

//         country: { type: String },
//         patients: [{ type: Schema.Types.ObjectId, ref: "Patient" }],
//         orders: [{ type: Schema.Types.ObjectId, ref: "Order" }],

//         isDeactivated: {
//             type: Boolean,
//             default: false,
//         },

//         deactivatedAt: {
//             type: Date,
//             default: null,
//         },

//         refreshToken: {
//             type: String,
//             select: false,
//             default: null,
//         },
//     },
//     { timestamps: true }
// );

// /* Hash password */
// UserSchema.pre("save", async function (next) {
//     if (!this.isModified("password") || !this.password) return next();
//     this.password = await bcrypt.hash(this.password, 10);
//     next();
// });

// UserSchema.methods.comparePassword = function (
//     candidatePassword: string
// ): Promise<boolean> {
//     return bcrypt.compare(candidatePassword, this.password);
// };

// export default mongoose.model("User", UserSchema);

// progress: {
//     caretakerUploaded: { type: Boolean, default: false },
//     prescribedUploaded: { type: Boolean, default: false },
//     doctorUploaded: { type: Boolean, default: false },
//     prescriptionUploaded: { type: Boolean, default: false },
//     kycUploaded: { type: Boolean, default: false },
//     requestDocumentUploaded: { type: Boolean, default: false },
//     bankReceiptUploaded: { type: Boolean, default: false },
//     cdecUploaded: { type: Boolean, default: false },
//     addressAdded: { type: Boolean, default: false },
// },