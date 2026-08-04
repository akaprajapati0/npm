import GoBackBtn from '@/components/GoBackBtn';
import { Card } from '@/components/ui/card';

export default function AdditionalChanges() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home/help-support" ariaLabel="go back home" />

            <div className="flex flex-col min-h-[calc(100vh-80px)] md:items-center md:justify-center">
                <Card className="w-full max-w-md mx-auto border-none shadow-none flex flex-col justify-between grow p-4">
                    {/* Top Section */}
                    <div className="space-y-5">
                        <h1 className="font-bold text-lg">Are there any additional charges?</h1>
                        <p className="">There are no hidden charges applied to your order. All applicable costs will be clearly displayed on the payment summary page before you proceed. We facilitate order fulfilment through registered manufacturers and stockists across the world. Please note that cash on delivery is not available. Payments must be made online before the order is processed and prepared for shipment.
                        </p>
                    </div>
                </Card>
            </div>
        </div>
    )
}