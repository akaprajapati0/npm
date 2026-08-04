import adminApi from '@/lib/adminApi';
import api from '@/lib/axios';
import { BankRecieptSubmission, ReactQueryResponse } from '@/types/schema';
import { errorToast, successToast } from '@/utils/toast';
import { useMutation, useQueryClient } from '@tanstack/react-query';
// import { BankRecieptRow } from '@/types/adminSchema';
import { useQuery } from '@tanstack/react-query';
// import { BankReceiptRow } from '@/types/adminHooksTypes';

type UpdateBankReceiptStatusPayload = {
  id: string;
  status: string;
};

// type BankReceiptResponse = {
//   data: BankRecieptRow[];
// };


export const useUploadBankReceipt = (options?: {
  onSuccess?: () => void;
  onError?: (message: string) => void;
}) => {
  return useMutation<ReactQueryResponse, Error, BankRecieptSubmission>({
    mutationFn: async (data: BankRecieptSubmission) => {
      const { documentNumber, files } = data;

      if (!files || files.length === 0) {
        throw new Error("Please upload at least one document");
      }


      const formData = new FormData();
      formData.append("documentNumber", documentNumber as string);

      files.forEach((file) => {
        formData.append("images", file);
      });

      const res = await api.post<ReactQueryResponse>(
        "/bank-receipt/upload",
        formData,
        { headers: { "Content-Type": "multipart/form-data" } }
      );

      if (!res.data.success) {
        throw new Error(res.data.message || "Upload failed");
      }

      return res.data;
    },

    onSuccess: (res) => {
      successToast(res.message);
      options?.onSuccess?.();
    },

    onError: (error: any) => {
      const message =
        error?.response?.data?.message ||
        error?.message ||
        "Internal Server Error";
      errorToast(message);
      options?.onError?.(message);
    },
  });
};


export const useGetBankReceipt = () => {
  return useQuery({
    queryKey: ["bank-receipt"],

    queryFn: async () => {
      try {
        const res = await api.get("/bank-receipt/");
        return res?.data?.data ?? [];
      } catch (error: any) {
        errorToast(error?.message || "Failed to fetch Bank Receipt");
        return [];
      }
    },
  });
};

// admin use
export const useUpdateBankReceiptStatus = (
  onSuccessCallback?: () => void
) => {
  const queryClient = useQueryClient();

  return useMutation<
    ReactQueryResponse,
    any,
    UpdateBankReceiptStatusPayload
  >({
    mutationFn: async ({ id, status }) => {
      const { data } = await adminApi.put<ReactQueryResponse>(
        `/bank-receipt/status/${id}`,
        { status }
      );

      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message || "Failed to update bank receipt status");
        return;
      }

      successToast(res.message || "Bank receipt status updated successfully");

      queryClient.invalidateQueries({
        queryKey: ["bank-reciept"],
      });

      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "Bank receipt status update failed! Please try again.";

      errorToast(msg);
    },
  });
};
