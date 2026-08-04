import api from "@/lib/axios";
import { useMutation, useQuery } from "@tanstack/react-query";
import { errorToast } from "@/utils/toast";
import adminApi from '@/lib/adminApi';

interface FeedbackPayload {
    _id?: string;
    user?: string;
    rating: number;
    feedback?: string;
    followUp?: boolean;
    createdAt?: string;
    updatedAt?: string;
}

export const useSubmitFeedback = () => {
    return useMutation({
        mutationFn: async (payload: FeedbackPayload) => {
            const response = await api.post("/feedback", payload);
            return response.data;
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

export const useGetUserFeedback = (id: string) => {
    return useQuery<FeedbackPayload[]>({
        queryKey: ["feedback", id],

        queryFn: async () => {
            const { data } = await adminApi.get<{ data: FeedbackPayload[] }>(
                `/feedback-get/${id}`
            );

            return data.data;
        },

        enabled: !!id,
        retry: 1,
    });
};