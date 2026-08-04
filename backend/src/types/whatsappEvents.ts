type WhatsappEventConfig = {
    templateId: string;
    variables: number;
    buttonVariables?: number;
    headerType?: "image";
};

export const WHATSAPP_EVENTS: Record<string, WhatsappEventConfig> = {
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
        variables: 1, // {{1}} = reason
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
    },

    // Import License
    REQUEST_IMPORT_PERMIT: {
        templateId: process.env.REQUEST_IMPORT_PERMIT!,
        variables: 0,
    },

    ACCEPT_IMPORT_PERMIT: {
        templateId: process.env.ACCEPT_IMPORT_PERMIT!,
        variables: 1,
    },

    REJECT_IMPORT_PERMIT: {
        templateId: process.env.REJECT_IMPORT_PERMIT!,
        variables: 1,
    },

    READY_IMPORT_PERMIT: {
        templateId: process.env.READY_IMPORT_PERMIT!,
        variables: 1,
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

    // Admin document verification
    DOCUMENT_VERIFIED: {
        templateId: process.env.DOCUMENT_VERIFIED!,
        variables: 2,
    },

} as const;

export type WhatsappEventKey = keyof typeof WHATSAPP_EVENTS;