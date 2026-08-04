import api from '@/lib/axios';
import { useProgressStore } from '@/store/progressStore';
import { KYCSubmission, ReactQueryResponse } from '@/types/schema';
import { errorToast, successToast } from '@/utils/toast';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { useGetProfile } from './useAuthMutations';
import { KycRow } from '@/types/adminSchema';
import adminApi from '@/lib/adminApi';

type KycResponse = {
  data: KycRow[];
};

type UpdateKycStatusPayload = {
  id: string;
  status: string;
};

export const useUploadKyc = (onSuccessCallback?: () => void) => {
  const setProgress = useProgressStore((s) => s.setProgress);
  const { data } = useGetProfile();
  return useMutation({
    mutationFn: async (data: KYCSubmission) => {
      const {
        documentNumber,
        documentType,
        files,
      } = data as any;

      if (!files?.length) {
        errorToast("No files selected");
      }


      const formData = new FormData();

      // Required fields
      formData.append("documentNumber", documentNumber);
      formData.append("documentType", documentType);
      files.forEach((file: any) => {
        formData.append("images", file);
      });

      // Optional extra documents
      if ((data as any).extraDocuments?.length) {
        (data as any).extraDocuments.forEach((file: File) => {
          formData.append("extraDocuments", file);
        });
      }

      const response = await api.post("/kyc/upload", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });

      return response.data;
    },

    onSuccess: (res) => {
      if (!res?.success) {
        return errorToast(res?.message || "Upload failed");
      }
      const progress = data?.user.progress;
      setProgress(progress);
      successToast(res.message || "KYC uploaded successfully");

      onSuccessCallback?.();
    },

    onError: (err: any) => {
      const message =
        err?.response?.data?.message ||
        err?.message ||
        "Internal Server Error";

      errorToast(message);
    },
  });
};

export const useGetKyc = () => {
  return useQuery({
    queryKey: ['kyc-status'],
    queryFn: async () => {
      const resp = await api.get("/kyc/");
      return resp?.data?.data
    },
    retry: false,
  });
};

// for admin use

export const useUpdateKycStatus = (
  onSuccessCallback?: () => void
) => {
  const queryClient = useQueryClient();

  return useMutation<
    ReactQueryResponse,
    any,
    UpdateKycStatusPayload
  >({
    mutationFn: async ({ id, status }) => {
      const { data } = await adminApi.put<ReactQueryResponse>(
        `/kyc/status/${id}`,
        { status }
      );

      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message || "Failed to update KYC status");
        return;
      }

      successToast(res.message || "KYC status updated successfully");

      // Refetch KYC data so UI updates immediately
      queryClient.invalidateQueries({ queryKey: ["kyc"] });

      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "KYC status update failed! Please try again.";

      errorToast(msg);
    },
  });
};


// export const useKyc = () => {
//   return useQuery<KycRow[]>({
//     queryKey: ["Kyc"],

//     queryFn: async () => {
//       const res = await api.get("/kyc/admin");

//       const json: KycResponse = await res;

//       if (!res) {
//         errorToast(
//           (json as any)?.message || "Failed to fetch Kyc"
//         );
//         return [];
//       }

//       return json?.data ?? [];
//     },
//   });
// };

