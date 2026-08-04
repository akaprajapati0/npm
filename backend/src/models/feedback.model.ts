import mongoose, { Schema, Document } from "mongoose";
import { IFeedback } from '../types/schemaTypes';


const feedbackSchema = new Schema<IFeedback>(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true },

        rating: {
            type: Number,
            required: true,
            min: 1,
            max: 5,
        },
        feedback: {
            type: String,
            trim: true,
        },
        followUp: {
            type: Boolean,
            default: false,
        },
    },
    { timestamps: true }
);

export const Feedback = mongoose.model<IFeedback>(
    "Feedback",
    feedbackSchema
);