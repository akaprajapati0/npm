import mongoose, { Schema } from "mongoose";
import { AdminRole, IAdmin } from '../types/adminTypes';

const AdminSchema = new Schema<IAdmin>(
    {
        fullname: { type: String, required: true },
        email: { type: String, required: true, unique: true },
        password: { type: String, required: true },
        role: {
            type: String,
            enum: Object.values(AdminRole),
            required: true,
        },
        refreshToken: {
            type: String,
            select: false,
        },
        isActive: { type: Boolean, default: true },
        expiresAt: { type: Date },
    },
    { timestamps: true }
);

export default mongoose.models.Admin || mongoose.model<IAdmin>("Admin", AdminSchema);