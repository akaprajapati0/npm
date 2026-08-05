"use client";

import { ReusableCard } from '@/components/ReusableCard';
import { Button } from '@/components/ui/button';
import ReusablePopup from '@/components/ui/ReusablePopup';
import UploadDocument from '@/components/UploadDocument';
import PreviewDialog from '@/components/PreviewDialog';
import { useUploadCdec } from '@/hooks/useCdecMutation';
import { uploadDocumentStore } from '@/store/uploadDocumentStore';
import { PopupType } from '@/types/componentTypes';
import { File, Loader } from 'lucide-react';
import Image from 'next/image';
import { useRouter } from 'next/navigation';
import { useEffect, useMemo, useState } from 'react';

export default function CdecDocument() {
    const router = useRouter();
    const { isPending, mutate, isSuccess } = useUploadCdec()

    const { files, removeFile, clearFiles } = uploadDocumentStore();
    const [uploadType, setUploadType] = useState<PopupType>("");
    const [successPopup, setSuccessPopup] = useState<boolean>(false);
    const [preview, setPreview] = useState<{ url: string; type: string } | null>(null);
    // eslint-disable-next-line react-hooks/preserve-manual-memoization
    const fileUrls = useMemo(() => files.map((file) => URL.createObjectURL(file)), [files]);

    useEffect(() => {
        return () => fileUrls.forEach((url) => URL.revokeObjectURL(url));
    }, [fileUrls]);

    const onSubmit = () => {
        mutate(files)
        setSuccessPopup(true)
        if (isSuccess)
            clearFiles()
    }

    const handleSuccessPopup = () => {
        setSuccessPopup(false)
        router.replace("/caretaker/address")
    }


    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            {/* <GoBackBtn href='/caretaker/cdec/upload' />
            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}
            <ReusableCard
                title={`${files.length} Image Uploaded`}
                description="You may upload up to 12 images for CDEC form submission."
            >
                <div className="space-y-5">
                    {/* Image Grid */}
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
                                        <File />
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

                        {/* Add More Boxes — fill remaining slots up to 12 */}
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
                    </p>

                    <Button
                        disabled={isPending || files.length == 0}
                        className="w-full mt-5 py-6 text-xl font-medium"
                        onClick={onSubmit}
                    >
                        {isPending ? <Loader /> : "Submit"}
                    </Button>
                </div>
            </ReusableCard>
            {/* </div> */}

            <UploadDocument
                open={uploadType}
                onOpenChange={setUploadType}
                purpose="document"
                heading="Upload Prescription"
            />

            {/* Success Popup */}
            <ReusablePopup
                open={successPopup}
                onOpenChange={handleSuccessPopup}
                image="/successfull-popup.svg"
                title="Uploaded Successfully"
                description="Your CDEC has been uploaded successfully and is under verification. Our team will review it and update you shortly."
            />

            <PreviewDialog
                open={!!preview}
                onOpenChange={(open) => !open && setPreview(null)}
                previewUrl={preview?.url || null}
                fileType={preview?.type}
            />
        </div>
    )
}
