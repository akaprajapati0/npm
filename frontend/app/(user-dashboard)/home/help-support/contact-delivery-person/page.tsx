import GoBackBtn from '@/components/GoBackBtn';
import { Card } from '@/components/ui/card';

export default function Page() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home/help-support" ariaLabel="go back home" />

            <div className="flex flex-col min-h-[calc(100vh-80px)] md:items-center md:justify-center">
                <Card className="w-full max-w-md mx-auto border-none shadow-none flex flex-col justify-between grow p-4">
                    {/* Top Section */}
                    <div className="space-y-5">
                        <h1 className="font-bold text-lg">Can I Contact Delivery Person?</h1>
                        <p className="">To maintain safety, privacy, and regulatory compliance, direct communication with delivery personnel is not permitted. This ensures a secure and controlled delivery process, especially for sensitive medicines handled under the Named Patient Program.
                            <br />
                            All updates, including shipment progress and delivery status, are shared through the platform. For any assistance or specific concerns, our <span className="text-primary">support team is available to help.</span>
                        </p>
                    </div>
                </Card>
            </div>
        </div>
    )
}