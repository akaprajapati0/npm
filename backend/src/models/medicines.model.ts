import mongoose, { Schema } from "mongoose";
import { PresMedicineTypes } from '../types/schemaTypes';

const MedicineSchema = new Schema<PresMedicineTypes>(
    {
        medicineName: {
            type: String,
            required: true,
            index: true,
            trim: true,
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
    },
    { timestamps: true, strict: true }
);

/** Text search index */
MedicineSchema.index({
    medicineName: "text",
    ActiveIngredients: "text",
});

export default mongoose.model("Medicine", MedicineSchema);