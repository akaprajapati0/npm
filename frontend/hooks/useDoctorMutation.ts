import api from '@/lib/axios'
import { DoctorDetailsFormValues, ReactQueryResponse } from '@/types/schema'
import { errorToast, successToast } from '@/utils/toast';
import { useMutation, useQueryClient } from '@tanstack/react-query'
import { DoctorDetailsRow } from '@/types/adminSchema';
import { useQuery } from "@tanstack/react-query";

// type DoctorDetailsResponse = {
//   data: DoctorDetailsRow[];
// };

export const useDoctorDetails = (
  onSuccessCallback?: () => void
) => {
  return useMutation<ReactQueryResponse, any, DoctorDetailsFormValues>({
    mutationFn: async (payload) => {
      const { data } = await api.post<ReactQueryResponse>(
        "/doctor-details/add",
        payload
      );
      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message || "Doctor details could not be saved");
        return;
      }

      successToast(res.message || "Doctor details saved successfully");
      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "Something went wrong. Please try again.";

      errorToast(msg);
    },
  });
};

// Doctor Counts
export const useGetDoctorCount = () => {
  return useQuery({
    queryKey: ['doctor-count'],
    queryFn: async () => {
      const resp = await api.get("/doctor-details/count");
      return resp?.data?.data
    },
    retry: false,
    staleTime: 5 * 60 * 1000,
    //         retry: 1,
  });
};

// export const useGetDoctorStatus = () => {
//   return useQuery({
//     queryKey: ['doctor-status'],
//     queryFn: async () => {
//       const resp = await api.get("/doctor-details");
//       return resp.data?.data
//     },
//     retry: false,
//     staleTime: 0,
//     // staleTime: 5 * 60 * 1000,
//   });
// };

// export const useUpdateDoctorStatus = (
//   onSuccessCallback?: () => void
// ) => {
//   const queryClient = useQueryClient();

//   return useMutation({
//     mutationFn: async ({
//       id,
//       status,
//     }: {
//       id: string;
//       status: string;
//     }) => {
//       const { data } = await api.put<ReactQueryResponse>(
//         `/doctor-details/update/${id}`,
//         { status }
//       );

//       return data;
//     },

//     onSuccess: (res) => {
//       if (!res.success) {
//         errorToast(res.message || "Failed to update status");
//         return;
//       }

//       successToast(res.message || "Status updated successfully");

//       queryClient.invalidateQueries({
//         queryKey: ["doctor-status"],
//       });

//       onSuccessCallback?.();
//     },

//     onError: (error: any) => {
//       const msg =
//         error?.response?.data?.message ||
//         error?.message ||
//         "Status update failed! Please try again.";

//       errorToast(msg);
//     },
//   });
// };


// export const useGetDoctorDetails = () => {
//   return useQuery<DoctorDetailsRow[]>({
//     queryKey: ["DoctorDetails"],

//     queryFn: async () => {
//       const res = await api.get("/doctor-details/admin");

//       const json: DoctorDetailsResponse = res;

//       if (!res) {
//         errorToast(
//           (json as any)?.message || "Failed to fetch Doctor Details"
//         );
//         return [];
//       }

//       return json?.data ?? [];
//     },
//   });
// };

