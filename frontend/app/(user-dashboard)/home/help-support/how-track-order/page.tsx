import GoBackBtn from '@/components/GoBackBtn';
import { Card } from '@/components/ui/card';
import Link from 'next/link';

export default function Page() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home/help-support" ariaLabel="go back home" />

            <div className="flex flex-col min-h-[calc(100vh-80px)] md:items-center md:justify-center">
                <Card className="w-full max-w-md mx-auto border-none shadow-none flex flex-col justify-between grow p-4">
                    <div className="space-y-5">
                        <h1 className="font-bold text-lg">How Can I Track My Order?</h1>
                        <p className="">You can track your order directly through the platform by selecting the “Track Order” option in your dashboard or order section. Once your order is processed and shipped, a unique tracking number will be provided to view real-time updates on its status and location.
                            <br />
                            This allows you to monitor every stage of the delivery process from dispatch to final delivery ensuring complete transparency. For any assistance, our support team is available to help.</p>
                    </div>

                    <div className="mt-auto pt-10 w-full">
                        <Link
                            href="/track"
                            className="block w-full bg-primary rounded-md px-4 py-2 text-white text-center font-medium hover:opacity-90 transition"
                        >
                            Track Your Medicine
                        </Link>
                    </div>
                </Card>
            </div>
        </div>
    )
}