import mongoose, { Schema } from "mongoose";
import { PresMedicineTypes } from '../types/schemaTypes';

const PrescribedMedicineSchema = new Schema<PresMedicineTypes>(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true },

        medicineName: {
            type: String,
            required: true,
            trim: true,
            index: true,
        },
        ActiveIngredients: {
            type: String,
            required: true,
            trim: true,
            index: true,
        },
        strength: String,
        dosage: String,
        packSize: String,
        quantity: String,
        storageConditions: String,
        manufacturer: String,
        status: { type: String, default: "pending" }
    },
    { timestamps: true }
);

export default mongoose.model("PrescribedMedicine", PrescribedMedicineSchema);