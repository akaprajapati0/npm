"use client";

import { useEffect, useRef, useState } from "react";
import { useRouter } from "next/navigation";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";

import GoBackBtn from "@/components/GoBackBtn";
import { ReusableForm } from "@/components/ReusableForm";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import UploadDocument from "@/components/UploadDocument";
import PreviewDialog from "@/components/PreviewDialog";
import ReusablePopup from "@/components/ui/ReusablePopup";

import { KYCSubmission, KYCSubmissionSchema } from "@/types/schema";
import { PopupType } from "@/types/componentTypes";

import { useUploadKyc } from "@/hooks/useKycMutation";
import { useComponentStore } from "@/store/componentStore";
import { kycStore } from "@/store/kycStore";
import ReadTextPopup from '@/components/ReadTextPopup';
import { EyeIcon, EyeOff, Loader } from 'lucide-react';

export default function KycUploadPage() {
    const router = useRouter();
    const inputRef = useRef<HTMLInputElement>(null);

    const kycMutation = useUploadKyc(() => setOpenPopup(true));
    const { kycType } = useComponentStore();
    const { front, back, clear } = kycStore();

    const [docValue, setDocValue] = useState("");
    const [showDoc, setShowDoc] = useState(false);

    const [docsType, setDocsType] = useState<"front" | "back" | "">("");
    const [uploadType, setUploadType] = useState<PopupType>("");

    const [previewUrl, setPreviewUrl] = useState<string | null>(null);
    const [isPreviewOpen, setIsPreviewOpen] = useState(false);
    const [openPopup, setOpenPopup] = useState(false);

    const docLength = kycType === "aadhaar" ? 12 : 8;
    const files = [];

    // Add focused state
    const [isFocused, setIsFocused] = useState(false);

    // The active index is simply the current input length (next empty box)
    const activeIndex = docValue.length < docLength ? docValue.length : docLength - 1;

    if (front && back) {
        files.push(front)
        files.push(back)
    }

    const form = useForm<KYCSubmission>({
        resolver: zodResolver(KYCSubmissionSchema),
        mode: "onChange",
        defaultValues: {
            documentType: kycType as "aadhaar" | "passport",
            documentNumber: "",
            files: []
        },
    });

    // --------- HANDLERS ---------
    useEffect(() => {
        if (front && back) {
            form.setValue("files", [front, back], { shouldValidate: true });
        } else {
            form.setValue("files", [], { shouldValidate: true });
        }
    }, [front, back, form]);


    const handleDocChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        let value = e.target.value.replace(/\s/g, "");

        value =
            kycType === "aadhaar"
                ? value.replace(/\D/g, "").slice(0, 12)
                : value.replace(/[^a-zA-Z0-9]/g, "").slice(0, 8);

        setDocValue(value);
        form.setValue("documentNumber", value, { shouldValidate: true });
    };

    const handleFront = () => {
        setDocsType("front");
        setUploadType("document");
    };

    const handleBack = () => {
        setDocsType("back");
        setUploadType("document");
    };

    const [fileType, setFileType] = useState("");

    const openPreview = (file: File | null) => {
        if (!file) return;
        setFileType(file.type);
        setPreviewUrl(URL.createObjectURL(file));
        setIsPreviewOpen(true);
    };

    const onSubmit = (values: KYCSubmission) => {
        kycMutation.mutate(values);
        clear()
    };

    const toggleShowDoc = () => {
        setShowDoc((prev) => !prev);
    };

    const isAadhaar = kycType === "aadhaar";

    // --------- UI --------

    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            {/* <GoBackBtn href="/caretaker/kyc" />

            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}
            <ReusableForm
                heading={kycType === "aadhaar" ? "Upload Your Aadhaar" : "Upload Your Passport"}
                subHeading={
                    kycType === "aadhaar"
                        ? "Enter your Aadhaar number and upload the front and back of your card for the identity verification."
                        : "Enter your passport number and upload the front and back for identity verification."
                }
                form={form}
                onSubmit={onSubmit}
            >
                {/* DOCUMENT NUMBER */}
                <div>
                    {/* Header */}
                    <div className="flex items-start justify-between">
                        <div>
                            <Label className="mb-1 font-medium">
                                {isAadhaar ? "Aadhaar Number" : "Passport Number"}
                            </Label>

                            <p className="mb-1 text-xs">
                                {isAadhaar
                                    ? "Enter your 12-digit Aadhaar number"
                                    : "Enter your 8-character passport number"}
                            </p>
                        </div>

                        <button
                            type="button"
                            onClick={toggleShowDoc}
                            aria-label={showDoc ? "Hide document number" : "Show document number"}
                            className="flex items-center gap-1 underline text-primary transition hover:opacity-80"
                        >
                            {showDoc ? <EyeOff size={18} /> : <EyeIcon size={18} />}
                        </button>
                    </div>

                    {/* Input Boxes */}
                    <div
                        className="relative flex gap-1 cursor-text"
                        onClick={() => inputRef.current?.focus()}
                    >
                        {Array.from({ length: docLength }).map((_, index) => {
                            const isActive = isFocused && index === activeIndex;

                            return (
                                <div
                                    key={index}
                                    className={`relative flex h-10 w-16 items-center justify-center rounded border text-3xl font-semibold transition-colors
          ${isActive ? "border-primary border-2" : "border-gray-300"}
        `}
                                >
                                    {/* Character or dot */}
                                    {docValue[index] && (showDoc ? docValue[index] : "•")}

                                    {/* Blinking cursor — shown only in active empty box */}
                                    {isActive && !docValue[index] && (
                                        <span className="absolute w-0.5 h-6 bg-primary animate-[blink_1s_step-end_infinite]" />
                                    )}
                                </div>
                            );
                        })}

                        <input
                            ref={inputRef}
                            type={showDoc ? "text" : "password"}
                            inputMode={isAadhaar ? "numeric" : "text"}
                            value={docValue}
                            onChange={handleDocChange}
                            onFocus={() => setIsFocused(true)}
                            onBlur={() => setIsFocused(false)}
                            className="absolute opacity-0 pointer-events-none"
                        />
                    </div>

                    {/* Error */}
                    {form.formState.errors.documentNumber && (
                        <p className="mt-1 text-xs text-red-500">
                            {form.formState.errors.documentNumber.message}
                        </p>
                    )}
                </div>

                {/* FRONT IMAGE */}
                <div>
                    <Label className="font-medium mb-1">
                        {kycType === "aadhaar" ? "Upload Aadhaar Front" : "Upload Passport Front"}
                    </Label>
                    <div className="flex items-center justify-between">

                        <p className="text-xs mb-1">{kycType === "aadhaar" ? "Upload front side of Aadhaar card (PDF or image)" : "Upload front side of Passport (PDF or image)"}</p>
                        <ReadTextPopup
                            text={
                                kycType === "aadhaar"
                                    ? "Your Aadhaar details are used solely for identity verification and handled securely in accordance with data protection laws."
                                    : "Your Passport details are used solely for identity verification and handled securely in accordance with data protection laws."
                            }
                            trigger={
                                <span className="flex items-center justify-center rounded-full mb-1 h-5 w-5 bg-yellow-300 text-black text-xs cursor-pointer">
                                    ?
                                </span>
                            }
                        />

                    </div>

                    <Button type="button" variant="ghost" className="w-full border" onClick={handleFront}>
                        {front?.name || "Click to Upload Front Side"}
                    </Button>

                    <div className="flex justify-between text-xs pt-2">
                        <Button variant="ghost" type="button" disabled={!front} onClick={() => openPreview(front)}>
                            Preview
                        </Button>
                        <Button variant="ghost" type="button" onClick={handleFront}>
                            Re-Upload
                        </Button>
                    </div>
                </div>

                {/* BACK IMAGE */}
                <div>
                    <Label className="font-medium mb-1">{kycType === "aadhaar" ? "Upload Aadhaar Back" : "Upload Passport Back"}</Label>
                    <div className="flex items-center justify-between">
                        <p className="text-xs mb-1">{kycType === "aadhaar" ? "Upload back side of Aadhaar card (PDF or image)" : "Upload back side of Passport (PDF or image)"}</p>
                        <ReadTextPopup
                            text={
                                kycType === "aadhaar"
                                    ? "Your Aadhaar details are used solely for identity verification and handled securely in accordance with data protection laws."
                                    : "Your Passport details are used solely for identity verification and handled securely in accordance with data protection laws."
                            }
                            className="ml-2"
                            trigger={
                                <span className="flex items-center justify-center rounded-full mb-1 h-5 w-5 bg-yellow-300 text-black text-xs cursor-pointer">
                                    ?
                                </span>
                            }
                        />

                    </div>

                    <Button type="button" variant="ghost" className="w-full border" onClick={handleBack}>
                        {back?.name || "Click to Upload Back Side"}
                    </Button>

                    <div className="flex justify-between text-xs pt-2">
                        <Button variant="ghost" type="button" disabled={!back} onClick={() => openPreview(back)}>
                            Preview
                        </Button>
                        <Button variant="ghost" type="button" onClick={handleBack}>
                            Re-Upload
                        </Button>
                    </div>
                </div>

                <Button
                    type="submit"
                    disabled={kycMutation.isPending || files.length == 0}
                    className="w-full mt-5 py-6 text-xl font-medium"
                >
                    {kycMutation.isPending ? <Loader /> : "Continue"}
                </Button>
            </ReusableForm>

            {/* </div> */}
            {/* Upload Modal */}
            <UploadDocument
                open={uploadType}
                onOpenChange={setUploadType}
                purpose="document"
                heading="Select Document"
                docsType={docsType}
            />

            {/* Preview Modal */}
            <PreviewDialog
                open={isPreviewOpen}
                onOpenChange={setIsPreviewOpen}
                previewUrl={previewUrl}
                fileType={fileType}
            />

            <ReusablePopup
                open={openPopup}
                onOpenChange={() => {
                    setOpenPopup(false);
                    router.push("/caretaker/request-docs");
                }}
                image="/successfull-popup.svg"
                title={kycType === "aadhaar" ? "Aadhaar Details Submitted Successfully" : "Passport Details Submitted Successfully"}
                description={
                    kycType === "aadhaar"
                        ? "Your Aadhaar information has been received and is currently under verification by our team. You may proceed to the next step."
                        : "Your passport information has been received and is currently under verification by our team. You may proceed to the next step."
                }
            />
        </div>
    );
}
