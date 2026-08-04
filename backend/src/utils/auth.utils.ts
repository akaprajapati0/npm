import crypto from "crypto";
import bcrypt from "bcryptjs";

export const generateOTP = (): string =>
    Math.floor(100000 + Math.random() * 900000).toString();

export const generatePassword = (): string =>
    crypto.randomBytes(8).toString("hex"); // strong 16-char password


export const hashOTP = async (otp: string) => {
    const salt = await bcrypt.genSalt(10);
    return bcrypt.hash(otp, salt);
};

export const compareOTP = async (otp: string, hash: string) => {
    return bcrypt.compare(otp, hash);
};
