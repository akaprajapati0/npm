import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { z } from "zod";
import { errorToast, successToast } from '@/utils/toast';
import adminApi from '@/lib/adminApi';
import api from '@/lib/axios';


export async function uploadDocuments(id: string, values: DocumentDetailsFormValues) {
    const formData = new FormData();
    formData.append("user", id);
    formData.append("proformaInvoice", values.proformaInvoice);
    formData.append("commercialInvoice", values.commercialInvoice);
    formData.append("importLicense", values.importLicense);
    formData.append("packingList", values.packingList);
    formData.append("gstBill", values.gstBill);
    formData.append("cdecForm", values.cdecForm);
    formData.append("deliveryReceipt", values.deliveryReceipt);

    try {
        const res = await adminApi.post("/documents/upload", formData);
        return res.data;
    } catch (err: any) {
        const message = err?.response?.data?.message ?? "Failed to upload documents.";
        throw new Error(message);
    }
}


const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

const fileField = (label: string) =>
    z.instanceof(File, { message: `${label} is required.` })
        .refine((file) => file.size <= MAX_FILE_SIZE, {
            message: `${label} must be 5MB or smaller.`,
        });

export const documentDetailsSchema = z.object({
    proformaInvoice: fileField("Proforma Invoice"),
    commercialInvoice: fileField("Commercial Invoice"),
    importLicense: fileField("Import License"),
    packingList: fileField("Packing List"),
    gstBill: fileField("GST Bill"),
    cdecForm: fileField("CDEC Form"),
    deliveryReceipt: fileField("Delivery Receipt"),
});

export type DocumentDetailsFormValues = z.infer<typeof documentDetailsSchema>;

// Drives the rendered list of 7 upload fields — add a row here to add a document type
export const DOCUMENT_FIELDS: { name: keyof DocumentDetailsFormValues; label: string }[] = [
    { name: "proformaInvoice", label: "Proforma Invoice" },
    { name: "commercialInvoice", label: "Commercial Invoice" },
    { name: "importLicense", label: "Import License" },
    { name: "packingList", label: "Packing List" },
    { name: "gstBill", label: "GST Bill" },
    { name: "cdecForm", label: "CDEC Form" },
    { name: "deliveryReceipt", label: "Delivery Receipt" },
];

export function useUploadDocuments(id: string) {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (values: DocumentDetailsFormValues) => uploadDocuments(id, values),
        onSuccess: () => {
            successToast("All documents uploaded successfully.");
            queryClient.invalidateQueries({ queryKey: ["documents", id] });
        },
        onError: (error: Error) => {
            errorToast(error.message);
        },
    });
}

export const useGetDocumentByUser = () => {
    return useQuery({
        queryKey: ["documents"],
        queryFn: async () => {
            const res = await api.get("/documents/user-document");
            return res?.data?.data || null;
        },
        staleTime: Infinity,
        refetchOnWindowFocus: false,
        refetchOnReconnect: false,
        retry: false,
    });
};