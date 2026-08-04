import adminApi from '@/lib/adminApi';
import api from '@/lib/axios';
import { CreateOrderPayload, Order } from '@/types/adminHooksTypes';
import { errorToast, successToast } from '@/utils/toast';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import axios, { AxiosError } from 'axios';

interface ApiResponse<T> {
    success: boolean;
    message: string;
    data: T;
}

interface ApiErrorResponse {
    success: false;
    message: string;
}

export const useCreateOrderDetails = (onSuccessCallback?: () => void) => {
    const queryClient = useQueryClient();

    return useMutation<any, Error, CreateOrderPayload>({
        mutationFn: async ({ userId, invoiceAmount, payments }) => {
            const { data } = await adminApi.post("/order/create", {
                userId,
                invoiceAmount,
                payments,
            });
            return data;
        },
        onSuccess: (data) => {
            successToast(data?.message || "Order created successfully");
            queryClient.invalidateQueries({ queryKey: ["orders"] });
            onSuccessCallback?.();
        },
        onError: (error) => {
            let message = "Failed to create order";
            if (axios.isAxiosError(error)) {
                message = error.response?.data?.message || message;
            } else if (error instanceof Error) {
                message = error.message;
            }
            errorToast(message);
        },
    });
};

export const useGetOrdersByAdmin = (id?: string) => {
    return useQuery<Order[], Error>({
        queryKey: ["orders", id],

        queryFn: async () => {
            const { data } = await adminApi.get<{ data: Order[] }>(
                `/order/get/${id}`
            );

            return data.data;
        },

        enabled: !!id, // Only run when id exists
        retry: 1,
        throwOnError: false,
    });
};

export const useGetOrdersByUser = () => {
    return useQuery<Order[]>({
        queryKey: ["orders"],

        queryFn: async () => {
            const { data } = await api.get<{ data: Order[] }>("/order/get");

            return data.data;
        },

        retry: 1,
    });
};

export const useGetOrderDetails = (orderNumber: string) => {
    return useQuery<Order, AxiosError<ApiErrorResponse>>({
        queryKey: ["order-details", orderNumber],

        queryFn: async () => {
            const { data } = await api.get<ApiResponse<Order>>(
                "/order/details",
                {
                    params: { orderNumber },
                }
            );

            if (!data.success) {
                throw new Error(data.message);
            }

            return data.data;
        },

        enabled: !!orderNumber,
        retry: 1,
    });
};