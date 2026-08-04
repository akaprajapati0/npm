import cron from "node-cron";

import User from "../models/user.model";
import patientModel from '../models/patient.model';
import caretakerModel from '../models/caretaker.model';
import prescribedMedicineModel from '../models/prescribedMedicine.model';
import doctorDetailsModel from '../models/doctorDetails.model';
import prescriptionModel from '../models/prescription.model';
import kycModel from '../models/kyc.model';
import bankReceiptModel from '../models/bankReceipt.model';
import cdecModel from '../models/cdec.model';
import { ImportLicenseRequest, MedicineQuotationRequest, ProformaInvoiceRequest } from 'models/docsRequest.model';


// Delete User Related Data

const permanentlyDeleteUserData = async (
    userId: string
) => {
    try {
        // Delete related collections

        await Promise.all([
            patientModel.deleteMany({
                user: userId,
            }),

            caretakerModel.deleteMany({
                user: userId,
            }),

            prescribedMedicineModel.deleteMany({
                user: userId,
            }),

            doctorDetailsModel.deleteMany({
                user: userId,
            }),

            prescriptionModel.deleteMany({
                user: userId,
            }),

            kycModel.deleteMany({
                user: userId,
            }),

            MedicineQuotationRequest.deleteMany({
                user: userId,
            }),

            ProformaInvoiceRequest.deleteMany({
                user: userId,
            }),

            ImportLicenseRequest.deleteMany({
                user: userId,
            }),

            bankReceiptModel.deleteMany({
                user: userId,
            }),

            cdecModel.deleteMany({
                user: userId,
            }),
        ]);

        // Delete user

        await User.findByIdAndDelete(
            userId
        );

        console.log(
            `User ${userId} permanently deleted`
        );
    } catch (error) {
        console.error(
            `Failed deleting user ${userId}:`,
            error
        );
    }
};

// Cron Job
export const startAccountCleanupJob = () => {
    cron.schedule(
        "0 0 * * *",
        async () => {
            try {
                console.log(
                    "Running account cleanup job..."
                );

                const usersToDelete =
                    await User.find({
                        isDeactivated:
                            true,

                        scheduledDeletionAt:
                        {
                            $lte: new Date(),
                        },
                    });

                for (const user of usersToDelete) {
                    await permanentlyDeleteUserData(
                        user._id.toString()
                    );
                }

                console.log(
                    `Processed ${usersToDelete.length} users`
                );
            } catch (error) {
                console.error(
                    "Cleanup job failed:",
                    error
                );
            }
        }
    );
};
