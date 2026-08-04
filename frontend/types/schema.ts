import { z } from "zod";
// import { parsePhoneNumberFromString } from "libphonenumber-js";

export interface ReactQueryResponse {
    success: boolean;
    message: string;
    data?: unknown | any;
}

// type of  pages
export const SignUpSchema = z
    .object({
        country: z.string(),

        phone: z.string().optional(),

        email: z.string().optional(),

        otp: z
            .string()
            .min(6, "OTP is required"),
    })

    .superRefine((data, ctx) => {
        // ---------- INDIA ----------
        if (data.country === "IN") {
            if (!data.phone?.trim()) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    path: ["phone"],
                    message:
                        "Phone number is required",
                });

                return;
            }

            if (
                !/^[6-9]\d{9}$/.test(
                    data.phone
                )
            ) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    path: ["phone"],
                    message:
                        "Enter valid Indian phone number",
                });
            }
        }

        // ---------- OTHER COUNTRY ----------
        else {
            if (!data.email?.trim()) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    path: ["email"],
                    message:
                        "Email is required",
                });

                return;
            }

            if (
                !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
                    data.email
                )
            ) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    path: ["email"],
                    message:
                        "Enter valid email",
                });
            }
        }
    });

export type SignUpValues = z.infer<typeof SignUpSchema>;


export const LoginSchema = z.object({
    identifier: z.string().min(1, "Email or phone is required"),
    password: z.string().min(1, "Password is required"),
});

export type LoginValues = z.infer<typeof LoginSchema>;

export type CaretakerResult = {
    id?: string;
    email?: string;
    phone: string;
}

export const RegisterSchema = z.object({
    fullname: z
        .string()
        .trim()
        .min(1, "Caretaker full name is required"),
    email: z
        .email("Invalid email address")
        .or(z.literal("")),
    // phone: z
    //     .string()
    //     .refine((value) => {
    //         // const phone = parsePhoneNumberFromString(value);
    //         // return phone?.isValid();
    //     }, "Type only number"),
    phone: z.string().optional(),

    relationship: z.string().min(1, "Relationship required"),
    relationshipOther: z.string(),
    country: z.string().min(1, "Country required"),
    city: z.string().min(1, "City required"),
    pincode: z.string().min(1, "Pincode required"),

    patient: z.object({
        fullname: z.string().min(1, "Patient name is required"),
        dateOfBirth: z.string().min(1, "Date of birth is required"),
        gender: z.string().min(1, "Gender required"),
        patientId: z.string().optional()
    }),
    otp: z.string().optional(),
});

export type RegisterFormValues = z.infer<typeof RegisterSchema>;



export const PrescribedMedicineSchema = z.object({
    medicineName: z.string().min(1, "Medicine name is required"),
    strength: z.string().min(1, "Strength is required"),
    dosage: z.string().min(1, "Dosage is required"),
    ActiveIngredients: z.string().min(1, "Active ingredients are required"),
    quantity: z.string().min(1, "Quantity is required"),
    packSize: z.string().min(1, "Pack size is required"),
    storageConditions: z.string().optional(),
    manufacturer: z.string().optional(),
});


export type PrescribedFormValues = z.infer<typeof PrescribedMedicineSchema>;

export const DoctorDetailsSchema = z.object({
    fullname: z.string().min(1, "Doctor full name is required"),
    specialization: z.string(),
    clinicName: z.string().min(1, "Hospital or Clinic name is required"),
    // address: z.string().min(1, "Country name is required"),
    country: z.string(),
    city: z.string(),
    doctorRegistrationNumber: z.string().optional(),
    email: z.email("Required valid email address").optional().or(z.literal("")),
});

export type DoctorDetailsFormValues = z.infer<typeof DoctorDetailsSchema>;

export const PrescriptionSchema = z.object({
    prescriptionImage: z
        .instanceof(File, { message: "Image file is required" })
        .refine((file) => file.size > 0, "Image is required"),
});

export type PrescriptionFormValues = z.infer<typeof PrescriptionSchema>;



// export const AddressSchema = z.object({
//     name: z.string().trim().optional(),

//     phone: z
//         .string()
//         .regex(/^\+\d{10,15}$/, "Invalid phone number"),

//     houseName: z.string().trim().min(1),
//     roadName: z.string().trim().min(1),
//     city: z.string().trim().min(1),
//     state: z.string().trim().min(1),
//     country: z.string().trim().min(1),

//     pincode: z.string().trim().min(4).max(10),

//     landmark: z.string().trim().optional(),

//     checkMark: z.boolean()
//         .refine((val) => val === true, {
//             message: "You must check this box to continue",
//         })
//         .default(false),

//     isDefault: z.boolean().optional(),
// });

// export type AddressFormValues = z.infer<typeof AddressSchema>;


export const AddressSchema = z.object({
    name: z.string().trim().optional(),

    phone: z
        .string()
        .regex(/^[6-9]\d{9}$/, "Enter a valid 10-digit Indian mobile number"),

    houseName: z.string().trim().min(1, "House name/number is required"),

    roadName: z.string().trim().min(1, "Road name is required"),

    city: z.string().trim().min(1, "City is required"),

    state: z.string().trim().min(1, "State is required"),

    country: z.string().trim().min(1, "Country is required"),

    pincode: z.string().trim().min(4, "Invalid pincode"),

    landmark: z.string().trim().optional(),

    checkMark: z.boolean().refine(val => val === true, {
        message: "Please confirm this is your delivery address",
    }),
    isDefault: z.boolean().optional(),
});


export type AddressFormValues = z.infer<typeof AddressSchema>;



// types of use hooks (react query)

export type ApiErrorResponse = {
    message: string;
};

export type SendOtpPayload = {
    phone?: string;
    email?: string;
};

export type SignUpPayload = {
    country: string,
    email?: string;
    phone?: string;
    otp: string;
}

export type LoginPayload = {
    email?: string;
    phone?: string;
    password: string;
    identifier?: string
};

// export interface ProgressObject {
//     caretakerUploaded: boolean;
//     prescribedUploaded: boolean;
//     doctorUploaded: boolean;
//     prescriptionUploaded: boolean;
//     kycUploaded: boolean;
//     requestDocumentUploaded: boolean;
//     bankReceiptUploaded: boolean;
//     cdecUploaded: boolean;
//     addressAdded: boolean;
// }

interface User {
    id: string;
    email: string;
    phone?: string;
    name?: string;
    progress: string;
    role: "user" | "ADMIN" | null;
};

export type MedicineResult = {
    medicineName: string;
    ActiveIngredients: string;
    strength: string;
    dosage: string;
    packSize: string;
    quantity: string;
    storageConditions: string;
    manufacturer: string;
};

export interface AuthResponse {
    success: boolean;
    accessToken?: string;
    user?: User;
    data?: {
        accessToken?: string;
        user?: User;
        success?: boolean;
    };
    message?: string;
};


export const KYCSubmissionSchema = z
    .object({
        documentType: z.enum(["aadhaar", "passport"]),
        documentNumber: z.string().min(1, "Document number is required"),
        files: z
            .array(z.instanceof(File))
            .length(2, "Front and back images are required"),
    })
    .superRefine((data, ctx) => {
        if (data.documentType === "aadhaar") {
            if (!/^\d{12}$/.test(data.documentNumber)) {
                ctx.addIssue({
                    code: "custom",
                    path: ["documentNumber"],
                    message: "Aadhaar number must be exactly 12 digits",
                });
            }
        }

        if (data.documentType === "passport") {
            if (!/^[A-Za-z0-9]{6,8}$/.test(data.documentNumber)) {
                ctx.addIssue({
                    code: "custom",
                    path: ["documentNumber"],
                    message: "Passport number must be 6–8 alphanumeric characters",
                });
            }
        }
    });

export type KYCSubmission = z.infer<typeof KYCSubmissionSchema>;
// In your schema file
// export const BankReceiptSchema = z.object({
//     documentNumber: z
//         .string()
//         .min(14, "AD Code must be exactly 14 characters")
//         .max(14, "AD Code must be exactly 14 characters"),
//     files: z
//         .array(z.any())
//         .min(1, "Please upload at least one transaction proof"),
// });

export const BankReceiptSchema = z.object({
    documentNumber: z
        .string().optional(),

    files: z
        .array(z.instanceof(File))
        .min(1, "Please upload at least one document"),
});

export type BankRecieptSubmission = z.infer<typeof BankReceiptSchema>;

// Current Delivery Address
// export const CurrentDeliverySchema = z.object({
//     address: z.string().min(1, "Address is required"),
//     city: z.string().min(1, "City is required"),
//     state: z.string().min(1, "State is required"),
//     pinCode: z.string().regex(/^\d{6}$/, "Enter valid pincode"),
//     country: z.string().min(1, "Country is required"),

//     phone: z
//         .string()
//         .refine((value) => {
//             // const phone = parsePhoneNumberFromString(value);
//             // return phone?.isValid();
//         }, "Enter a valid phone number with country code"),
//     declaration: z
//         .boolean()
//         .refine((val) => val === true, {
//             message: "You must confirm this is your current delivery address",
//         }),
// });

// export type CountryAddressValues = z.infer<typeof CurrentDeliverySchema>


export const UpdatePasswordSchema = z.object({
    identifier: z.string().min(1, "Email or phone is required"),
    // oldPassword: z.string().min(1, "Old password is required"),
    newPassword: z.string().min(8, "New password must be at least 8 characters"),
    confirmPassword: z.string()
}).refine((data) => data.newPassword === data.confirmPassword, {
    message: "Passwords do not match",
    path: ["confirmPassword"],
});

export type UpdatePasswordValues = z.infer<typeof UpdatePasswordSchema>;

// Types of components
export interface ReusableFormProps {
    heading: string;
    subHeading?: string;
    form: any;
    onSubmit: (values: any) => void;
    children: React.ReactNode;
    onSkip?: () => void;
};

// Define a clear route map to replace the switch statement
// export interface ProgressObject {
//     caretakerUploaded: boolean;
//     prescribedUploaded: boolean;
//     doctorUploaded: boolean;
//     prescriptionUploaded: boolean;
//     kycUploaded: boolean;
//     requestDocumentUploaded: boolean;
//     bankReceiptUploaded: boolean;
//     cdecUploaded: boolean;
//     addressAdded: boolean;
// }

export const PROGRESS_ROUTES: Record<string, string> = {
    none: "/caretaker/register",
    caretaker_uploaded: "/caretaker/prescribed-medicine",
    prescribed_uploaded: "/caretaker/doctor-details",
    doctor_uploaded: "/caretaker/upload-document",
    prescription_uploaded: "/caretaker/kyc",
    kyc_uploaded: "/caretaker/request-docs",
    request_quotation: "/caretaker/request-docs/medicine-quotation ",
    request_invoice: "/caretaker/request-docs/proforma-invoice",
    request_license: "/caretaker/request-docs/import-license",
    bank_receipt_uploaded: "/caretaker/cdec",
    cdec_uploaded: "/caretaker/address",
    completed: "/home",
};