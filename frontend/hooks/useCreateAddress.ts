import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import api from '@/lib/axios';
import { errorToast, successToast } from '@/utils/toast';
import { AddressFormValues, ApiErrorResponse } from '@/types/schema';
import { AxiosError } from "axios";

export type AddressRecord = AddressFormValues & {
    _id: string;
    phone: string;
    createdAt?: string;
    updatedAt?: string;
};

export const useCreateAddress = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: async (payload: AddressFormValues) => {
            const { data } = await api.post("/delivery-address/add", payload);
            return data;
        },

        onSuccess: () => {
            successToast("Address added successfully");
            queryClient.invalidateQueries({ queryKey: ["delivery-address"] });
        },

        onError: (err: AxiosError<ApiErrorResponse>) => {
            const message =
                err.response?.data?.message || "Something went wrong";
            errorToast(message);
        },
    });
};

export const useGetAddress = () => {
    return useQuery<AddressRecord | null>({
        queryKey: ["delivery-address"],
        queryFn: async () => {
            const { data } = await api.get("/delivery-address/me");
            const addresses = data?.data;
            return Array.isArray(addresses) ? addresses[0] ?? null : addresses ?? null;
        },
        retry: 1,
        staleTime: 5 * 60 * 1000,
    });
};

export const useUpsertAddress = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: async ({
            addressId,
            payload,
        }: {
            addressId?: string;
            payload: AddressFormValues;
        }) => {
            const { data } = addressId
                ? await api.put(`/delivery-address/update/${addressId}`, payload)
                : await api.post("/delivery-address/add", payload);

            return data;
        },

        onSuccess: () => {
            successToast("Address updated successfully");
            queryClient.invalidateQueries({ queryKey: ["delivery-address"] });
        },

        onError: (err: AxiosError<ApiErrorResponse>) => {
            const message =
                err.response?.data?.message || "Something went wrong";
            errorToast(message);
        },
    });
};
