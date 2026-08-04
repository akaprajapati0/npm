import api from "@/lib/axios";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { RequestStep } from "@/types/quotationtypes";
import { RequestDocumentResponse, UploadPayload } from "@/types/adminSchema";
import { errorToast, successToast } from "@/utils/toast";
import axios from "axios";
import adminApi from "@/lib/adminApi";

export interface DocumentItem {
  _id: string;
  // add your fields here
  createdAt: string;
  updatedAt: string;
  rejectedAt?: string;
  reviseAt?: string;
  approvedAt?: string;
}

interface GetAllDocumentsResponse {
  documents: DocumentItem[];
}

interface DocRequestResponse {
  success: boolean;
  message?: string;
}

type UpdateStatusPayload = {
  id: string;
  type: "medicine_quotation" | "proforma_invoice" | "import_license";
  status: "Approved" | "Requested" | "Rejected" | "Revise_Request";
};

export const useGetdocs = (type: string) => {
  return useQuery({
    queryKey: ["document", type],
    queryFn: async () => {
      const resp = await api.get(`/request/docs/user/${type}`);
      return resp?.data?.data;
    },
    retry: false,
    staleTime: 1000 * 60 * 5, // 5 minutes - data considered fresh
    refetchOnMount: false,
    // refetchOnMount: true, // Refetch when component mounts
    // refetchOnWindowFocus: true, // Refetch when user returns to tab
    // refetchOnReconnect: true, // Refetch when network reconnects
    refetchInterval: 1000 * 30, // Refetch every 30 seconds in background
    // refetchIntervalInBackground: false, // Don't refetch when tab is inactive
  });
};

// export const useGetAllDocuments = () => {
//     return useQuery<GetAllDocumentsResponse>({
//         queryKey: ["documents"],

//         queryFn: async () => {
//             const res = await api.get("/request");
//             const json = res;

//             if (!res) {
//                 throw new Error(res || "Failed to fetch documents");
//             }

//             return {
//                 documents: json.data.documents,
//             };
//         },

//         // staleTime: 1000 * 60 * 5,
//         // refetchOnWindowFocus: false,
//     });
// };

export const useDocRequest = () => {
  const queryClient = useQueryClient();
  return useMutation<DocRequestResponse, any, RequestStep>({
    mutationFn: async (documentType) => {
      const { data } = await api.post(`/request/${documentType}`, {});

      if (!data?.success) {
        throw new Error(data?.message || "Request failed");
      }
      queryClient.invalidateQueries({ queryKey: ["document"] });
      queryClient.invalidateQueries({ queryKey: ["profile"] });

      return data;
    },
  });
};

export const useUpdateReviseStatus = (onSuccessCallback?: () => void) => {
  const queryClient = useQueryClient();

  return useMutation<any, Error, UpdateStatusPayload>({
    mutationFn: async ({ id, type, status }) => {
      const { data } = await api.put(`/request/revise/${id}/${type}`, {
        status,
      });

      return data;
    },

    onSuccess: (data) => {
      successToast(data?.message || "Status updated successfully");

      // Refresh UI
      queryClient.invalidateQueries({ queryKey: ["document"] });

      onSuccessCallback?.();
    },

    onError: (error) => {
      let message = "Failed to update status";

      if (axios.isAxiosError(error)) {
        message = error.response?.data?.message || message;
      } else if (error instanceof Error) {
        message = error.message;
      }

      errorToast(message);
    },
  });
};

// requested document hooks for admin use

interface UpdateDocumentPayload {
  id: string;
  type: string;
  status: "Approved" | "Rejected" | "Requested" | "Pending" | "Revise_Request";
  files?: File[];
  remarks?: string;
}

export const useUpdateDocumentStatus = (onSuccessCallback?: () => void) => {
  const queryClient = useQueryClient();

  return useMutation<any, Error, UpdateDocumentPayload>({
    mutationFn: async ({ id, type, status, files, remarks }) => {
      if (status === "Approved" && (!files || files.length === 0)) {
        throw new Error("Files are required to approve this document");
      }

      const formData = new FormData();

      formData.append("status", status);
      formData.append("remarks", remarks || "");

      files?.forEach((file) => {
        // field name must match the backend's upload.array("documents", 5)
        formData.append("images", file);
      });

      // Don't set Content-Type manually — the browser generates the
      // multipart boundary automatically for FormData bodies.
      const { data } = await adminApi.put(
        `/request/update/${id}/${type}`,
        formData,
      );

      return data;
    },

    onSuccess: (data) => {
      successToast(data?.message || "Document updated successfully");

      queryClient.invalidateQueries({ queryKey: ["document"] });

      onSuccessCallback?.();
    },

    onError: (error) => {
      let message = "Failed to update document";

      if (axios.isAxiosError(error)) {
        message = error.response?.data?.message || message;
      } else if (error instanceof Error) {
        message = error.message;
      }

      errorToast(message);
    },
  });
};

// export const useUpdateDocumentStatus = (
//     onSuccessCallback?: () => void
// ) => {
//     const queryClient = useQueryClient();

//     return useMutation<any, Error, UpdateStatusPayload>({
//         mutationFn: async ({ id, type, status, path }) => {
//             const { data } = await adminApi.put(
//                 `/request/${path}/${id}/${type}`,
//                 { status }
//             );

//             return data;
//         },

//         onSuccess: (data) => {
//             successToast(data?.message || "Status updated successfully");

//             // Refresh UI
//             queryClient.invalidateQueries({ queryKey: ["document"] });

//             onSuccessCallback?.();
//         },

//         onError: (error) => {
//             let message = "Failed to update status";

//             if (axios.isAxiosError(error)) {
//                 message = error.response?.data?.message || message;
//             } else if (error instanceof Error) {
//                 message = error.message;
//             }

//             errorToast(message);
//         },
//     });
// };

export const useGetDocument = (id: string) => {
  return useQuery<RequestDocumentResponse>({
    queryKey: ["document"],
    queryFn: async () => {
      const res = await adminApi.get(`/request/docs/${id}`);
      return res.data;
    },
    staleTime: 1000 * 60 * 5, // 5 minutes - data considered fresh
    refetchOnMount: true, // Refetch when component mounts
    refetchOnWindowFocus: true, // Refetch when user returns to tab
    refetchOnReconnect: true, // Refetch when network reconnects
    // refetchInterval: 1000 * 30, // Refetch every 30 seconds in background
    refetchIntervalInBackground: false, // Don't refetch when tab is inactive
  });
};

// upload file
// export const useUploadDocument = (onSuccessCallback?: () => void) => {
//     const queryClient = useQueryClient();

//     return useMutation<any, Error, UploadPayload>({
//         mutationFn: async ({ id, type, files }) => {
//             const formData = new FormData();

//             files.forEach((file) => {
//                 formData.append("images", file);
//             });

//             const { data } = await adminApi.put(
//                 `/request/docs/${id}/${type}`,
//                 formData,
//                 {
//                     headers: {
//                         "Content-Type": "multipart/form-data",
//                     },
//                 }
//             );

//             return data;
//         },

//         onSuccess: (data) => {
//             successToast(data?.message || "Documents uploaded successfully");

//             // Invalidate relevant queries
//             queryClient.invalidateQueries({ queryKey: ["document"] });
//             // queryClient.invalidateQueries({ queryKey: ["document-details"] });

//             onSuccessCallback?.();
//         },

//         onError: (error) => {
//             let message = "Upload failed";

//             if (axios.isAxiosError(error)) {
//                 message = error.response?.data?.message || message;
//             } else if (error instanceof Error) {
//                 message = error.message;
//             }

//             errorToast(message);
//         },
//     });
// };

// export const useDocumentCount = () => {
//     return useQuery<{ count: number }>({
//         queryKey: ["document-count"],
//         queryFn: async () => {
//             const res = await api.get("/request/count");
//             return res.data.data;
//         },
//         staleTime: 1000 * 60, // 1 minute
//         refetchOnWindowFocus: true,
//         refetchOnReconnect: true,
//     });
// }

// export const useDocRequest = (onSuccessCallback?: () => void) => {
//     return useMutation({
//         mutationFn: async (documentType: string) => {

//             const response = await api.post(`/request/${documentType.toLowerCase()}`, {
//                 headers: {
//                     "Content-Type": "multipart/form-data",
//                 },
//             });

//             return response.data;
//         },

//         onSuccess: (res) => {
//             if (!res?.success) {
//                 return errorToast(res?.message || "Upload failed");
//             }

//             successToast(res.message || "Your request submitted");

//             onSuccessCallback?.();
//         },

//         onError: (err: any) => {
//             const message =
//                 err?.response?.data?.message ||
//                 err?.message ||
//                 "Internal Server Error";

//             errorToast(message);
//         },
//     });
// };
