import GoBackBtn from '@/components/GoBackBtn';
import { Card } from '@/components/ui/card';

export default function HowOrderMedicine() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home/help-support" ariaLabel="go back home" />

            <div className="flex flex-col min-h-[calc(100vh-80px)] md:items-center md:justify-center">
                <Card className="w-full max-w-md mx-auto border-none shadow-none flex flex-col justify-between grow p-4">
                    {/* Top Section */}
                    <div className="space-y-5">
                        <h1 className="font-bold text-lg">How can I order medicine if I am unable to read my prescription?
                        </h1>
                        <p className="">f you are unable to read or understand your prescription, you can still proceed with your request under the Named Patient Program (NPP). Simply <span className="text-primary">
                            upload a clear image
                        </span> or copy of the prescription on the platform. Our team will review it and, if needed, coordinate with your prescribing doctor to verify the details.
                        </p>
                    </div>
                </Card>
            </div>
        </div>
    )
}