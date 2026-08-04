"use client";

import ReadTextPopup from '@/components/ReadTextPopup';
import { ReusableCard } from "@/components/ReusableCard";
import { Button } from "@/components/ui/button";
import { useRouter } from 'next/navigation';

export default function BankReceipt() {
    const router = useRouter();

    return (
        <div className="min-h-screen flex items-center justify-center md:py-5 bg-white md:bg-gray-100">
            <ReusableCard
                title="Payment Procedure Guide"
                description="You can make your payment using two simple options">
                <div className="space-y-5">
                    <section>
                        <h3 className="font-semibold text-base">
                            By Bank Transfer:
                        </h3>
                        <p className="text-sm text-gray-700">
                            Transfer the amount directly from your bank account to the account shared by us. Processing time may vary depending on your bank.
                        </p>
                    </section>

                    <section>
                        <h3 className="font-semibold text-base">
                            NEFT (National Electronic Funds Transfer)
                        </h3>
                        <p className="text-sm text-gray-700">
                            A secure and widely used method in India to transfer funds using the provided bank details.
                        </p>
                    </section>

                    <div className="text-sm text-gray-800">
                        Please ensure you share your&nbsp;
                        <ReadTextPopup
                            text="An AD Code (Authorized Dealer Code) is a unique 14-digit numerical identifier issued by banks authorized by the Reserve Bank of India (RBI). It is essential for businesses engaging in international transactions, particularly for exports and imports."
                            trigger={
                                <span className="font-semibold text-primary cursor-pointer">14-digit AD Code</span>
                            }
                        />&nbsp;
                        Authorized Dealer Code issued by your bank, as it is required for regulatory and customs documentation to avoid delays.
                    </div>

                    <Button className="w-full mt-4 py-6 text-xl font-medium" onClick={() => router.replace("/caretaker/bank-receipt/upload")}>
                        Upload Bank Receipt
                    </Button>
                </div>
            </ReusableCard>
        </div>
    );
}
