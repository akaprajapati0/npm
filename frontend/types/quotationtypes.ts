export type RequestStep = "medicine_quotation" | "proforma_invoice" | "import_license";

export const STEP_ORDER: RequestStep[] = ["medicine_quotation", "proforma_invoice", "import_license"];

export const POPUP_CONTENT: Record<RequestStep, { title: string; description: string }> = {
    medicine_quotation: {
        title: "Request Submitted",
        description: "Thank you for requesting your quotation. Our team will review and get back to you as soon as possible.",
    },
    proforma_invoice: {
        title: "Request Received ",
        description: "Your request has been received. The proforma invoice is being processed and will be shared within 24–48 hours.",
    },
    import_license: {
        title: "Import Permit Requested",
        description: "Your request has been submitted for processing. We’ll keep you updated on the approval status. This typically takes 24–72 hour",
    },
};

export interface Document {
    url: string;
    createdAt: string | Date;
}