import { Document, Types } from 'mongoose';

export enum AdminRole {
    SUPER_ADMIN = "SUPER_ADMIN",
    ADMIN = "ADMIN",
    TEMP_ADMIN = "TEMP_ADMIN",
}

export interface IAdmin extends Document {
    _id: Types.ObjectId;
    fullname: string;
    email: string;
    password: string;
    role: AdminRole;
    refreshToken?: string;
    isActive: boolean;
    expiresAt?: Date;
}


export enum Permission {
    CREATE_ADMIN = "CREATE_ADMIN",
    READ_ADMIN = "READ_ADMIN",
    UPDATE_ADMIN = "UPDATE_ADMIN",
    DELETE_ADMIN = "DELETE_ADMIN",
}


export const RolePermissions: Record<AdminRole, Permission[]> = {
    SUPER_ADMIN: [
        Permission.CREATE_ADMIN,
        Permission.READ_ADMIN,
        Permission.UPDATE_ADMIN,
        Permission.DELETE_ADMIN,
    ],
    ADMIN: [Permission.READ_ADMIN],
    TEMP_ADMIN: [Permission.READ_ADMIN],
};
