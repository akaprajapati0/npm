import mongoose, { Schema, Document, Model } from "mongoose";

export interface IPayment {
    amount: number;
    receivedOn: Date;
}

export interface IOrder extends Document {
    user: mongoose.Types.ObjectId;
    invoiceAmount: number;
    payments: IPayment[];
    totalReceived: number;
    balanceAmount: number;
    createdAt: Date;
    updatedAt: Date;
}

const PaymentSchema = new Schema<IPayment>(
    {
        amount: { type: Number, required: true, min: 0 },
        receivedOn: { type: Date, required: true, default: Date.now },
    },
    { _id: true }
);

const OrderSchema = new Schema<IOrder>(
    {
        user: { type: Schema.Types.ObjectId, ref: "User", required: true, index: true },

        invoiceAmount: {
            type: Number,
            required: true,
            min: 0,
        },

        payments: {
            type: [PaymentSchema],
            default: [],
        },

        totalReceived: {
            type: Number,
            default: 0,
        },

        balanceAmount: {
            type: Number,
            default: 0,
        },
    },
    { timestamps: true }
);

OrderSchema.pre("save", function (next) {
    const order = this as IOrder;

    order.totalReceived = order.payments.reduce((sum, p) => sum + p.amount, 0);
    order.balanceAmount = Math.max(order.invoiceAmount - order.totalReceived, 0);

    next();
});

function getOrCreateModel(name: string, schema: Schema<IOrder>): Model<IOrder> {
    return (mongoose.models[name] as Model<IOrder>) ?? mongoose.model<IOrder>(name, schema);
}

export const Order = getOrCreateModel("Order", OrderSchema);
export default Order;