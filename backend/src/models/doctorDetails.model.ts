import mongoose, { Schema } from "mongoose";
import { DoctorDetailsTypes } from '../types/schemaTypes';

const DoctorSchema = new Schema<DoctorDetailsTypes>(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true },

        fullname: { type: String, trim: true, required: true },
        specialization: { type: String, trim: true },
        clinicName: { type: String, trim: true, required: true },
        country: { type: String, trim: true },
        city: { type: String, trim: true },
        doctorRegistrationNumber: { type: String, trim: true },
        email: { type: String, trim: true },
        status: { type: String, default: "pending" }
    },
    { timestamps: true }
);

export default mongoose.model("DoctorDetails", DoctorSchema);

