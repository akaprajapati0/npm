import mongoose, { Schema } from "mongoose";

const PatientSchema = new Schema(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true, index: true },
        caretaker: { type: Schema.Types.ObjectId, ref: "Caretaker", required: true, index: true },

        fullname: { type: String, required: true, trim: true },

        dateOfBirth: { type: Date, required: true },

        gender: {
            type: String, trim: true, required: true
        },

    },
    { timestamps: true }
);

export default mongoose.model("Patient", PatientSchema);
