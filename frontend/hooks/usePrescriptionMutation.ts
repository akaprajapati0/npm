import adminApi from '@/lib/adminApi';
import api from "@/lib/axios";
// import { PrescriptionRow } from '@/types/adminSchema';
import { ReactQueryResponse } from "@/types/schema";
import { errorToast, successToast } from "@/utils/toast";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";

// type PrescriptionResponse = {
//   data: PrescriptionRow[];
// };

type UpdatePrescriptionStatusPayload = {
  id: string;
  status: string;
};

export const useUploadPrescription = (
  onSuccessCallback?: () => void
) => {
  const queryClient = useQueryClient();
  return useMutation<ReactQueryResponse, unknown, File[]>({
    mutationFn: async (files) => {
      if (!files.length) {
        throw new Error("No files selected");
      }

      const formData = new FormData();

      files.forEach((file) => {
        formData.append("images", file);
      });

      const { data } = await api.post<ReactQueryResponse>(
        "/prescription/upload",
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        }
      );

      return data;
    },

    onSuccess: async (res) => {
      if (!res.success) {
        errorToast(res.message || "Prescription upload failed");
        return;
      }

      await queryClient.invalidateQueries({
        queryKey: [
          "prescriptions",
        ],
      });

      successToast(res.message || "Prescription uploaded successfully");
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

export const useGetPrescriptionCount = () => {
  return useQuery({
    queryKey: ['prescriptions'],
    queryFn: async () => {
      const resp = await api.get("/prescription/count");
      return resp?.data?.data
    },
    retry: false,
    staleTime: 5 * 60 * 1000,
  });
};

export const useGetPrescription = () => {
  return useQuery({
    queryKey: ['prescriptions'],
    queryFn: async () => {
      const resp = await api.get("/prescription/");
      return resp?.data?.data
    },
    retry: true,
  });
};

// export const usePrescription = () => {
//   return useQuery<PrescriptionRow[]>({
//     queryKey: ["Prescription"],

//     queryFn: async () => {
//       const res = await api.get("/prescription/admin");

//       const json: PrescriptionResponse = await res;

//       if (!res) {
//         errorToast(
//           (json as any)?.message || "Failed to fetch Prescription"
//         );
//         return [];
//       }

//       return json?.data ?? [];
//     },
//   });
// };

export const useUpdatePrescriptionStatus = (
  onSuccessCallback?: () => void
) => {
  const queryClient = useQueryClient();

  return useMutation<
    ReactQueryResponse,
    any,
    UpdatePrescriptionStatusPayload
  >({
    mutationFn: async ({ id, status }) => {
      const { data } = await adminApi.put<ReactQueryResponse>(
        `/prescription/update/${id}`,
        { status }
      );

      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message || "Failed to update status");
        return;
      }

      successToast(res.message || "Status updated successfully");

      queryClient.invalidateQueries({
        queryKey: ["prescription-status"],
      });

      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "Status update failed! Please try again.";

      errorToast(msg);
    },
  });
};
