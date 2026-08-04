import { Request, Response, NextFunction } from "express";

export const detectDevice = (req: Request, res: Response, next: NextFunction) => {
    const userAgent = req.headers["user-agent"] || "";

    let deviceType: "web" | "android" | "ios" | "tablet" | "unknown" = "unknown";

    if (/android/i.test(userAgent)) {
        deviceType = "android";
    } else if (/iphone|ipad|ipod/i.test(userAgent)) {
        deviceType = "ios";
    } else if (/tablet/i.test(userAgent)) {
        deviceType = "tablet";
    } else if (/windows|macintosh|linux/i.test(userAgent)) {
        deviceType = "web";
    }

    // attach to request object
    (req as any).deviceType = deviceType;

    next();
};
