import mongoose, { Schema } from "mongoose";

const OrderTrackingSchema = new Schema(
    {
        order: { type: Schema.Types.ObjectId, ref: "Order", required: true },
        orderNumber: { type: String },
        status: {
            type: String,
            enum: [
                "order_created",
                "processing",
                "verified",
                "packaged",
                "shipped",
                "out_for_delivery",
                "delivered",
            ],
            required: true,
        },

        message: { type: String },
    },
    { timestamps: true }
);

export default mongoose.model("OrderTracking", OrderTrackingSchema);


// models/OrderTracking.ts (or inside models/Order.ts as sub-schema)


// export const OrderTrackingSchema = new Schema(
//     {
//         // eventStatus is the new status after this event
//         eventStatus: {
//             type: String,
//             enum: [
//                 "pending",
//                 "awaiting_quote",
//                 "awaiting_payment",
//                 "awaiting_cdec",
//                 "processing",
//                 "dispatched",
//                 "out_for_delivery",
//                 "delivered",
//                 "cancelled",
//                 "failed_payment",
//                 "returned"
//             ],
//             required: true,
//         },

//         note: { type: String, trim: true }, // human readable note

//         // who triggered the event (caretaker, admin, system, courier, pharmacy)
//         updatedBy: {
//             type: String,
//             enum: ["caretaker", "admin", "system", "courier", "pharmacy"],
//             default: "system",
//         },

//         // optional geo location or address string
//         location: {
//             type: {
//                 type: String,
//                 enum: ["Point"],
//                 default: "Point",
//             },
//             coordinates: {
//                 // [lng, lat]
//                 type: [Number],
//                 validate: {
//                     validator: (arr: number[]) =>
//                         !arr || arr.length === 2,
//                     message: "location.coordinates must be [lng, lat]",
//                 },
//             },
//             // fallback address
//             address: { type: String, trim: true },
//         },

//         meta: { type: Schema.Types.Mixed }, // any extra metadata

//         createdAt: { type: Date, default: Date.now },
//     },
//     { _id: false } // store as embedded doc w/o its own id
// );
