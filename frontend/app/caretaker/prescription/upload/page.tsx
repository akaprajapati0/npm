"use client";

import { useEffect, useMemo, useState } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { File, Loader } from "lucide-react";
import { ReusableCard } from "@/components/ReusableCard";
import UploadDocument from "@/components/UploadDocument";
import { Button } from "@/components/ui/button";
import ReusablePopup from "@/components/ui/ReusablePopup";
import ReadTextModal from "@/components/ReadTextModal";
import PreviewDialog from "@/components/PreviewDialog";
import { useUploadPrescription } from "@/hooks/usePrescriptionMutation";
import { Prescription_CONFIG } from "@/lib/allReadableText";
import { uploadDocumentStore } from "@/store/uploadDocumentStore";
import { useComponentStore } from "@/store/componentStore";
import { PopupType } from "@/types/componentTypes";

type PrescriptionFileTileProps = {
    file: File;
    index: number;
    onRemove: (index: number) => void;
    onPreview: (preview: { url: string; type: string }) => void;
};

function PrescriptionFileTile({
    file,
    index,
    onRemove,
    onPreview,
}: PrescriptionFileTileProps) {
    const fileUrl = useMemo(() => URL.createObjectURL(file), [file]);

    useEffect(() => {
        return () => URL.revokeObjectURL(fileUrl);
    }, [fileUrl]);

    const handlePreview = () => onPreview({ url: fileUrl, type: file.type });

    return (
        <div
            role="button"
            tabIndex={0}
            className="relative h-24 w-24 rounded-md border cursor-pointer overflow-hidden"
            onClick={handlePreview}
            onKeyDown={(event) => {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    handlePreview();
                }
            }}
        >
            {file.type === "application/pdf" ? (
                <div className="flex flex-col items-center justify-center h-full w-full bg-red-50 rounded-md gap-1">
                    <File />
                    <span className="text-xs text-primary font-medium truncate w-20 text-center px-1">
                        {file.name}
                    </span>
                </div>
            ) : (
                <Image
                    src={fileUrl}
                    alt={`Prescription ${index + 1}`}
                    fill
                    className="object-cover rounded-md"
                />
            )}

            <button
                onClick={(event) => {
                    event.stopPropagation();
                    onRemove(index);
                }}
                className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center cursor-pointer"
            >
                x
            </button>
        </div>
    );
}

export default function UploadPrescription() {
    const router = useRouter();
    const { setIsPrescriptionUploaded } = useComponentStore();
    const { files, removeFile, clearFiles } = uploadDocumentStore();
    const [uploadType, setUploadType] = useState<PopupType>("");
    const [openPopup, setOpenPopup] = useState(false);
    const [activeTextModal, setActiveTextModal] = useState(false);
    const [preview, setPreview] = useState<{ url: string; type: string } | null>(null);
    const { isPending, mutate, isSuccess } = useUploadPrescription(() => {
        setOpenPopup(true);
        setIsPrescriptionUploaded(true);
    });

    const onSubmit = () => {
        mutate(files);
        if (isSuccess) clearFiles();
    };

    const handlePopupClose = (open: boolean) => {
        setOpenPopup(open);
        if (!open) {
            router.push("/caretaker/upload-document");
        }
        clearFiles();
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            <ReusableCard
                title={`${files.length} Prescription attached`}
                description="You can upload up to twelve images at once for your prescription submission."
            >
                <div className="space-y-5">
                    <div className="grid grid-cols-3 gap-4">
                        {files.map((file, index) => (
                            <PrescriptionFileTile
                                key={index}
                                file={file}
                                index={index}
                                onRemove={removeFile}
                                onPreview={setPreview}
                            />
                        ))}

                        {Array.from({ length: 12 - files.length }).map((_, index) => (
                            <div
                                key={`placeholder-${index}`}
                                className={`flex h-24 w-24 items-center justify-center rounded-md border-2 border-dotted border-primary/70 text-primary text-2xl cursor-pointer ${index === 0 ? "opacity-100" : "opacity-30 pointer-events-none"}`}
                                onClick={() => index === 0 && setUploadType("document")}
                            >
                                +
                            </div>
                        ))}
                    </div>

                    <p className="text-gray-500 text-sm">
                        All uploads are encrypted and accessible only to our backend team.
                        Every prescription you submit is carefully verified before your order is processed.
                    </p>

                    <Button
                        disabled={isPending || files.length === 0}
                        className="w-full mt-5 py-6 text-xl font-medium"
                        onClick={onSubmit}
                    >
                        {isPending ? <Loader /> : "Continue"}
                    </Button>
                </div>
            </ReusableCard>

            <UploadDocument
                open={uploadType}
                onOpenChange={setUploadType}
                purpose="document"
                heading="Upload Prescription"
            />

            <ReusablePopup
                open={openPopup}
                onOpenChange={handlePopupClose}
                image="/successfull-popup.svg"
                title="Uploaded Successfully"
                description="Thank you for uploading your prescription. Please complete your KYC verification by submitting a valid ID proof to proceed."
            />

            <ReadTextModal
                open={activeTextModal}
                onOpenChange={(open) => !open && setActiveTextModal(false)}
                title={Prescription_CONFIG.Valid_pres.title || ""}
                markdown={Prescription_CONFIG.Valid_pres.markdown || ""}
                fileName={Prescription_CONFIG.Valid_pres.fileName || ""}
                triggerLabel="Read Terms"
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
