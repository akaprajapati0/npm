"use client";

import { useState } from 'react';
import Image from 'next/image';
import GoBackBtn from '@/components/GoBackBtn';
import { ReusableCard } from '@/components/ReusableCard';
import { Button } from '@/components/ui/button';
import UploadDocument from '@/components/UploadDocument';
import { PopupType } from '@/types/componentTypes';
import ReadTextModal from '@/components/ReadTextModal';
import { KYC_CONFIG } from '@/lib/allReadableText';
import { useGetPrescription } from '@/hooks/usePrescriptionMutation';


export default function KYC() {
    const { data, isPending } = useGetPrescription();
    const [uploadType, setUploadType] = useState<PopupType>("");
    const handleKyc = () => setUploadType("kyc");
    const [activeTextModal, setActiveTextModal] = useState(false);

    if (isPending) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    const hasPrescription = Boolean(data);

    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            {/* <GoBackBtn href="/caretaker/upload-document" ariaLabel="back kyc" />
            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}
            <ReusableCard
                title='Complete Your KYC'
                description='Please upload a valid ID proof to complete verification.
All documents are carefully reviewed to ensure 
accuracy and compliance.'
            >
                <div className="w-full space-y-5">
                    <Image
                        src="/upload-prescription.svg"
                        alt="user image"
                        // fill
                        width={200}
                        height={100}
                        priority
                        className="object-cover mx-auto"
                    />

                    <Button className="w-full mt-5 py-6 text-xl font-medium" disabled={!hasPrescription} onClick={handleKyc}>Complete KYC Upload</Button>


                    <div className="space-y-2">
                        <span className="">Note :</span>
                        <p className="text-gray-500">
                            Your documents are collected solely for verification and regulatory compliance. All information is kept secure and confidential and never shared without consent.
                        </p>
                        {/* <p className="text-gray-500">
                                This application does not provide medical advice, diagnosis, or treatment.All medical decisions must be made by a licensed healthcare professional.The platform supports documentation and coordination for regulatory purposes only.
                            </p> */}
                    </div>

                    <Button variant="link" onClick={() => setActiveTextModal(true)} className='p-0'>
                        Why Kyc?
                    </Button>
                </div>
            </ReusableCard>
            {/* </div> */}

            <UploadDocument
                open={uploadType}
                onOpenChange={setUploadType}
                purpose="kyc"
                heading="Complete KYC Upload"
            />

            <ReadTextModal
                open={!!activeTextModal}
                onOpenChange={(open) => !open && setActiveTextModal(false)}
                title={KYC_CONFIG['WHY_KYC'].title || ""}
                markdown={KYC_CONFIG['WHY_KYC'].markdown || ""}
                fileName={KYC_CONFIG['WHY_KYC'].fileName || ""}
                triggerLabel="Read Terms"
            />
        </div>
    )
}
