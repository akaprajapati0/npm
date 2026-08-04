"use client";

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Image from 'next/image';
import GoBackBtn from '@/components/GoBackBtn';
import { ReusableCard } from '@/components/ReusableCard';
import { Button } from '@/components/ui/button';
import UploadDocument from '@/components/UploadDocument';
import { uploadDocumentStore } from '@/store/uploadDocumentStore';
import { PopupType } from '@/types/componentTypes';
import ReadTextModal from '@/components/ReadTextModal';
import { Prescription_CONFIG } from '@/lib/allReadableText';

export default function Prescription() {
    const router = useRouter()
    const { files } = uploadDocumentStore();
    const [uploadType, setUploadType] = useState<PopupType>("");
    const [activeTextModal, setActiveTextModal] = useState(false);

    const handlePrescription = () => {
        setUploadType("document");
    };

    setTimeout(() => {
        if (files.length > 0) router.replace("/caretaker/prescription/upload")
        return
    }, 500);


    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            {/* <GoBackBtn href="/home" ariaLabel="back prescribed medicine" />
            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}

            <ReusableCard
                title='Upload Your Prescription'
                description='Please upload your valid prescription to continue smoothly with your medicine request process.'
            >
                <div className="w-full space-y-5">
                    <Image
                        src="/upload-prescription.svg"
                        alt="user image"
                        // fill
                        width={200}
                        height={200}
                        priority
                        className="object-cover mx-auto"
                    />

                    <Button className="w-full mt-5 py-6 text-xl font-medium" onClick={handlePrescription}>Proceed With Upload</Button>

                    <div className="space-y-2">
                        <span className="">Note :</span>
                        <p className="text-gray-500">
                            Your documents are collected solely for verification and regulatory compliance. All information is kept secure and confidential and never shared without consent. This platform does not provide medical advice; a licensed healthcare professional must make all treatment decisions.

                        </p>
                    </div>

                    <Button variant="link" onClick={() => setActiveTextModal(true)} className='p-0'>
                        Why Prescription?
                    </Button>
                </div>
            </ReusableCard>

            <UploadDocument
                open={uploadType}
                onOpenChange={setUploadType}
                purpose="document"
                heading="Upload Prescription"
            />

            <ReadTextModal
                open={!!activeTextModal}
                onOpenChange={(open) => !open && setActiveTextModal(false)}
                title={Prescription_CONFIG['Required_pres'].title || ""}
                markdown={Prescription_CONFIG['Required_pres'].markdown || ""}
                fileName={Prescription_CONFIG['Required_pres'].fileName || ""}
                triggerLabel="Read Terms"
            />
            {/* </div> */}
        </div>
    )
}
