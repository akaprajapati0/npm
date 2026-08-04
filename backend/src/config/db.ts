import "dotenv/config";
import mongoose from "mongoose";

export const connecToDB = async (): Promise<void> => {
    const MONGO_URI = process.env.MONGO_URI;
    if (!MONGO_URI) {
        console.error("MONGO_URI is not defined in environment variables");
        process.exit(1);
    }

    try {
        const conn = await mongoose.connect(MONGO_URI, {
            autoIndex: false,
            serverSelectionTimeoutMS: 5000,
        });

        console.log(`MongoDB Connected: ${conn.connection.host}`);

        mongoose.connection.on("disconnected", () => {
            console.warn("MongoDB disconnected");
        });

        mongoose.connection.on("reconnected", () => {
            console.log("MongoDB reconnected");
        });
    } catch (error) {
        console.error("MongoDB connection failed:", error);
        process.exit(1);
    }
};

// Graceful shutdown
process.once("SIGINT", async () => {
    await mongoose.connection.close();
    console.log("MongoDB connection closed due to app termination");
    process.exit(0);
});
