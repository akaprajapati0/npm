import mongoose, { Schema } from "mongoose";

const OtpSchema = new Schema(
    {
        identifier: {
            type: String,
            required: true,
            index: true,
        },
        otp: {
            type: String,
            required: true,
        },
        expiresAt: {
            type: Date,
            required: true,
        },
    },
    { timestamps: true }
);

export default mongoose.model("Otp", OtpSchema);
