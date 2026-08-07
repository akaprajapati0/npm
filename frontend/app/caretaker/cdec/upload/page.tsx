"use client";

import { useEffect, useState } from 'react';
import Image from 'next/image';
import { ReusableCard } from '@/components/ReusableCard';
import { Button } from '@/components/ui/button';
import UploadDocument from '@/components/UploadDocument';
import ReadTextModal from "@/components/ReadTextModal"
import { PopupType } from '@/types/componentTypes';
import { CDEC_CONFIG } from '@/lib/allReadableText';
import { useRouter } from 'next/navigation';
import { uploadDocumentStore } from '@/store/uploadDocumentStore';
import GoBackBtn from '@/components/GoBackBtn';

export default function UploadCdec() {
    const router = useRouter();
    const { files, clearFiles } = uploadDocumentStore();

    useEffect(() => {
        clearFiles()
    }, [])

    const [uploadType, setUploadType] = useState<PopupType>("");
    const [activeTextModal, setActiveTextModal] = useState<keyof typeof CDEC_CONFIG | null>(null);

    useEffect(() => {
        if (files.length === 0) return;

        const timer = setTimeout(() => {
            router.push("/caretaker/cdec/upload/document");
        }, 500);

        return () => clearTimeout(timer);
    }, [files.length, router]);

    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            {/* <GoBackBtn href='/caretaker/cdec' ariaLabel='back cdec' />

            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}

            <ReusableCard
                title='Upload CDEC Form'
                description='Please upload the signed CDEC form by both patient and prescribing doctor.'
            >
                <div className="w-full space-y-5">
                    <Image
                        src="/upload-prescription.svg"
                        alt="user image"
                        // fill
                        width={300}
                        height={200}
                        priority
                        className="object-cover mx-auto"
                    />

                    <Button className="w-full py-6 text-xl font-medium" onClick={() => setUploadType("document")}>Upload CDEC Form</Button>

                    <p className="text-gray-500">
                        <span className="text-black">Note:</span> <br /> Your documents are collected solely for verification and regulatory compliance. All information is kept secure and confidential and never shared without consent.
                    </p>

                    <span onClick={() => setActiveTextModal("WHY_CDEC")} className='text-primary underline cursor-pointer'>Why CDEC is Required?</span>
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
                onOpenChange={(open) => !open && setActiveTextModal(null)}
                title={CDEC_CONFIG.WHY_CDEC.title || ""}
                markdown={CDEC_CONFIG.WHY_CDEC.markdown || ""}
                fileName={CDEC_CONFIG.WHY_CDEC.fileName || ""}
            />
            {/* </div> */}
        </div>
    )
}
