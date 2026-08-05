"use client";

import { useState } from "react";
import GoBackBtn from "@/components/GoBackBtn";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import Image from "next/image";

export default function Track() {
    const [trackingNumber, setTrackingNumber] =
        useState("");

    const handleTrack = () => {
        const trimmedTrackingNumber = trackingNumber.trim();
        if (!trimmedTrackingNumber) return;

        window.location.href =
            "https://trackorder.ikrispharmanetwork.com/showData";
    };

    return (
        <div className="min-h-screen bg-[#F8F1E7]">
            <GoBackBtn
                href="/home"
                ariaLabel="Back to dashboard"
            />

            <div className="flex items-center justify-center flex-col pb-5">
                <div className="w-full max-w-md mx-auto">
                    <div className="flex justify-center">
                        <Image
                            src="/doorstep.svg"
                            alt="Parcel delivery"
                            width={500}
                            height={500}
                            priority
                            className="w-full object-contain rounded-md"
                        />
                    </div>

                    <div className="space-y-6 px-2">
                        <div className="space-y-2">
                            <h1 className="text-2xl md:text-3xl font-bold leading-tight max-w-64">
                                Your Order Is On Its Way
                                to Your Doorstep 🚚
                            </h1>

                            <p className="text-muted-foreground">
                                Track your shipment in
                                real-time and stay updated
                                until final delivery
                                confirmation.
                            </p>
                        </div>

                        <div className="w-full flex flex-col items-center gap-4">
                            <Input
                                placeholder="Enter Tracking Number"
                                value={trackingNumber}
                                onChange={(e) =>
                                    setTrackingNumber(
                                        e.target.value
                                    )
                                }
                                onKeyDown={(e) => {
                                    if (e.key === "Enter") {
                                        handleTrack();
                                    }
                                }}
                                className="bg-white py-2 text-xl"
                            />

                            <Button
                                onClick={handleTrack}
                                disabled={!trackingNumber.trim()}
                                className="w-full py-6 text-xl font-medium"
                            >
                                Track Now
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}


// "use client";

// import { useState, useEffect } from "react";
// import GoBackBtn from '@/components/GoBackBtn';
// import { Button } from '@/components/ui/button';
// import { Input } from '@/components/ui/input';
// import Image from 'next/image';
// import { useGetOrderDetails } from '@/hooks/useOrderMutation';
// import { useRouter } from 'next/navigation';

// export default function Track() {
//     const router = useRouter();
//     const [inputValue, setInputValue] = useState("");
//     const [searchOrder, setSearchOrder] = useState("");

//     const { data: order, isLoading, isSuccess, isError, error } =
//         useGetOrderDetails(searchOrder);

//     const handleTrack = () => {
//         if (!inputValue.trim()) return;
//         setSearchOrder(inputValue);
//     };

//     // Move navigation into useEffect
//     useEffect(() => {
//         if (isSuccess && order?.orderNumber) {
//             router.replace(`/home/track-order/${order.orderNumber}`);
//         }
//     }, [isSuccess, order, router]);

//     return (
//         <div className="min-h-screen bg-[#F8F1E7]">
//             <GoBackBtn href="/home" ariaLabel="Back to dashboard" />

//             <div className="flex items-center justify-center flex-col pb-5">
//                 <div className="w-full max-w-md mx-auto">

//                     <div className="flex justify-center">
//                         <Image
//                             src="/doorstep.svg"
//                             alt="Parcel delivery"
//                             width={500}
//                             height={500}
//                             priority
//                             className="w-full object-contain rounded-md"
//                         />
//                     </div>

//                     <div className="space-y-6 px-2">
//                         <div className="space-y-2">
//                             <h1 className="text-2xl md:text-3xl font-bold leading-tight max-w-64">
//                                 Your Order Is On Its Way to Your Doorstep 🚚
//                             </h1>
//                             <p className="text-muted-foreground">
//                                 Track your shipment in real-time and stay updated until final delivery confirmation.
//                             </p>
//                         </div>

//                         <div className="w-full flex flex-col items-center gap-4">
//                             <Input
//                                 placeholder="Enter Tracking Number"
//                                 value={inputValue}
//                                 onChange={(e) => setInputValue(e.target.value)}
//                                 className='bg-white'
//                             />

//                             <Button
//                                 onClick={handleTrack}
//                                 disabled={isLoading || !inputValue}
//                                 className="w-full"
//                             >
//                                 {isLoading ? "Tracking..." : "Track Now"}
//                             </Button>
//                         </div>

//                         {isLoading && (
//                             <p className="text-center text-muted-foreground">
//                                 Fetching order details...
//                             </p>
//                         )}

//                         {isError && (
//                             <p className="text-center text-red-500">
//                                 {(error as any)?.response?.data?.message ||
//                                     "Order not found"}
//                             </p>
//                         )}
//                     </div>
//                 </div>
//             </div>
//         </div>
//     );
// }
{/* <Link href="/track/order" className="w-full bg-primary text-white text-center py-2 rounded-md">
    Track Now
</Link> */}
