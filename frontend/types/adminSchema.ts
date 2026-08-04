import { z } from "zod";

export type AdminRole = "ADMIN" | "TEMP_ADMIN";

export const AdminLoginSchema = z.object({
  email: z.string().min(1, "Email is required"),
  password: z.string().min(1, "Password is required"),
});

export const AdminRegisterSchema = z.object({
  fullname: z.string().min(1, "Full name is required"),
  email: z.email("Invalid email address"),
  password: z.string().min(6),
  role: z.enum(["ADMIN", "TEMP_ADMIN"]),
  expiresAt: z.date().optional(),
});


export type AdminLoginValues = z.infer<typeof AdminLoginSchema>;
export type AdminRegisterFormValues = z.infer<typeof AdminRegisterSchema>;

export type AdminRegisterPayload = {
  fullname: string;
  email: string;
  password: string;
  role: "ADMIN" | "TEMP_ADMIN";
  expiresAt?: string;
};


export interface Admin {
  _id: string;
  fullname: string;
  email: string;
  role?: "SUPER_ADMIN" | "ADMIN" | "TEMP_ADMIN";
  expiresAt?: string
}

export interface AdminRow {
  _id: string;
  fullname: string;
  email: string;
  role?: string;
  expiresAt?: string
}

export interface AuthResponse {
  success: boolean;
  message?: string;
  data: {
    accessToken: string;
    id: string;
    email: string;
    admin: Admin;
  };
}

export interface GetAllAdminsResponse {
  success: boolean;
  message: string;
  data: {
    admins: Admin[];
    stats: {
      totalAdmins: number;
      totalUsers: number;
      activeAdmins: number;
      totalPermanentAdmins: number;
      inActiveAdmins: number;
      totalTempAdmins: number;
      expiringSoon: number;
      lastWeekUsers: number;
    };
  };
}

export interface UpdateAdminPayload {
  id: string;
  fullname?: string;
  email?: string;
  password?: string;
  role?: "ADMIN" | "TEMP_ADMIN";
  expiresAt?: Date;
  isActive?: boolean;
}


export interface Column<T> {
  key: keyof T;
  header: string;
  cell?: (row: T) => React.ReactNode;
}


export interface ReusableDataTableProps<T> {
  heading: string;
  subHeading?: string;
  columns: Column<T>[];
  data: T[];
  loading?: boolean;
  children?: (row: T) => React.ReactNode;
}


export type CaretakerRow = {
  _id: string;
  fullname: string;
  email: string;
  phone: string;
  relationship: string;
  city: string;
  patients: string[];
  orders: string[];
  progress: string;
  role: string;
  createdAt: string;
  updatedAt: string;
};

export type PatientRow = {
  _id: string;
  caretaker?: string;
  fullname?: string;
  dateOfBirth: string;
  gender: string;
  createdAt: string;
  updatedAt: string;
};

export interface PrescribedMedicine {
  _id: string;
  medicineName: string;
  strength: string;
  dosage: string;
  ActiveIngredients: string;
  manufacturer: string;
  quantity: number;
  packSize: string;
  storageConditions: string;
}


export type DoctorDetailsRow = {
  _id: string;
  fullname: string;
  specialization: string;
  clinicName: string;
  address: string[];
  doctorRegistrationNumber: string;
  email: string;
  createdAt: string;
  updatedAt: string;
};

export type PrescriptionRow = {
  _id: string;
  patient: string;
  document: {
    url: string;
    mimeType: string;
    size: number;
  };
  status: "pending" | "approved" | "rejected";
  createdAt: string;
  updatedAt: string;
};


export type KycRow = {
  _id: string;
  patient: string;
  documentType: string;
  documentNumber: string;
  documents: {
    fieldName: string;
    fileName: string;
    fileType: string;
    filePath: string;
    size: number;
  }[];
  status: "pending" | "approved" | "rejected";
  createdAt: string;
  updatedAt: string;
};

export type BankRecieptRow = {
  _id: string;
  patient: string;
  document: {
    url: string;
    mimeType: string;
    size: number;
  };
  status: "pending" | "approved" | "rejected";
  createdAt: string;
  updatedAt: string;
};


export type CdecRow = {
  _id: string;
  patient: string;
  document: {
    url: string;
    mimeType: string;
    size: number;
  };
  status: "pending" | "approved" | "rejected";
  createdAt: string;
  updatedAt: string;
};

// type DocumentStatus = "Pending" | "Requested" | "Approved" | "Rejected";

// type DocItem = {
//   status: DocumentStatus;
//   requestedAt?: string;
//   approvedAt?: string;
//   rejectedAt?: string;
//   documents?: {
//     url: string;
//     mimeType?: string;
//     size?: number;
//   }[];
// };

interface RequestDocumentData {
  _id: string;
  importLicense: any;
  medicineQuotation: any;
  proformaInvoice: any;
  // add more fields if needed
}

export interface RequestDocumentResponse {
  success: boolean;
  message: string;
  data: RequestDocumentData; // ✅ THIS WAS MISSING
}

export type UploadPayload = {
  id?: string;
  type?: "quotation" | "invoice" | "license";
  files: File[];
};

// export type RequestDocumentResponse = {
//   _id: string;
//   user: string;
//   createdAt: string;
//   updatedAt: string;
//   remarks: string[];

//   importLicense: DocItem;
//   medicineQuotation: DocItem;
//   proformaInvoice: DocItem;
// };

export const isImage = (url: string) =>
  /\.(jpg|jpeg|png|webp|gif)$/i.test(url);

export const isPdf = (url: string) =>
  /\.pdf$/i.test(url);

// payment related types
export const PaymentSchema = z.object({
  user: z.string(),
  paymentReceived: z.string(),
  paymentLeft: z.string(),
  accountNumber: z.string(),
  ifsc: z.string(),
  branch: z.string(),
});

export type PaymentFormValues = z.infer<typeof PaymentSchema>;
