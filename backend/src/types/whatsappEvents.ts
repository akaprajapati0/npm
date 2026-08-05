type WhatsappEventConfig = {
    templateId: string;
    variables: number;
    buttonVariables?: number;
    headerType?: "image" | "document";
};

export const WHATSAPP_EVENTS = {
    SEND_OTP: {
        templateId: process.env.SEND_OTP_TEMPLATE!,
        variables: 1,
        buttonVariables: 1, // optional URL button parameter
    },

    SEND_PASSWORD: {
        templateId: process.env.SEND_PASSWORD_TEMPLATE!,
        variables: 2,
    },

    USER_SIGNUP: {
        templateId: process.env.USER_SIGNUP_TEMPLATE!,
        headerType: "image",
        variables: 0,
    },

    DOCTOR_PROFILE_COMPLETED: {
        templateId: process.env.WELCOME_TEMPLATE!,
        variables: 1,
    },

    PRESCRIPTION_UPLOADED: {
        templateId: process.env.PRESCRIPTION_TEMPLATE!,
        variables: 0,
    },

    PRESCRIPTION_APPROVED: {
        templateId: process.env.PRESCRIPTION_APPROVED!,
        variables: 2,
    },

    PRESCRIPTION_REJECTED: {
        templateId: process.env.PRESCRIPTION_REJECTED!,
        variables: 0,
    },

    KYC_REQUIRED: {
        templateId: process.env.KYC_REQUIRED!,
        variables: 0,
    },

    // KYC
    KYC_UPLOADED: {
        templateId: process.env.KYC_TEMPLATE!,
        variables: 2, // {{1}} = link
    },

    KYC_APPROVED: {
        templateId: process.env.TEMPLATE_KYC_APPROVED!,
        variables: 0,
    },

    KYC_REJECTED: {
        templateId: process.env.TEMPLATE_KYC_REJECTED!,
        variables: 0,
    },

    CARETAKER_APPROVED: {
        templateId: process.env.CARETAKER_APPROVED!,
        variables: 0,
    },

    CARETAKER_REJECTED: {
        templateId: process.env.CARETAKER_REJECTED!,
        variables: 0,
    },

    // Quotation
    REQUEST_QUOTATION: {
        templateId: process.env.REQUEST_QUOTATION!,
        variables: 0,
    },

    ACCEPT_QUOTATION: {
        templateId: process.env.ACCEPT_QUOTATION!,
        variables: 0,
    },

    REVISION_QUOTATION: {
        templateId: process.env.REVISION_QUOTATION!,
        variables: 0,
    },

    READY_QUOTATION: {
        templateId: process.env.READY_QUOTATION!,
        variables: 1,
        headerType: "document",
    },

    // Proforma
    REQUEST_PROFORMA: {
        templateId: process.env.REQUEST_PROFORMA!,
        variables: 0,
    },

    ACCEPT_PROFORMA: {
        templateId: process.env.ACCEPT_PROFORMA!,
        variables: 0,
    },

    READY_PROFORMA: {
        templateId: process.env.READY_PROFORMA!,
        variables: 1,
        headerType: "document",
    },

    REVISION_PROFORMA: {
        templateId: process.env.REVISION_PROFORMA!,
        variables: 0,
    },

    // Import License
    REQUEST_IMPORT_PERMIT: {
        templateId: process.env.REQUEST_IMPORT_PERMIT!,
        variables: 0,
    },

    ACCEPT_IMPORT_PERMIT: {
        templateId: process.env.ACCEPT_IMPORT_PERMIT!,
        variables: 0,
    },

    REJECT_IMPORT_PERMIT: {
        templateId: process.env.REJECT_IMPORT_PERMIT!,
        variables: 0,
    },

    READY_IMPORT_PERMIT: {
        templateId: process.env.READY_IMPORT_PERMIT!,
        variables: 0,
        headerType: "document",
    },

    // Bank Transaction
    COMPLETE_INFORMATION: {
        templateId: process.env.COMPLETE_INFORMATION!,
        variables: 1,
    },

    TRANSACTION_RECEIVED: {
        templateId: process.env.TRANSACTION_RECEIVED!,
        variables: 1,
    },

    // CDEC
    CDEC_DOWNLOADED: {
        templateId: process.env.CDEC_DOWNLOADED!,
        variables: 0,
    },

    CDEC_UPLOADED: {
        templateId: process.env.CDEC_UPLOADED!,
        variables: 1,
    },

    CDEC_APPROVED: {
        templateId: process.env.CDEC_APPROVED!,
        variables: 0,
    },

    CDEC_REJECTED: {
        templateId: process.env.CDEC_REJECTED!,
        variables: 0,
    },

    DELIVERY_DETAILS_SHARED: {
        templateId: process.env.DELIVERY_DETAILS_SHARED!,
        variables: 0,
    },

    ALL_DOCUMENTS_UPLOADED: {
        templateId: process.env.ALL_DOCUMENTS_UPLOADED!,
        variables: 0,
    },

    // Admin document verification
    DOCUMENT_VERIFIED: {
        templateId: process.env.DOCUMENT_VERIFIED!,
        variables: 2,
    },

} as const satisfies Record<string, WhatsappEventConfig>;

export type WhatsappEventKey = keyof typeof WHATSAPP_EVENTS;
