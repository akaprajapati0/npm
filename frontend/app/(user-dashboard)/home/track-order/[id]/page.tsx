"use client";

import { useParams } from 'next/navigation';
import Image from "next/image";
import GoBackBtn from "@/components/GoBackBtn";
import OrderTrackingBar from "@/components/OrderTrackingBar";
import { useGetOrderDetails } from "@/hooks/useOrderMutation";

export default function Order() {
    const params = useParams();
    const id = params.id;

    const {
        data: order,
        isLoading,
        isError,
    } = useGetOrderDetails(id as string);

    // Invalid order
    if (!id) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <p className="text-gray-500">Invalid order number</p>
            </div>
        );
    }

    if (isLoading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <p className="text-blue-500">Loading tracking...</p>
            </div>
        );
    }

    if (isError || !order) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <p className="text-red-500">Order not found</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home/track-order" ariaLabel="Back to dashboard" />

            <div className="flex justify-center">
                <div className="relative w-full max-w-md">

                    <Image
                        src="/tracking-img.svg"
                        alt="Parcel delivery"
                        width={500}
                        height={500}
                        priority
                        className="w-full object-contain rounded-t-md"
                    />

                    <div className="absolute top-84 left-0 w-full bg-white rounded-t-2xl shadow-lg p-4">
                        <OrderTrackingBar currentStatus={order._id} />
                    </div>

                </div>
            </div>
        </div>
    );
}