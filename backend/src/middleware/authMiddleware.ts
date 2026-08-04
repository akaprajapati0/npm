import { Request, Response, NextFunction } from "express";
import jwt from "jsonwebtoken";
import { sendErrorResponse } from '../utils/response';
import Admin from "../models/admin.model";
import { AdminRole, Permission, RolePermissions } from '../types/adminTypes';
import User from '../models/user.model';

export interface AuthRequest extends Request {
    admin?: any;
}

export const adminProtect = async (
    req: AuthRequest,
    res: Response,
    next: NextFunction
) => {
    try {
        const token = req.headers.authorization?.split(" ")[1];
        if (!token)
            return sendErrorResponse(res, 401, "Unauthorized")

        const decoded: any = jwt.verify(token, process.env.ADMIN_ACCESS_SECRET!);

        const admin = await Admin.findById(decoded.id);
        if (!admin || !admin.isActive)
            return sendErrorResponse(res, 401, "Invalid user")


        // TEMP_ADMIN expiry check
        if (admin.role === "TEMP_ADMIN" && admin.expiresAt && admin.expiresAt < new Date()) {
            return sendErrorResponse(res, 403, "Temporary access expired")
        }

        req.admin = admin;
        next();
    } catch (error: any) {
        if (error.name === "TokenExpiredError") {
            return sendErrorResponse(res, 401, "Token expired");
        }

        return sendErrorResponse(res, 401, "Invalid token");
    }
};

export const authorizePermissions = (...required: Permission[]) => {
    return (req: AuthRequest, res: Response, next: NextFunction) => {
        if (!req.admin) {
            return sendErrorResponse(res, 401, "Unauthorized")
        }

        const role: AdminRole = req.admin.role;

        const permissions = RolePermissions[role];

        if (!permissions) {
            return sendErrorResponse(res, 403, "Invalid role")
        }

        const hasPermission = required.every((perm) =>
            permissions.includes(perm)
        );

        if (!hasPermission) {
            return sendErrorResponse(res, 403, "You are not authorized to perform this action")
        }

        next();
    };
};

export const protectAuth = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    try {
        // Get Authorization Header

        const authHeader =
            req.headers.authorization;

        if (
            !authHeader ||
            !authHeader.startsWith("Bearer ")
        ) {
            return sendErrorResponse(
                res,
                401,
                "Not authorized, no token"
            );
        }

        // Extract Token

        const token =
            authHeader.split(" ")[1];

        if (!token) {
            return sendErrorResponse(
                res,
                401,
                "Token missing"
            );
        }

        // Verify Token

        const decoded = jwt.verify(
            token,
            process.env
                .ACCESS_TOKEN_SECRET as string
        ) as {
            id: string;
            type?: string;
        };

        // Optional Token Type Check

        // Recommended if using access/refresh token types

        if (
            decoded.type &&
            decoded.type !== "access"
        ) {
            return sendErrorResponse(
                res,
                403,
                "Invalid token type"
            );
        }

        // Find User

        const user = await User.findById(
            decoded.id
        ).select("-password -refreshToken");

        if (!user) {
            return sendErrorResponse(
                res,
                401,
                "User not found"
            );
        }

        // Deactivated Account Check

        if (user.isDeactivated) {
            return sendErrorResponse(
                res,
                403,
                "Account deactivated"
            );
        }

        // Attach User

        req.user = user;

        next();
    } catch (error: any) {
        // Token Expired

        if (
            error.name ===
            "TokenExpiredError"
        ) {
            return sendErrorResponse(
                res,
                401,
                "Token expired"
            );
        }

        // Invalid Token

        return sendErrorResponse(
            res,
            401,
            "Invalid token"
        );
    }
};

// export const protectAuth = async (
//     req: Request,
//     res: Response,
//     next: NextFunction
// ) => {
//     const authHeader = req.headers.authorization;

//     if (!authHeader?.startsWith("Bearer ")) {
//         return sendErrorResponse(res, 401, "Not authorized, no token");
//     }

//     const token = authHeader.split(" ")[1];

//     try {
//         const decoded = jwt.verify(
//             token,
//             process.env.ACCESS_TOKEN_SECRET as string
//         ) as { id: string, type: string };

//         // console.log(decoded)
//         // if (decoded.type !== "refresh") {
//         //     return sendErrorResponse(res, 403, "Invalid token type");
//         // }
//         const user = await User.findById(decoded.id).select("-password");

//         if (!user) {
//             return sendErrorResponse(res, 401, "User not found");
//         }

//         req.user = user;

//         next();
//     } catch (error: any) {
//         if (error.name === "TokenExpiredError") {
//             return sendErrorResponse(res, 401, "Token expired");
//         }

//         return sendErrorResponse(res, 401, "Invalid token");
//     }
// };


// export const protectAuth = (req: Request, res: Response, next: NextFunction) => {
//     const authHeader = req.headers.authorization;
//     if (!authHeader?.startsWith("Bearer ")) {
//         return sendErrorResponse(res, 401, "Not authorized, no token")
//     }

//     const token = authHeader.split(" ")[1];

//     try {
//         const decoded = jwt.verify(
//             token,
//             process.env.ACCESS_TOKEN_SECRET as string
//         ) as { id: string };

//         req.user = decoded.id;
//         next();
//     } catch {
//         return sendErrorResponse(res, 401, "Not authorized, token failed")
//     }
// };


// export const authorizeRoles = (...roles: AdminRole[]) => {
//     return (req: AuthRequest, res: Response, next: NextFunction) => {
//         if (!req.admin) {
//             return res.status(401).json({ message: "Unauthorized" });
//         }

//         if (!roles.includes(req.admin.role)) {
//             return res.status(403).json({ message: "Forbidden" });
//         }

//         next();
//     };
// };
