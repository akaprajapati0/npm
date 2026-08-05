import crypto from "crypto";
import bcrypt from "bcryptjs";

export const generateOTP = (): string =>
    Math.floor(100000 + Math.random() * 900000).toString();

export const generatePassword = (): string =>
    crypto.randomBytes(8).toString("hex"); // strong 16-char password

export const generatePatientPassword = (
    patientName: string,
    dateOfBirth: string | Date
): string => {
    const namePart = patientName
        .replace(/[^a-zA-Z]/g, "")
        .slice(0, 4)
        .toLowerCase()
        .padEnd(4, "x");

    const dob = new Date(dateOfBirth);
    if (Number.isNaN(dob.getTime())) {
        throw new Error("Invalid patient date of birth");
    }

    const day = String(dob.getUTCDate()).padStart(2, "0");
    const month = String(dob.getUTCMonth() + 1).padStart(2, "0");
    const year = String(dob.getUTCFullYear()).slice(-2);

    return `${namePart}@${day}${month}${year}`;
};


export const hashOTP = async (otp: string) => {
    const salt = await bcrypt.genSalt(10);
    return bcrypt.hash(otp, salt);
};

export const compareOTP = async (otp: string, hash: string) => {
    return bcrypt.compare(otp, hash);
};
