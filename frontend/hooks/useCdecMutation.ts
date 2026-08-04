import adminApi from '@/lib/adminApi';
import api from "@/lib/axios";
import { CdecRow, UploadPayload } from '@/types/adminSchema';
import { ReactQueryResponse } from "@/types/schema";
import { errorToast, successToast } from "@/utils/toast";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import axios from 'axios';


type CdecResponse = {
  data: CdecRow[];
};
type UpdateCdecStatusPayload = {
  id: string;
  status: string;
};


export const useUploadCdec = (
  onSuccessCallback?: () => void
) => {
  return useMutation<ReactQueryResponse, unknown, File[]>({
    mutationFn: async (files) => {
      if (!files.length) {
        errorToast("No files selected");
      }

      const formData = new FormData();

      files.forEach((file) => {
        formData.append("images", file);
      });

      const { data } = await api.post<ReactQueryResponse>(
        "/cdec/upload",
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );

      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message || "CDEC upload failed");
        return;
      }

      successToast(res.message || "CDEC uploaded successfully");
      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "Upload failed! Please try again.";

      errorToast(msg);
    },
  });
};


export const useCdec = () => {
  return useQuery<CdecRow[]>({
    queryKey: ["cdec"],

    queryFn: async () => {
      const res = await api.get("/cdec/admin");

      const json: CdecResponse = await res;

      if (!res) {
        errorToast(
          (json as any)?.message || "Failed to fetch Bank Reciept"
        );
        return [];
      }

      return json?.data ?? [];
    },
  });
};

// for admin use

export const useUpdateCdecStatus = (
  onSuccessCallback?: () => void
) => {
  const queryClient = useQueryClient();

  return useMutation<
    ReactQueryResponse,
    any,
    UpdateCdecStatusPayload
  >({
    mutationFn: async ({ id, status }) => {
      const { data } = await adminApi.put<ReactQueryResponse>(
        `/cdec/status/${id}`,
        { status }
      );

      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message || "Failed to update CDEC status");
        return;
      }

      successToast(res.message || "CDEC status updated successfully");

      queryClient.invalidateQueries({
        queryKey: ["cdec"],
      });

      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "CDEC status update failed! Please try again.";

      errorToast(msg);
    },
  });
};

// admin will be upload downloadable CDEC form
// export const useUploadAdminDocument = (onSuccessCallback?: () => void) => {
//   const queryClient = useQueryClient();

//   return useMutation<any, Error, UploadPayload>({
//     mutationFn: async ({ files, id }: UploadPayload) => {
//       if (!files.length) {
//         errorToast("No files selected");
//       }

//       const formData = new FormData();

//       files.forEach((file) => {
//         formData.append("images", file);
//       });

//       const { data } = await api.post(
//         `/cdec/admin/upload/${id}`,
//         formData,
//         {
//           headers: {
//             "Content-Type": "multipart/form-data",
//           },
//         }
//       );

//       return data;
//     },

//     onSuccess: (data) => {
//       successToast(data?.message || "Documents uploaded successfully");

//       // Invalidate relevant queries
//       queryClient.invalidateQueries({ queryKey: ["admin-document"] });
//       // queryClient.invalidateQueries({ queryKey: ["document-details"] });

//       onSuccessCallback?.();
//     },

//     onError: (error) => {
//       let message = "Upload failed";

//       if (axios.isAxiosError(error)) {
//         message = error.response?.data?.message || message;
//       } else if (error instanceof Error) {
//         message = error.message;
//       }

//       errorToast(message);
//     },
//   });
// };

// for admin use

export const useUploadAdminDocument = (
  onSuccessCallback?: () => void
) => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async ({ files, id }: UploadPayload) => {
      if (!files?.length) {
        throw new Error("No files selected");
      }

      // if (!id) {
      //   throw new Error("Document ID is required");
      // }

      const formData = new FormData();

      files.forEach((file) => {
        formData.append("images", file);
      });

      const { data } = await adminApi.put(
        `/cdec/admin/update/${id}`,
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );

      return data;
    },

    onSuccess: (data) => {
      successToast(
        data?.message || "Documents uploaded successfully"
      );

      queryClient.invalidateQueries({
        queryKey: ["cdec"],
      });

      onSuccessCallback?.();
    },

    onError: (error) => {
      let message = "Upload failed";

      if (axios.isAxiosError(error)) {
        message =
          error.response?.data?.message || message;
      } else if (error instanceof Error) {
        message = error.message;
      }

      errorToast(message);
    },
  });
};

// export const useUpdateAdminDocument = () => {
//   const queryClient = useQueryClient();

//   return useMutation({
//     mutationFn: async ({
//       files,
//       id,
//     }: UploadPayload) => {
//       const formData = new FormData();

//       files.forEach((file) => {
//         formData.append("images", file);
//       });

//       const { data } = await adminApi.put(
//         `/cdec/admin/update/${id}`,
//         formData,
//         {
//           headers: {
//             "Content-Type":
//               "multipart/form-data",
//           },
//         }
//       );

//       return data;
//     },

//     onSuccess: (data) => {
//       successToast(
//         data?.message ||
//         "Document updated successfully"
//       );

//       queryClient.invalidateQueries({
//         queryKey: ["cdec"],
//       });
//     },

//     onError: (error) => {
//       let message = "Update failed";

//       if (axios.isAxiosError(error)) {
//         message =
//           error.response?.data?.message ||
//           message;
//       }

//       errorToast(message);
//     },
//   });
// };

export const useGetAdminDocument = (path: string, id?: string) => {
  return useQuery({
    queryKey: ["cdec"],
    queryFn: async () => {
      try {
        const res = await adminApi.get(`/cdec/${path}/get/${id}`);
        return res?.data?.data || null;

      } catch (error: any) {
        // errorToast(error?.message || "Failed to fetch document");
        throw error;
      }
    },
    staleTime: Infinity,
    refetchOnWindowFocus: false,
    refetchOnReconnect: false,
  });
};

export const useGetAdminDocumentByUser = (path: string) => {
  return useQuery({
    queryKey: ["cdec"],
    queryFn: async () => {
      try {
        const res = await api.get(`/cdec/${path}/get`);
        return res?.data?.data || null;

      } catch (error: any) {
        // errorToast(error?.message || "Failed to fetch document");
        throw error;
      }
    },
    staleTime: Infinity,
    refetchOnWindowFocus: false,
    refetchOnReconnect: false,
  });
};