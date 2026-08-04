"use client";

import GoBackBtn from "@/components/GoBackBtn";
import { ReusableCard } from "@/components/ReusableCard";

import { useGetSinglePayment } from "@/hooks/usePayment";

export default function PaymentDetails() {
    const {
        data,
        isPending,
        isError,
        error,
    } = useGetSinglePayment();

    const payment = data?.data;

    // Dynamic Data (safe even if payment is undefined, guarded below before use)
    const paymentSummary = payment
        ? [
            {
                label: "Payment Received",
                value: payment.paymentReceived || "N/A",
            },
            {
                label: "Payment Left",
                value: payment.paymentLeft || "N/A",
            },
        ]
        : [];

    const bankDetails = payment
        ? [
            {
                label: "Account Number",
                value: payment.accountNumber || "N/A",
            },
            {
                label: "IFSC Code",
                value: payment.ifsc || "N/A",
            },
            {
                label: "Branch",
                value: payment.branch || "N/A",
            },
        ]
        : [];

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn
                href="/home"
                ariaLabel="back to home"
            />

            <ReusableCard
                title="Left Out Payment"
                description="Check and complete remaining payments required at the time of customs clearance."
            >
                {/* ---------- Loading ---------- */}
                {isPending && (
                    <p className="text-center text-muted-foreground py-10">
                        Loading payment details...
                    </p>
                )}

                {/* ---------- Error ---------- */}
                {!isPending && isError && (
                    <p className="text-center text-red-500 py-10">
                        {(error as any)?.response?.data?.message ||
                            "Something went wrong"}
                    </p>
                )}

                {/* ---------- Empty ---------- */}
                {!isPending && !isError && !payment && (
                    <div className="text-center space-y-2 py-10">
                        <h2 className="text-lg font-semibold">
                            No payment details found
                        </h2>

                        <p className="text-sm text-gray-500">
                            Payment details are not
                            available yet.
                        </p>
                    </div>
                )}

                {/* ---------- Data ---------- */}
                {!isPending && !isError && payment && (
                    <>
                        {/* Summary */}
                        <section className="space-y-2">
                            <h2 className="font-black">
                                Left out payment:
                            </h2>

                            {paymentSummary.map((item) => (
                                <div
                                    key={item.label}
                                    className="flex justify-between px-2 text-sm"
                                >
                                    <p>{item.label}</p>
                                    <span className="font-medium">{item.value}</span>
                                </div>
                            ))}
                        </section>

                        {/* CHA Details */}
                        <section className="text-center space-y-2 mt-10">
                            <h2 className="font-black text-xl">
                                CHA DETAILS
                            </h2>

                            <p className="text-primary font-bold text-xl">
                                {payment.paymentLeft || "N/A"}
                            </p>

                            <p className="max-w-xs mx-auto text-sm text-gray-600">
                                This payment is
                                required at the time
                                of customs clearance.
                            </p>
                        </section>

                        {/* Bank Details */}
                        <section className="mt-10 space-y-2">
                            <h2 className="font-black">
                                Payment Details:
                            </h2>

                            {bankDetails.map((item) => (
                                <div
                                    key={item.label}
                                    className="flex justify-between px-2 text-sm"
                                >
                                    <p>{item.label}:</p>
                                    <span className="font-medium">{item.value}</span>
                                </div>
                            ))}
                        </section>

                        {/* Note */}
                        <section className="mt-10 space-y-1">
                            <p className="font-black">Note:</p>
                            <p className="text-sm text-gray-600">
                                Access details of
                                any payment required
                                to be completed
                                during customs
                                clearance.
                            </p>
                        </section>
                    </>
                )}
            </ReusableCard>
        </div>
    );
}