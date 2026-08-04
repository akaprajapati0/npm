"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";

import ReusablePopup from "@/components/ui/ReusablePopup";
import { Button } from "@/components/ui/button";

import { cdecCarouselItems } from "@/utils/carouselData";
// import ReadTextModal from "@/components/ReadTextModal"
// import { CDEC_CONFIG } from '@/lib/allReadableText';
import CarouselInfo from '@/components/CarouselInfo';
import { ReusableCard } from '@/components/ReusableCard';
import Link from 'next/link';
import ReadTextPopup from '@/components/ReadTextPopup';
import { useGetBankReceipt } from '@/hooks/useBankReciept';
import { useGetAdminDocument, useGetAdminDocumentByUser } from '@/hooks/useCdecMutation';
import { getImageUrl } from '@/lib/getImage';
import { isImage, isPdf } from '@/types/adminSchema';
import FilePreviewDialog from '@/components/admin-components/FilePreviewDialog';

export default function CDEC() {
    const router = useRouter();
    const { data, isPending } = useGetBankReceipt();
    const { data: downloadDocument, isPending: isDocumentPending } = useGetAdminDocumentByUser("user");

    const [preview, setPreview] = useState<{
        url: string;
        type: "image" | "pdf";
    } | null>(null);

    const fileUrl = getImageUrl(downloadDocument?.downloadDocument?.url);

    const handlePreview = () => {
        isImage(fileUrl) ? setPreview({
            url: fileUrl,
            type: "image",
        }) : setPreview({
            url: fileUrl,
            type: "pdf",
        })
    }

    const checkApproval = data?.status !== "approved";
    // --------- LOCAL STATE --------
    const [readScreen, setReadScreen] = useState<Boolean>(false);
    const [openPopup, setOpenPopup] = useState(false);

    // Use the keys of your config, or null when closed
    // const [activeTextModal, setActiveTextModal] = useState<keyof typeof CDEC_CONFIG | null>(null);

    // Helper to close modal
    // const handleClose = () => setActiveTextModal(null);

    // Get current data based on state
    // const currentData = activeTextModal ? CDEC_CONFIG[activeTextModal] : null;

    // SUCCESS POPUP HANDLER
    const handleOpenPopup = () => {
        setOpenPopup(false);
    };

    if (isDocumentPending && isPending) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-white md:bg-gray-100 flex justify-center items-center">
            {
                !readScreen ?
                    <ReusableCard title="Custom Duty Certificate" description="">
                        <div className="space-y-5">
                            <h3 className="font-semibold text-base">
                                What is Custom Duty Exemption Certificate (CDEC):
                            </h3>

                            <p className="">The Custom Duty Exemption Certificate (CDEC) is a mandatory regulatory document required for the import of life-saving medicines. This certificate enables exemption from customs duty.</p>

                            <p className="">
                                The CDEC must be completed and signed by both the patient and the prescribing doctor.
                            </p>

                            <h3 className="font-semibold text-base">
                                How to complete the CDEC:
                            </h3>

                            <ul className="list-disc pl-5 space-y-2 text-sm text-gray-800">
                                <li>
                                    The first page must include the patient’s details and signature
                                </li>
                                <li>
                                    The second page should be completed and signed by the prescribing doctor, along with their official stamp
                                </li>
                            </ul>

                            <p className="text-sm text-gray-800">
                                <span className="font-semibold text-base">Important:</span> <br />
                                Approval of the CDEC is required to meet regulatory compliance requirements. Without this document, customs clearance of the medicine in India cannot be completed.
                            </p>

                            <Link href="/caretaker/cdec/indication" className="text-primary">
                                View GST Exempted Indication by health ministry
                            </Link>
                        </div>

                        <div className="flex justify-end">
                            <Button className="mt-10" onClick={() => setReadScreen(true)}>Next</Button>
                        </div>
                    </ReusableCard>
                    :
                    <CarouselInfo
                        heading="CDEC Form Submission"
                        subHeading="Download, complete, and upload the CDEC form to move forward with your medicine import process."
                        items={cdecCarouselItems}
                    >
                        {!fileUrl && <p className="text-sm text-gray-400 mt-2 text-center">
                            Wait for downloadable document</p>}
                        <div className="relative w-full">
                            <Button disabled={checkApproval || !fileUrl} className="w-full mt-5 py-6 text-xl font-medium" onClick={handlePreview}>
                                Download CDEC Form
                            </Button>
                            <ReadTextPopup
                                text="An AD Code (Authorized Dealer Code) is a unique 14-digit numerical identifier issued by banks authorized by the Reserve Bank of India (RBI). It is essential for businesses engaging in international transactions, particularly for exports and imports."
                                trigger={
                                    <span className="absolute rounded-full h-6 w-6 bg-yellow-300 text-black -right-1 top-0">?</span>
                                }
                            />
                        </div>

                        <div className="relative w-full">
                            <Button disabled={checkApproval || !fileUrl} className="w-full mt-5 py-6 text-xl font-medium" onClick={() => router.replace("/caretaker/cdec/upload")}>
                                Upload CDEC Document
                            </Button>
                            <ReadTextPopup
                                text="An AD Code (Authorized Dealer Code) is a unique 14-digit numerical identifier issued by banks authorized by the Reserve Bank of India (RBI). It is essential for businesses engaging in international transactions, particularly for exports and imports."
                                trigger={
                                    <span className="absolute rounded-full h-6 w-6 bg-yellow-300 text-black -right-1 top-0">?</span>
                                }
                            />
                        </div>
                    </CarouselInfo>
            }

            {/* Download CDEC Popup */}
            {/* <ReusablePopup
                open={openPopup}
                onOpenChange={handleOpenPopup}
                image="/successfull-popup.svg"
                title="Downloaded Successfully"
                description="The CDEC has been downloaded successfully. Please ensure it is signed and stamped by the prescribing doctor."
            /> */}

            {/* Success Popup */}
            <ReusablePopup
                open={openPopup}
                onOpenChange={handleOpenPopup}
                image="/successfull-popup.svg"
                title="CDEC Form Uploaded Successfully"
                description="Thank you for submitting the completed CDEC form. Our team will now verify the document. You'll be notified once the verification is complete and your request."
            />
            <FilePreviewDialog
                preview={preview}
                onClose={() => setPreview(null)}
            />
            {/* The text read Modal */}
            {/* <ReadTextModal
                open={!!activeTextModal}
                onOpenChange={(open) => !open && handleClose()}
                title={currentData?.title || ""}
                markdown={currentData?.markdown || ""}
                fileName={currentData?.fileName || ""}
            // triggerLabel="Read Terms"
            /> */}
        </div>
    );
}
