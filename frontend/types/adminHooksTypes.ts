export interface ImageSchema {
    url: { type: String, required: true },
    mimeType: { type: String, required: false },
    size: { type: Number, required: false },
}

export interface UserRow {
    _id: string;
    image?: ImageSchema[];
    email: string;
    phone: string;
    authProvider?: string;
    progress: string;
    isDeactivated: boolean;
}

export interface CaretakerRow {
    _id: string;
    fullname: string;
    email: string;
    phone: string;
    relationship: string;
    country: string;
    city: string;
    pincode: string;
    status: string;
}

export interface AddressRow {
    _id: string;
    street: string;
    city: string;
    state: string;
    pincode: string;
}

export interface BankReceiptRow {
    _id: string;
    documentNumber?: string;
    documents?: ImageSchema[];
    status: string;
    createdAt?: string;
}


export interface CDECRow {
    _id: string;
    documents: ImageSchema[];
    status: string;
}

type DocumentBlock = {
    requestedAt: string;
    status: string;
    documents?: any[];
};

export interface RequestDocumentRow {
    _id: string;
    _v?: number;
    user?: string;
    documents?: ImageSchema[]
    status?: string;
    updatedAt?: string;
    createdAt?: string;
}

export interface DoctorDetailsRow {
    _id: string;
    fullname: string;
    specialization: string;
    clinicName: string;
    country: string;
    city: string;
    doctorRegistrationNumber: string;
    email: string;
    status: string;
}

export interface KYCRow {
    _id: string;
    documentType: string;
    documentNumber: string;
    documents: ImageSchema[];
    status: string;
    rejectionReason?: string;
}

export interface OrderRow {
    _id: string;
    total: number;
    status: string;
    createdAt: string;
}

export interface PatientRow {
    _id: string;
    fullname: string;
    dateOfBirth: number;
    gender: string;
}

export interface PrescribedMedicineRow {
    _id: string;
    medicineName: string;
    ActiveIngredients: string;
    strength: string,
    dosage: string,
    packSize: string,
    quantity: string,
    storageConditions: string,
    manufacturer: string,
    status: string,
}

export interface PrescriptionRow {
    _id: string;
    documents: ImageSchema[];
    status: string;
    createdAt: string;
}

// types/payment.ts (or wherever your shared types live)
export interface Payment {
    _id: string;
    user: string;
    branch: string;
    ifsc: string;
    accountNumber: string;
    paymentReceived: string | number;
    paymentLeft: string | number;
    createdAt: string;
    updatedAt: string;
    _v?: number
}


export interface CreateOrderPayload {
    userId: string;
    invoiceAmount: number;
    payments?: { amount: number; receivedOn?: string }[];
}

export interface OrderPayment {
    _id: string;
    amount: number;
    receivedOn: string;
}

export interface Order {
    _id: string;
    user: string;
    invoiceAmount: number;
    payments: OrderPayment[];
    totalReceived: number;
    balanceAmount: number;
    createdAt: string;
    updatedAt: string;
}

// types/userData.types.ts

export interface UserAllData {
    caretakers: CaretakerRow[];
    addresses: AddressRow[];
    bankReceipts: BankReceiptRow[];
    cdecs: CDECRow[];
    // requestDocuments: RequestDocumentRow[];
    medicineQuotation: RequestDocumentRow[];
    proformaInvoice: RequestDocumentRow[];
    importLicense: RequestDocumentRow[];
    doctorDetails: DoctorDetailsRow[];
    kycs: KYCRow[];
    orders: OrderRow[];
    patients: PatientRow[];
    prescribedMedicines: PrescribedMedicineRow[];
    prescriptions: PrescriptionRow[];
}