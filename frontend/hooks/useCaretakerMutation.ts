import api from '@/lib/axios';
import { useMutation, useQuery, useInfiniteQuery, useQueryClient } from '@tanstack/react-query';
import useAuth from '@/store/useAuth';
import { ApiErrorResponse, ReactQueryResponse, RegisterFormValues } from '@/types/schema';
import { errorToast, successToast } from '@/utils/toast';
import { AxiosError } from 'axios';
import { useRouter } from 'next/navigation';
import { UserAllData, UserRow } from '@/types/adminHooksTypes';
import adminApi from '@/lib/adminApi';

interface Pagination {
    total: number;
    page: number;
    limit: number;
    totalPages: number;
}

interface UserResponse {
    users: UserRow[];
    pagination: Pagination;
}

// caretaker register request
export const useRegister = () => {
    const router = useRouter();
    const setUser = useAuth((s) => s.setUser);

    return useMutation<ReactQueryResponse, AxiosError<ApiErrorResponse>, RegisterFormValues>({
        mutationFn: async (payload: RegisterFormValues) => {
            const { data } = await api.post<ReactQueryResponse>("/caretaker/register", payload);
            return data;
        },

        onSuccess: (resp) => {
            const caretaker = resp?.data?.caretaker;

            setUser(caretaker);
            successToast("Caretaker registered successfully");
            router.push("/caretaker/prescribed-medicine");
        },

        onError: (error) => {
            const message =
                error.response?.data?.message ||
                error.message ||
                "Registration failed! Please try again.";

            errorToast(message);
        },
    });
};

type UpdateCaretakerPayload = {
    caretakerId: string;
    data: RegisterFormValues;
    image?: File | null; // add this
};

export const useUpdateCaretaker = () => {
    const router = useRouter();
    const setUser = useAuth((s) => s.setUser);
    const queryClient = useQueryClient();

    return useMutation
        <ReactQueryResponse,
            AxiosError<ApiErrorResponse>,
            UpdateCaretakerPayload
        >({
            mutationFn: async ({
                caretakerId,
                data: payload,
                image,
            }: UpdateCaretakerPayload) => {

                const formData = new FormData();

                // Append all fields
                formData.append("fullname", payload.fullname);
                formData.append("email", payload.email || "");
                formData.append("relationship", payload.relationship);
                formData.append("country", payload.country);
                formData.append("city", payload.city);
                formData.append("pincode", payload.pincode);
                formData.append("phone", payload.phone || "");

                // Append patient as JSON string
                formData.append("patient", JSON.stringify(payload.patient));

                // Append image if provided
                if (image) {
                    formData.append("images", image);
                }

                const response = await api.put<ReactQueryResponse>(
                    `/caretaker/update/${caretakerId}`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                return response.data;
            },

            onSuccess: (resp) => {
                const caretaker = resp?.data?.caretaker;
                setUser(caretaker);
                successToast("Caretaker updated successfully");
                queryClient.invalidateQueries({ queryKey: ["profile"] });
                router.push("/home")

            },

            onError: (error) => {
                const message =
                    error.response?.data?.message ||
                    error.message ||
                    "Update failed! Please try again.";
                errorToast(message);
            },
        });
};

export const useGetCaretaker = () => {
    return useQuery({
        queryKey: ['caretaker'],
        queryFn: async () => {
            const { data } = await api.get("/caretaker/me");
            return data?.data;
        },
        staleTime: 5 * 60 * 1000,
        retry: 1,
    });
};

// export const useGetCaretakerStatus = () => {
//     return useQuery({
//         queryKey: ['caretaker-status'],
//         queryFn: async () => {
//             const resp = await api.get("/caretaker");
//             return resp.data?.data
//         },
//         retry: false,
//         staleTime: 0,
//         // staleTime: 5 * 60 * 1000,
//     });
// };


// for admin use 
export const useInfiniteUsers = (limit: number = 10) => {
    return useInfiniteQuery<UserResponse, Error>({
        queryKey: ["users-infinite", limit],

        queryFn: async ({ pageParam = 1 }) => {
            const { data } = await adminApi.get("/auth/user-data", {
                params: { page: pageParam, limit },
            });

            // adjust based on backend
            return data.data ?? data;
        },

        getNextPageParam: (lastPage) => {
            if (!lastPage?.pagination) return undefined;

            const { page, totalPages } = lastPage.pagination;
            return page < totalPages ? page + 1 : undefined;
        },

        initialPageParam: 1,
    });
};

export const useGetUserAllData = (userId: string) => {
    return useQuery<UserAllData>({
        queryKey: ["user-all-data", userId],
        enabled: !!userId,

        queryFn: async () => {
            const res = await adminApi.get(`/auth/user-data/${userId}`);
            const json = res.data;

            if (!res) {
                // errorToast(res || "Failed to fetch user data");
                throw new Error(res || "Failed to fetch user data");
            }

            return json.data as UserAllData;
        },

        // make data always fresh
        staleTime: 5,

        // auto refresh when user comes back to tab
        // refetchOnWindowFocus: true,

        // retry on reconnect
        // refetchOnReconnect: true,

        // optional: background refresh every 15 sec (dashboard)
        refetchInterval: 15000,
        // refetchIntervalInBackground: true,
        // cacheTime: 1000 * 60 * 10,
        // retry: 1,
    });
};


// export const useUpdateCaretakerStatus = (
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
//                 `/caretaker/admin/update/${id}`,
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
//                 queryKey: ["Caretaker"],
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

// export const useUpdateCaretaker = () => {
//     return useMutation({
//         mutationFn: async ({
//             id,
//             status,
//         }: {
//             id: string;
//             status: string;
//         }) => {
//             const { data } = await api.put(
//                 `/admin/update/${id}`,
//                 { status }
//             );
//             return data;
//         },

//         onSuccess: (data, variables) => {
//             return data
//             successToast("Caretaker Updated Successfully");
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


// caretaker get request
// export const useGetMyCaretaker = () => {
//     return useQuery({
//         queryKey: ['my-caretaker'],
//         queryFn: async () => {
//             const { data } = await api.get('/caretaker');
//             return data.data;
//         },
//         staleTime: 5 * 60 * 1000, // 5 min cache
//         retry: 1,
//     });
// };

// export const useUpdateMyCaretaker = () => {
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
//                 `/caretaker/update/${id}`, // dynamic id
//                 payload
//             );
//             return data;
//         },

//         onSuccess: (data, variables) => {
//             // safer cache update
//             queryClient.setQueryData(['my-caretaker'], (old: any) => {
//                 if (!old) return data;

//                 return {
//                     ...old,
//                     caretaker: {
//                         ...old?.caretaker,
//                         ...data?.caretaker,
//                     },
//                 };
//             });

//             // navigate after success
//             successToast("Caretaker Updated Successfully");
//             router.push("/caretaker/prescribed-medicine");

//             // optional (keep if backend mutates extra fields)
//             queryClient.invalidateQueries({ queryKey: ['my-caretaker'] });
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