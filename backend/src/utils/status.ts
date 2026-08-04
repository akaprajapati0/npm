import { Document } from 'mongoose';

export const ALLOWED_STATUSES = ["pending", "approved", "rejected"] as const;

export type Status = typeof ALLOWED_STATUSES[number];

export const STATUS = {
    PENDING: "pending",
    APPROVED: "approved",
    REJECTED: "rejected",
} as const;

export interface IUser extends Document {
    phone: string;
    email?: string;
    name?: string;
}
