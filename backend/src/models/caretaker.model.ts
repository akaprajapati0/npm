import mongoose, { Schema } from "mongoose";
import { CaretakerTypes } from "../types/schemaTypes";


const CaretakerSchema = new Schema<CaretakerTypes>(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true },

        fullname: { type: String, trim: true, required: true },

        email: {
            type: String,
            lowercase: true,
            trim: true,
            unique: true,
            sparse: true,
            validate: {
                validator: v => !v || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
                message: "Enter a valid email",
            },
        },

        relationship: { type: String, trim: true, required: true },
        country: { type: String, trim: true, required: true },

        city: { type: String, trim: true, required: true },
        pincode: { type: String, trim: true, required: true },

        phone: {
            type: String,
            // required: true,
            match: [/^\+\d{10,15}$/, "Invalid phone number"],
            index: true,
        },

        status: { type: String, default: "pending" }

        // orders: [{ type: Schema.Types.ObjectId, ref: "Order" }],

        // progress: {
        //     type: String,
        //     enum: ["none", "caretaker_uploaded", "prescribed_uploaded", "doctor_uploaded", "prescription_uploaded", "kyc_uploaded", "quotation_uploaded", "bank_receipt_uploaded", "cdec_uploaded", "completed"],
        //     default: "none"
        // },

        // role: {
        //     type: String,
        //     enum: ["user"],
        //     default: "user",
        // },

        // refreshToken: {
        //     type: String,
        //     select: false,
        //     default: null,
        // },


        // resetPasswordToken: String,
        // resetPasswordExpires: Date,
    },
    { timestamps: true }
);

// /* Hash password before save */
// CaretakerSchema.pre<CaretakerTypes>("save", async function (next) {
//     if (!this.isModified("password")) return next();
//     const salt = await bcrypt.genSalt(10);
//     this.password = await bcrypt.hash(this.password!, salt);
//     next();
// });

// /* Instance method to compare password */
// CaretakerSchema.methods.comparePassword = function (
//     candidatePassword: string
// ): Promise<boolean> {
//     return bcrypt.compare(candidatePassword, this.password);
// };

// /* Hide sensitive fields when converting to JSON */
// CaretakerSchema.methods.toJSON = function () {
//     const obj = this.toObject();
//     delete obj.password;
//     delete obj.resetPasswordToken;
//     delete obj.resetPasswordExpires;
//     return obj;
// };

export default mongoose.model<CaretakerTypes>("Caretaker", CaretakerSchema);
