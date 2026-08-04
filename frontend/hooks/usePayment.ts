import adminApi from '@/lib/adminApi';
import api from '@/lib/axios';
import { Payment } from '@/types/adminHooksTypes';
import { ReactQueryResponse } from '@/types/schema';
import { errorToast, successToast } from '@/utils/toast';
import { useMutation, useQueryClient } from '@tanstack/react-query';
import { useQuery } from "@tanstack/react-query";


interface PaymentPayload {
    user: string;
    paymentReceived?: string;
    paymentLeft?: string;
    accountNumber?: string;
    ifsc?: string;
    branch?: string;
}
// for admin use
export const useCreatePayment = (
    onSuccessCallback?: () => void
) => {
    const queryClient = useQueryClient();
    return useMutation<
        ReactQueryResponse,
        unknown,
        PaymentPayload
    >({
        mutationFn: async (payload) => {
            const { data } =
                await adminApi.post<ReactQueryResponse>(
                    "/payment/create",
                    payload
                );

            return data;
        },

        onSuccess: (res) => {
            if (!res.success) {
                errorToast(res.message);
                return;
            }

            successToast(res.message);

            queryClient.invalidateQueries({
                queryKey: ["single-payment"],
            });

            onSuccessCallback?.();
        },

        onError: (error: any) => {
            const msg =
                error?.response?.data?.message ||
                error?.message ||
                "Something went wrong";

            errorToast(msg);
        },
    });
};

export const useGetSinglePayment = () => {
    return useQuery<ReactQueryResponse>({
        queryKey: ["single-payment"],

        queryFn: async () => {
            const { data } = await api.get<ReactQueryResponse>(
                `/payment/get-single`
            );

            if (!data) {
                throw new Error("Payment not found");
            }

            return data;
        },

        // enabled: !!paymentId,
        retry: 1,
    });
};

export const useGetPaymentByUserId = (userId: string) => {
    return useQuery<Payment[]>({
        queryKey: ["payments", userId],

        queryFn: async () => {
            const { data } = await adminApi.get<{ data: Payment[] }>(
                `/payment/get-single/${userId}`
            );

            return data.data;
        },

        enabled: !!userId,
        retry: 1,
    });
};

export const useGetPayments = () => {
    return useQuery<ReactQueryResponse>({
        queryKey: ["payments"],

        queryFn: async () => {
            const { data } =
                await api.get<ReactQueryResponse>(
                    "/payment"
                );

            return data;
        },
    });
};