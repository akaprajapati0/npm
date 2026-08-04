import jwt from "jsonwebtoken";

export interface AdminJwtPayload {
    id: string;
    role: string;
    type: "access" | "refresh";
}

export const generateAccessToken = (id: string): string => {
    if (!process.env.ACCESS_TOKEN_SECRET) throw new Error("ACCESS_TOKEN_SECRET missing");
    return jwt.sign({ id, type: "access" }, process.env.ACCESS_TOKEN_SECRET, { expiresIn: "15m" });
};

export const generateRefreshToken = (id: string): string => {
    if (!process.env.REFRESH_TOKEN_SECRET) throw new Error("REFRESH_TOKEN_SECRET missing");
    return jwt.sign({ id, type: "refresh" }, process.env.REFRESH_TOKEN_SECRET, { expiresIn: "7d" });
};


export const adminAccessToken = (admin: AdminJwtPayload) =>
    jwt.sign(
        {
            id: admin.id,
            role: admin.role,
            type: "access",
        },
        process.env.ADMIN_ACCESS_SECRET!,
        {
            expiresIn: "30m",
        }
    );

export const adminRefreshToken = (admin: AdminJwtPayload) =>
    jwt.sign(
        {
            id: admin.id,
            role: admin.role,
            type: "refresh",
        },
        process.env.ADMIN_REFRESH_SECRET!,
        {
            expiresIn: "7d",
        }
    );