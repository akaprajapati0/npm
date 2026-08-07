"use client";

import { Button } from '@/components/ui/button';
import { carouselItems, validPrescriptionGuide } from '@/utils/carouselData';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import CarouselInfo from '@/components/CarouselInfo';
import ReadModalInfo from '@/components/ReadModalInfo';
import { useGetProfile } from '@/hooks/useAuthMutations';
import { useGetPrescription, useGetPrescriptionCount } from '@/hooks/usePrescriptionMutation';
import GoBackBtn from '@/components/GoBackBtn';

// const items = [
//     {
//         title: "Why Quotation is Required?",
//         image: "/img2.svg",
//         description: "Understanding the importance of obtaining a quotation for your medicine requests ensures transparency and helps you make informed decisions about your healthcare needs."
//     }, {
//         title: "Why Quotation is Required?",
//         image: "/img2.svg",
//         description: "Understanding the importance of obtaining a quotation for your medicine requests ensures transparency and helps you make informed decisions about your healthcare needs."
//     }, {
//         title: "Why Quotation is Required?",
//         image: "/img2.svg",
//         description: "Understanding the importance of obtaining a quotation for your medicine requests ensures transparency and helps you make informed decisions about your healthcare needs."
//     }, {
//         title: "Why Quotation is Required?",
//         image: "/img2.svg",
//         description: "Understanding the importance of obtaining a quotation for your medicine requests ensures transparency and helps you make informed decisions about your healthcare needs."
//     }, {
//         title: "Why Quotation is Required?",
//         image: "/img2.svg",
//         description: "Understanding the importance of obtaining a quotation for your medicine requests ensures transparency and helps you make informed decisions about your healthcare needs."
//     },
// ];

export default function PrescriptionKycUpload() {
    const router = useRouter();
    const { data, isPending } = useGetProfile();
    const { data: presCount } = useGetPrescriptionCount();
    const { data: prescriptionData, isPending: isPresPending } = useGetPrescription();
    const [openModal, setOpenModal] = useState(false);

    if (isPending || isPresPending) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    const progress = data?.user?.progress;
    const progressStatus = progress === "prescription_uploaded";
    const hasPrescription = Boolean(prescriptionData);

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            {
                presCount > 0 &&
                <GoBackBtn href="/home" ariaLabel="back to home" />
            }
            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]">

                <CarouselInfo heading='Complete Your Prescription & KYC' subHeading='Add your prescription and complete KYC to help us validate your treatment.' items={carouselItems}>

                    <Button className="w-full mt-5 py-6 text-xl font-medium" variant={progressStatus ? "secondary" : "default"} disabled={progressStatus} onClick={() => router.push("/caretaker/prescription")}>
                        Prescription
                    </Button>

                    <div className="text-xs flex justify-between w-full px-2">
                        <button className="underline cursor-pointer" onClick={() => setOpenModal(true)}>Valid Prescription Format</button>
                        {/* <button className="underline cursor-pointer" onClick={() => setActiveTextModal('Required_pres')}>Why Prescription is Required</button> */}
                    </div>

                    <Button
                        className="w-full mt-5 py-6 text-xl font-medium"
                        variant={!progressStatus ? "secondary" : "default"}
                        disabled={!progressStatus || !hasPrescription}
                        onClick={() => router.push("/caretaker/kyc")}
                    >
                        KYC
                    </Button>
                </CarouselInfo>

                {/* The text read Modal */}
                {/* <ReadTextModal
                open={!!activeTextModal} // Converts the key/null to true/false
                onOpenChange={(open) => !open && setActiveTextModal(null)}
                title={currentData?.title || ""}
                markdown={currentData?.markdown || ""}
                fileName={currentData?.fileName || ""}
                triggerLabel="Read Terms"
            /> */}


                <ReadModalInfo
                    open={openModal}
                    onOpenChange={setOpenModal}
                    heading="Valid prescription guide"
                    items={validPrescriptionGuide}
                />

            </div>
        </div>
    );
}
