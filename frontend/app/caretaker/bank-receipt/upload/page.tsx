"use client";

import { useCallback, useEffect, useMemo, useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { useRouter } from "next/navigation";
import Image from "next/image";
import Link from "next/link";
import { File as FileIcon, Loader } from "lucide-react";

import { ReusableForm } from "@/components/ReusableForm";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import UploadDocument from "@/components/UploadDocument";
import ReadTextModal from "@/components/ReadTextModal";
import ReadTextPopup from "@/components/ReadTextPopup";
import ReusablePopup from "@/components/ui/ReusablePopup";
import PreviewDialog from "@/components/PreviewDialog";

import { useUploadBankReceipt } from "@/hooks/useBankReciept";
import { useGetdocs } from "@/hooks/useDocRequest";
import { uploadDocumentStore } from "@/store/uploadDocumentStore";
import { PopupType } from "@/types/componentTypes";
import { BankReceiptSchema, BankRecieptSubmission } from "@/types/schema";
import { BANK_RECEIPT_CONFIG } from "@/lib/allReadableText";

/* ------------------ CONSTANTS ------------------ */

const REQUIRED_DOC_TYPES = ["medicine_quotation", "proforma_invoice", "import_license"] as const;
const APPROVED_STATUS = "Approved";
const MAX_FILES = 12;

export default function UploadBankReceipt() {
    const router = useRouter();
    const [openPopup, setOpenPopup] = useState(false);
    const [uploadType, setUploadType] = useState<PopupType>("");
    const [activeModal, setActiveModal] = useState<keyof typeof BANK_RECEIPT_CONFIG | null>(null);
    const [preview, setPreview] = useState<{ url: string; type: string } | null>(null);

    // NOTE: this is 3 separate network requests for what's conceptually one
    // check ("are all required docs approved?"). If a combined backend
    // endpoint exists (or gets added) returning all three statuses in one
    // response, swap these three hooks for one — same optimization we
    // discussed for getDocumentCount.
    const quotationDoc = useGetdocs("medicine_quotation");
    const proformaDoc = useGetdocs("proforma_invoice");
    const licenseDoc = useGetdocs("import_license");

    const docsByType = {
        medicine_quotation: quotationDoc.data,
        proforma_invoice: proformaDoc.data,
        import_license: licenseDoc.data,
    };

    const isDocsLoading =
        quotationDoc.isPending || proformaDoc.isPending || licenseDoc.isPending;

    // Scalable: adding a 4th required doc type only means adding it to
    // REQUIRED_DOC_TYPES and the docsByType map above — this check doesn't change.
    const isFullyApproved = REQUIRED_DOC_TYPES.every(
        (type) => docsByType[type]?.status === APPROVED_STATUS
    );

    const { files, removeFile, clearFiles } = uploadDocumentStore();

    const { isPending: isUploading, mutate } = useUploadBankReceipt({
        onSuccess: () => {
            clearFiles();
            setOpenPopup(true);
        },
    });

    const currentData = activeModal ? BANK_RECEIPT_CONFIG[activeModal] : null;

    const form = useForm<BankRecieptSubmission>({
        resolver: zodResolver(BankReceiptSchema),
        mode: "onChange",
        defaultValues: {
            documentNumber: "",
            files: [],
        },
    });

    useEffect(() => {
        form.setValue("files", files, { shouldValidate: true });
    }, [files, form]);

    // eslint-disable-next-line react-hooks/preserve-manual-memoization
    const fileUrls = useMemo(() => files.map((file) => URL.createObjectURL(file)), [files]);

    useEffect(() => {
        return () => fileUrls.forEach((url) => URL.revokeObjectURL(url));
    }, [fileUrls]);

    const onSubmit = useCallback(
        (values: BankRecieptSubmission) => {
            mutate(values);
        },
        [mutate]
    );

    const handlePopupClose = (open: boolean) => {
        setOpenPopup(open);
        if (!open) {
            router.replace("/caretaker/cdec");
        }
    };

    if (isDocsLoading) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen flex items-center justify-center md:py-5 bg-white md:bg-gray-100">
            <ReusableForm
                heading="Upload Transaction Proof"
                subHeading="Upload your bank transaction proof to confirm payment and move forward with your order."
                form={form}
                onSubmit={onSubmit}
            >
                <div className="space-y-8">
                    <div className="space-y-2">
                        <div className="flex gap-2 items-center">
                            <Label>Bank AD Code</Label>
                            <ReadTextPopup
                                text="An AD Code (Authorized Dealer Code) is a unique 14-digit numerical identifier issued by banks authorized by the Reserve Bank of India (RBI). It is essential for businesses engaging in international transactions, particularly for exports and imports."
                                trigger={
                                    <span className="text-xs bg-yellow-300 rounded-full px-1.5 py-0.5 cursor-pointer">?</span>
                                }
                            />
                        </div>
                        <Input
                            maxLength={14}
                            placeholder="Enter 14-digit Authorized Dealer Code"
                            {...form.register("documentNumber")}
                            allowPattern={/[^A-Za-z0-9]/g}
                        />
                    </div>

                    <div>
                        <h2 className="font-black">{files.length} Image Uploaded</h2>
                        <p className="text-xs">
                            You can upload up to {MAX_FILES} images for your payment proof submission.
                        </p>
                    </div>

                    {form.formState.errors.files && (
                        <p className="text-red-500 text-sm">
                            {form.formState.errors.files.message}
                        </p>
                    )}

                    <div className="grid grid-cols-3 gap-4">
                        {files.map((file, index) => (
                            <div
                                key={index}
                                role="button"
                                tabIndex={0}
                                className="relative h-24 w-24 rounded-md border cursor-pointer overflow-hidden"
                                onClick={() => setPreview({ url: fileUrls[index], type: file.type })}
                                onKeyDown={(event) => {
                                    if (event.key === "Enter" || event.key === " ") {
                                        event.preventDefault();
                                        setPreview({ url: fileUrls[index], type: file.type });
                                    }
                                }}
                            >
                                {file.type === "application/pdf" ? (
                                    <div className="flex flex-col items-center justify-center h-full w-full bg-red-50 rounded-md gap-1">
                                        <FileIcon />
                                        <span className="text-xs text-primary font-medium truncate w-20 text-center px-1">
                                            {file.name}
                                        </span>
                                    </div>
                                ) : (
                                    <Image
                                        src={fileUrls[index]}
                                        alt={`Prescription ${index + 1}`}
                                        fill
                                        className="object-cover rounded-md"
                                    />
                                )}

                                <button
                                    type="button"
                                    onClick={(event) => {
                                        event.stopPropagation();
                                        removeFile(index);
                                    }}
                                    className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center cursor-pointer"
                                >
                                    ×
                                </button>
                            </div>
                        ))}

                        {Array.from({ length: MAX_FILES - files.length }).map((_, index) => (
                            <div
                                key={`placeholder-${index}`}
                                className={`flex h-24 w-24 items-center justify-center rounded-md border-2 border-dotted border-primary/70 text-primary text-2xl cursor-pointer ${index === 0 ? "opacity-100" : "opacity-30 pointer-events-none"
                                    }`}
                                onClick={() => index === 0 && setUploadType("document")}
                            >
                                +
                            </div>
                        ))}
                    </div>

                    <p className="text-gray-500">
                        {files.length !== 0
                            ? "All uploads are encrypted and accessible only to our back end team. Transaction proof submitted is carefully verified before your order is processed."
                            : "Your documents are uploaded only to verify your request and complete mandatory checks. We ensure your data is safe, private, and never shared without authorization."}
                    </p>

                    <Link
                        href="#"
                        className="text-purple-600 underline"
                        onClick={(e) => {
                            e.preventDefault();
                            setActiveModal("WHAT_IS_SWIFT");
                        }}
                    >
                        What is Swift Copy / Bank Receipt?
                    </Link>

                    <Button
                        type="submit"
                        className="w-full mt-5 py-6 text-xl font-medium"
                        disabled={isUploading || !isFullyApproved}
                    >
                        {isUploading ? <Loader className="animate-spin" /> : "Continue to Next"}
                    </Button>
                </div>
            </ReusableForm>

            <UploadDocument open={uploadType} onOpenChange={setUploadType} purpose="document" />

            <ReusablePopup
                open={openPopup}
                onOpenChange={handlePopupClose}
                image="/successfull-popup.svg"
                title="Transaction Details Received"
                description="Your transaction details have been submitted successfully. Our team will review and update you shortly."
            />

            <ReadTextModal
                open={!!activeModal}
                onOpenChange={(open) => !open && setActiveModal(null)}
                title={currentData?.title || ""}
                markdown={currentData?.markdown || ""}
                fileName={currentData?.fileName || ""}
            />

            <PreviewDialog
                open={!!preview}
                onOpenChange={(open) => !open && setPreview(null)}
                previewUrl={preview?.url || null}
                fileType={preview?.type}
            />
        </div>
    );
}

{/* <div className="grid grid-cols-3 gap-4">
    {files.map((file, index) => (
        <div
            key={`${file.name}-${file.lastModified}`}
            className="relative h-24 w-24 rounded-md border"
        >
            <Image
                src={fileUrls[index]}
                alt={`Receipt ${index + 1}`}
                fill
                className="object-cover rounded-md"
            />

            <button
                type="button"
                onClick={() => removeFile(index)}
                className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5"
            >
                ×
            </button>
        </div>
    ))}

    {files.length < 12 && (
        <div
            className="flex h-24 w-24 items-center justify-center rounded-md border border-dotted border-primary text-primary text-2xl cursor-pointer"
            onClick={() => setUploadType("document")}
        >
            +
        </div>
    )}
</div> */}
