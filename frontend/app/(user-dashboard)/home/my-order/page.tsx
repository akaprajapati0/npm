"use client";

import GoBackBtn from "@/components/GoBackBtn";
import { ReusableCard } from "@/components/ReusableCard";
import { useGetOrdersByUser } from "@/hooks/useOrderMutation";
import { useGetProfile } from "@/hooks/useAuthMutations";
import DateDisplay from '@/lib/readableDate';

function formatCurrency(amount: number): string {
    return new Intl.NumberFormat("en-IN", {
        style: "currency",
        currency: "INR",
        maximumFractionDigits: 0,
    }).format(amount);
}

export default function Page() {
    const { data: profile, isPending: isProfilePending } = useGetProfile();
    const userId = profile?.user?._id;

    const { data: orders, isPending: isOrdersPending } = useGetOrdersByUser();

    if (isProfilePending || isOrdersPending) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home" ariaLabel="Back to home" />

            <ReusableCard
                title="Payment Details"
                description="Collect your medicine quote with pricing and availability based on prescription details provided."
            >
                {!orders?.length ? (
                    <p className="text-sm text-center text-gray-500">No orders found yet.</p>
                ) : (
                    <div className="space-y-4">
                        {orders.map((order, index) => (
                            <section
                                key={order._id}
                                className="border border-primary rounded-md p-4 space-y-4"
                            >
                                <header>
                                    <h2 className="text-primary font-semibold">
                                        Order {index + 1}
                                    </h2>
                                    <p className="text-sm text-gray-600">
                                        Invoice Amount:{" "}
                                        <span className="font-medium">
                                            {formatCurrency(order.invoiceAmount)}
                                        </span>
                                    </p>
                                </header>

                                <div>
                                    <h3 className="font-semibold mb-2">Payment Details</h3>

                                    {!order.payments.length ? (
                                        <p className="text-sm text-gray-500">
                                            No payments received yet.
                                        </p>
                                    ) : (
                                        <ul className="space-y-1 text-sm">
                                            {order.payments.map((payment, paymentIndex) => (
                                                <li key={payment._id}>
                                                    Payment {paymentIndex + 1}:{" "}
                                                    <span className="font-medium">
                                                        {formatCurrency(payment.amount)}
                                                    </span>{" "}
                                                    <span className="text-gray-500">
                                                        | Received on:{" "}
                                                        <DateDisplay isoString={payment.receivedOn} />
                                                    </span>
                                                </li>
                                            ))}
                                        </ul>
                                    )}
                                </div>

                                <div className="border-t pt-2 text-sm space-y-1">
                                    <p>
                                        Total Received:{" "}
                                        <span className="font-medium">
                                            {formatCurrency(order.totalReceived)}
                                        </span>
                                    </p>
                                    <p>
                                        Balance Amount:{" "}
                                        <span className="font-medium">
                                            {formatCurrency(order.balanceAmount)}
                                        </span>
                                    </p>
                                </div>
                            </section>
                        ))}
                    </div>
                )}
            </ReusableCard>
        </div>
    );
}
