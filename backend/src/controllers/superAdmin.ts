import "dotenv/config";
import { connecToDB } from '../config/db';
import Admin from '../models/admin.model';
import bcrypt from 'bcryptjs';
import { AdminRole } from '../types/adminTypes';

const seedSuperAdmin = async () => {
    try {
        await connecToDB();

        if (!process.env.SUPER_ADMIN_EMAIL || !process.env.SUPER_ADMIN_PASSWORD) {
            throw new Error("Missing env variables");
        }

        const exists = await Admin.findOne({ role: AdminRole.SUPER_ADMIN });

        if (exists) {
            console.log("Super admin already exists");
            process.exit(0);
        }

        const hashedPassword = await bcrypt.hash(
            process.env.SUPER_ADMIN_PASSWORD,
            10
        );

        await Admin.create({
            fullname: process.env.SUPER_ADMIN_FULLNAME || "Super Admin",
            email: process.env.SUPER_ADMIN_EMAIL,
            password: hashedPassword,
            role: AdminRole.SUPER_ADMIN,
        });

        process.exit(0);

    } catch (err) {
        console.error("Error:", err);
        process.exit(1);
    }
};

seedSuperAdmin();