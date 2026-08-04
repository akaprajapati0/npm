import mongoose, { Schema } from "mongoose";

const PaymentSchema = new Schema(
    {
        user: {
            type: Schema.Types.ObjectId,
            ref: "User",
            required: true,
            index: true,
        },
        paymentReceived: { type: String },
        paymentLeft: { type: String },
        accountNumber: { type: String },
        ifsc: { type: String },
        branch: { type: String, },
    },
    { timestamps: true }
);

export default mongoose.models.Payment || mongoose.model("Payment", PaymentSchema);