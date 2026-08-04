import mongoose, { Schema, Document } from "mongoose";
import { AddressDocument } from 'types/schemaTypes';

const AddressSchema = new Schema<AddressDocument>(
    {
        user: {
            type: Schema.Types.ObjectId,
            ref: "User",
            required: true,
            index: true,
        },

        name: {
            type: String,
            trim: true,
        },

        phone: {
            type: String,
            required: true,
            match: [/^\+\d{10,15}$/, "Invalid phone number"],
            index: true,
        },

        houseName: {
            type: String,
            required: true,
            trim: true,
        },

        roadName: {
            type: String,
            required: true,
            trim: true,
        },

        city: {
            type: String,
            required: true,
            trim: true,
        },

        state: {
            type: String,
            required: true,
            trim: true,
        },

        country: {
            type: String,
            required: true,
            trim: true,
        },

        pincode: {
            type: String,
            required: true,
            trim: true,
            minlength: 4,
            maxlength: 10,
        },

        landmark: {
            type: String,
            trim: true,
        },

        checkMark: {
            type: Boolean,
            required: true,
            default: false,
        },

        isDefault: {
            type: Boolean,
            default: false,
        },
    },
    {
        timestamps: true,
        versionKey: false,
    }
);

export default mongoose.model<AddressDocument>("Address", AddressSchema);

//

// const CurrentDeliverySchema = new Schema<ICurrentDeliveryAddress>(
//     {
//         patient: { type: Schema.Types.ObjectId, ref: "Patient", required: true },
//         caretaker: { type: Schema.Types.ObjectId, ref: "Caretaker", required: true },

//         address: {
//             type: String,
//             required: true,
//             trim: true,
//         },
//         city: {
//             type: String,
//             required: true,
//             trim: true,
//         },
//         state: {
//             type: String,
//             required: true,
//             trim: true,
//         },
//         pinCode: {
//             type: String,
//             required: true,
//             match: [/^\d{5,6}$/, "Invalid pin code"],
//         },
//         country: {
//             type: String,
//             required: true,
//             trim: true,
//         },
//         phone: {
//             type: String,
//             required: true,
//             match: [/^\+\d{10,15}$/, "Invalid phone number"],
//         },
//         declaration: {
//             type: Boolean,
//             required: true,
//             validate: {
//                 validator: (v: boolean) => v === true,
//                 message: "Declaration must be accepted",
//             },
//         },
//     },
//     { timestamps: true }
// );

// export default model<ICurrentDeliveryAddress>(
//     "CurrentDeliveryAddress",
//     CurrentDeliverySchema
// );
