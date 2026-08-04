import { useMutation } from "@tanstack/react-query";
import api from '@/lib/axios';
import { errorToast, successToast } from '@/utils/toast';
import { AddressFormValues } from '@/types/schema';

export const useCreateAddress = () => {
    return useMutation({
        mutationFn: async (payload: AddressFormValues) => {
            const { data } = await api.post("/delivery-address/add", payload);
            return data;
        },

        onSuccess: () => {
            successToast("Address added successfully");
        },

        onError: (err: any) => {
            const message =
                err?.response?.data?.message || "Something went wrong";
            errorToast(message);
        },
    });
};
