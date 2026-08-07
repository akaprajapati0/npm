import { useQuery } from "@tanstack/react-query";

import api from '@/lib/axios';
import { MedicineResult, PrescribedFormValues } from '@/types/schema';
import { errorToast, successToast } from '@/utils/toast';
import { useMutation } from '@tanstack/react-query';
import { useRouter } from 'next/navigation';
import { useDebounce } from './useDebounce';
// import { PrescribedMedicine } from '@/types/adminSchema';

export const useMedicineSearch = (query: string) => {
    const debouncedQuery = useDebounce(query, 400);

    return useQuery<MedicineResult[]>({
        queryKey: ["medicine-search", debouncedQuery],
        queryFn: async () => {
            if (!debouncedQuery || debouncedQuery.length < 2) return [];

            const { data } = await api.get<{
                success: boolean;
                data: MedicineResult[];
            }>(`/medicines/search`, {
                params: { q: debouncedQuery },
            });

            return data.data ?? [];
        },
        enabled: !!debouncedQuery && debouncedQuery.length >= 2,
        staleTime: 5 * 60 * 1000,
    });
};

export const usePrescribedMedicine = () => {
    const router = useRouter();

    return useMutation({
        mutationFn: async (payload: PrescribedFormValues) => {
            const { data } = await api.post("/prescribed-medicine/add", payload);
            return data;
        },
        onSuccess: (res) => {
            if (res?.success) {
                successToast("Prescribed medicine saved successfully");
                router.push("/caretaker/doctor-details");
            } else {
                errorToast(res?.message || "Data was not saved");
            }
        },
        onError: (error: any) => {
            const msg = error?.response?.data?.message || error?.message || "Upload failed!";
            errorToast(msg);
            console.error("Mutation Error:", error);
        }
    });
};

export const useGetPrescribedMedCount = () => {
    return useQuery({
        queryKey: ['prescribed-medicine'],
        queryFn: async () => {
            const resp = await api.get("/prescribed-medicine/count");
            return resp?.data?.data
        },
        retry: false,
        staleTime: 5 * 60 * 1000,
        //         retry: 1,
    });
};

// export const useGetPrescribedMedStatus = () => {
//     return useQuery({
//         queryKey: ['prescribed-medicine'],
//         queryFn: async () => {
//             const resp = await api.get("/prescribed-medicine/");
//             return resp.data?.data
//         },
//         retry: false,
//         staleTime: 0,
//         // staleTime: 5 * 60 * 1000,
//     });
// };

// caretaker get request
// export const useGetPrescribedMed = () => {
//     return useQuery({
//         queryKey: ['my-prescribed-medicine'],
//         queryFn: async () => {
//             const { data } = await api.get('/prescribed-medicine');
//             return data.data;
//         },
//         staleTime: 5 * 60 * 1000, // 5 min cache
//         retry: 1,
//     });
// };


// export const useUpdatePrescribedMed = () => {
//     const router = useRouter();
//     const queryClient = useQueryClient();

//     return useMutation({
//         mutationFn: async ({
//             id,
//             payload,
//         }: {
//             id: string;
//             payload: any;
//         }) => {
//             const { data } = await api.put(
//                 `/prescribed-medicine/update/${id}`, // dynamic id
//                 payload
//             );
//             return data;
//         },

//         onSuccess: (data, variables) => {
//             // safer cache update
//             queryClient.setQueryData(['my-prescribed-medicine'], (old: any) => {
//                 if (!old) return data;

//                 return {
//                     ...old,
//                     prescribedMedicine: {
//                         ...old?.prescribedMedicine,
//                         ...data?.prescribedMedicine,
//                     },
//                 };
//             });

//             // navigate after success
//             successToast("Medicine Updated Successfully");
//             router.push("/caretaker/doctor-details");

//             // optional (keep if backend mutates extra fields)
//             queryClient.invalidateQueries({ queryKey: ['my-prescribed-medicine'] });
//         },

//         onError: (error: any) => {
//             const message =
//                 error.response?.data?.message ||
//                 error.message ||
//                 "Update failed! Please try again.";

//             errorToast(message);
//         },
//     });
// };


// export const useGetAllPrescribedMed = () => {
//     return useQuery<PrescribedMedicine[]>({
//         queryKey: ['prescribed-medicine'],
//         queryFn: async () => {
//             const resp = await api.get("/prescribed-medicine/admin");
//             return resp?.data?.data;
//         },
//         retry: false,
//     });
// };

// export const useUpdatePrescribedMedStatus = (
//     onSuccessCallback?: () => void
// ) => {
//     const queryClient = useQueryClient();

//     return useMutation({
//         mutationFn: async ({
//             id,
//             status,
//         }: {
//             id: string;
//             status: string;
//         }) => {
//             const { data } = await api.put<ReactQueryResponse>(
//                 `/prescribed-medicine/update/${id}`,
//                 { status }
//             );

//             return data;
//         },

//         onSuccess: (res) => {
//             if (!res.success) {
//                 errorToast(res.message || "Failed to update status");
//                 return;
//             }

//             successToast(res.message || "Status updated successfully");

//             queryClient.invalidateQueries({
//                 queryKey: ["prescribed-medicine"],
//             });

//             onSuccessCallback?.();
//         },

//         onError: (error: any) => {
//             const msg =
//                 error?.response?.data?.message ||
//                 error?.message ||
//                 "Status update failed! Please try again.";

//             errorToast(msg);
//         },
//     });
// };
