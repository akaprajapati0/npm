"use client";

import { Sheet, SheetContent } from "@/components/ui/sheet";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/components/ui/dialog";
import { VisuallyHidden } from "@radix-ui/react-visually-hidden";
import { Camera, ChevronRight, IdCard, IdCardLanyard, Images } from "lucide-react";
import { useIsMobile } from "@/hooks/use-mobile";
import { useRouter } from "next/navigation";
import { ImagePickerProps } from "@/types/componentTypes";
import { errorToast } from "@/utils/toast";
import { useComponentStore } from "@/store/componentStore";
import { uploadDocumentStore } from '@/store/uploadDocumentStore';
import { kycStore } from '@/store/kycStore';

const MAX_FILES = 12;
const MAX_FILE_SIZE_MB = 5;
const MAX_FILE_SIZE_BYTES = MAX_FILE_SIZE_MB * 1024 * 1024;

const ALLOWED_TYPES = [
    "image/jpeg",
    "image/jpg",
    "image/png",
    "image/webp",
    "application/pdf",
];

const ACCEPT_STRING = ALLOWED_TYPES.join(",");

export default function UploadDocument({
    open,
    onOpenChange,
    heading = "Upload Document",
    purpose,
    docsType
}: ImagePickerProps) {
    const isMobile = useIsMobile();
    const router = useRouter();

    const isOpen = open === purpose;
    const closePopup = () => onOpenChange("");

    const { files, addFiles } = uploadDocumentStore();
    const { setFront, setBack } = kycStore()
    const { setKycType } = useComponentStore();

    const shouldShowTakePhoto = purpose === "kyc" || isMobile;

    const handleFiles = (selectedFiles: File[]) => {
        if (!selectedFiles.length) return;

        if (files.length + selectedFiles.length > MAX_FILES) {
            errorToast(`You can upload up to ${MAX_FILES} files only`);
            return;
        }

        const validFiles = selectedFiles.filter((file) => {
            if (!ALLOWED_TYPES.includes(file.type)) {
                errorToast("Unsupported file type");
                return false;
            }

            if (file.size > MAX_FILE_SIZE_BYTES) {
                errorToast(`File size must be less than ${MAX_FILE_SIZE_MB} MB`);
                return false;
            }

            return true;
        });

        if (!validFiles.length) return;

        if (docsType === "front") {
            setFront(validFiles[0])
        } else if (docsType === "back") {
            setBack(validFiles[0])
        } else
            addFiles(validFiles);
        closePopup();
    };

    const openFilePicker = ({ camera }: { camera?: boolean }) => {
        const input = document.createElement("input");
        input.type = "file";
        input.accept = ACCEPT_STRING;
        input.multiple = false;

        if (camera) input.capture = "environment";

        input.onchange = (e) => {
            const target = e.target as HTMLInputElement;
            if (!target.files) return;
            handleFiles(Array.from(target.files));
        };

        input.click();
    };

    const Content = (
        <div className="space-y-4">
            <div className="p-4 border-b">
                <h2 className="text-lg font-semibold">{heading}</h2>
                <p className="text-xs text-gray-500">
                    File size should be less than {MAX_FILE_SIZE_MB} MB
                </p>
            </div>

            {/* Take Photo / Aadhaar */}
            {shouldShowTakePhoto && (
                <button
                    type="button"
                    onClick={
                        purpose === "document"
                            ? () => openFilePicker({ camera: true })
                            : () => {
                                setKycType("aadhaar");
                                router.replace("/caretaker/kyc/upload");
                            }
                    }
                    className="flex justify-between items-center px-4 w-full cursor-pointer"
                >
                    <div className="flex items-center gap-5">
                        {purpose !== "kyc" ? <Camera /> : <IdCard />}
                        <span className="text-md">
                            {purpose === "document" ? "Take Photo" : "Aadhar Card"}
                        </span>
                    </div>
                    <ChevronRight />
                </button>

            )}

            {/* Gallery / Passport */}
            <button
                type="button"
                onClick={
                    purpose === "document"
                        ? () => openFilePicker({ camera: false })
                        : () => {
                            setKycType("passport");
                            router.replace("/caretaker/kyc/upload");
                        }
                }
                className="flex justify-between items-center px-4 w-full cursor-pointer h-fit"
            >
                <div className="flex items-center gap-5">
                    {purpose === "document" ? <Images /> : <IdCardLanyard />}
                    <span className="text-md">
                        {purpose === "document" ? "Choose from gallery" : "Passport"}
                    </span>
                </div>
                <ChevronRight />
            </button>

            <div className="h-20 bg-[#D9D9D9]/35 [clip-path:polygon(0%_50%,100%_0%,100%_100%,0%_100%)]" />
        </div>
    );

    return isMobile ? (
        <Sheet open={isOpen} onOpenChange={closePopup}>
            <SheetContent side="bottom" className="rounded-t-xl p-0">
                <VisuallyHidden>
                    <DialogTitle>{heading}</DialogTitle>
                    <DialogDescription>
                        Upload your document images
                    </DialogDescription>
                </VisuallyHidden>
                {Content}
            </SheetContent>
        </Sheet>
    ) : (
        <Dialog open={isOpen} onOpenChange={closePopup}>
            <DialogContent className="max-w-xs p-0">
                <DialogHeader>
                    <VisuallyHidden>
                        <DialogTitle>{heading}</DialogTitle>
                        <DialogDescription>
                            Upload your document images
                        </DialogDescription>
                    </VisuallyHidden>
                </DialogHeader>
                {Content}
            </DialogContent>
        </Dialog>
    );
}



// "use client";

// import { Sheet, SheetContent } from "@/components/ui/sheet";
// import {
//     Dialog,
//     DialogContent,
//     DialogHeader,
//     DialogTitle,
//     DialogDescription,
// } from "@/components/ui/dialog";
// import { VisuallyHidden } from "@radix-ui/react-visually-hidden";
// import { Camera, ChevronRight, IdCard, IdCardLanyard, Images } from "lucide-react";
// import { useIsMobile } from "@/hooks/use-mobile";
// import { useRouter } from "next/navigation";
// import { ImagePickerProps } from "@/types/componentTypes";
// import { errorToast } from "@/utils/toast";
// import { useComponentStore } from "@/store/componentStore";
// import { uploadDocumentStore } from '@/store/uploadDocumentStore';
// import { kycStore } from '@/store/kycStore';

// const MAX_FILES = 12;
// const MAX_FILE_SIZE_MB = 5;
// const MAX_FILE_SIZE_BYTES = MAX_FILE_SIZE_MB * 1024 * 1024;

// const ALLOWED_TYPES = [
//     "image/jpeg",
//     "image/jpg",
//     "image/png",
//     "image/webp",
//     "application/pdf",
// ];

// const ACCEPT_STRING = ALLOWED_TYPES.join(",");

// export default function UploadDocument({
//     open,
//     onOpenChange,
//     heading = "Upload Document",
//     purpose,
//     docsType
// }: ImagePickerProps) {
//     const isMobile = useIsMobile();
//     const router = useRouter();

//     const isOpen = open === purpose;
//     const closePopup = () => onOpenChange("");

//     const { files, addFiles } = uploadDocumentStore();
//     const { setFront, setBack } = kycStore()
//     const { setKycType } = useComponentStore();

//     const shouldShowTakePhoto = purpose === "kyc" || isMobile;

//     const handleFiles = (selectedFiles: File[]) => {
//         if (!selectedFiles.length) return;

//         if (files.length + selectedFiles.length > MAX_FILES) {
//             errorToast(`You can upload up to ${MAX_FILES} files only`);
//             return;
//         }

//         const validFiles = selectedFiles.filter((file) => {
//             if (!ALLOWED_TYPES.includes(file.type)) {
//                 errorToast("Unsupported file type");
//                 return false;
//             }

//             if (file.size > MAX_FILE_SIZE_BYTES) {
//                 errorToast(`File size must be less than ${MAX_FILE_SIZE_MB} MB`);
//                 return false;
//             }

//             return true;
//         });

//         if (!validFiles.length) return;

//         if (docsType === "front") {
//             setFront(validFiles[0])
//         } else if (docsType === "back") {
//             setBack(validFiles[0])
//         } else
//             addFiles(validFiles);
//         closePopup();
//     };

//     const openFilePicker = ({ camera }: { camera?: boolean }) => {
//         const input = document.createElement("input");
//         input.type = "file";
//         input.accept = ACCEPT_STRING;
//         input.multiple = false;

//         if (camera) input.capture = "environment";

//         input.onchange = (e) => {
//             const target = e.target as HTMLInputElement;
//             if (!target.files) return;
//             handleFiles(Array.from(target.files));
//         };

//         input.click();
//     };

//     const Content = (
//         <div className="space-y-4">
//             <div className="p-4 border-b">
//                 <h2 className="text-lg font-semibold">{heading}</h2>
//                 <p className="text-xs text-gray-500">
//                     File size should be less than {MAX_FILE_SIZE_MB} MB
//                 </p>
//             </div>

//             {/* Take Photo / Aadhaar */}
//             {shouldShowTakePhoto && (
//                 <div className="flex justify-between items-center px-4">
//                     <div className="flex items-center gap-5">
//                         {purpose !== "kyc" ? <Camera /> : <IdCard />}
//                         <button
//                             type="button"
//                             onClick={
//                                 purpose === "document"
//                                     ? () => openFilePicker({ camera: true })
//                                     : () => {
//                                         setKycType("aadhaar");
//                                         router.replace("/caretaker/kyc/upload");
//                                     }
//                             }
//                             className="text-md"
//                         >
//                             {purpose === "document" ? "Take Photo" : "Aadhar Card"}
//                         </button>
//                     </div>
//                     <ChevronRight />
//                 </div>
//             )}

//             {/* Gallery / Passport */}
//             <div className="flex justify-between items-center p-4">
//                 <div className="flex items-center gap-5">
//                     {purpose === "document" ? <Images /> : <IdCardLanyard />}
//                     <button
//                         type="button"
//                         onClick={
//                             purpose === "document"
//                                 ? () => openFilePicker({ camera: false })
//                                 : () => {
//                                     setKycType("passport");
//                                     router.replace("/caretaker/kyc/upload");
//                                 }
//                         }
//                         className="text-md"
//                     >
//                         {purpose === "document"
//                             ? "Choose from gallery"
//                             : "Passport"}
//                     </button>
//                 </div>
//                 <ChevronRight />
//             </div>

//             <div className="h-20 bg-[#D9D9D9]/35 [clip-path:polygon(0%_50%,100%_0%,100%_100%,0%_100%)]" />
//         </div>
//     );

//     return isMobile ? (
//         <Sheet open={isOpen} onOpenChange={closePopup}>
//             <SheetContent side="bottom" className="rounded-t-xl p-0">
//                 <VisuallyHidden>
//                     <DialogTitle>{heading}</DialogTitle>
//                     <DialogDescription>
//                         Upload your document images
//                     </DialogDescription>
//                 </VisuallyHidden>
//                 {Content}
//             </SheetContent>
//         </Sheet>
//     ) : (
//         <Dialog open={isOpen} onOpenChange={closePopup}>
//             <DialogContent className="max-w-sm p-0">
//                 <DialogHeader>
//                     <VisuallyHidden>
//                         <DialogTitle>{heading}</DialogTitle>
//                         <DialogDescription>
//                             Upload your document images
//                         </DialogDescription>
//                     </VisuallyHidden>
//                 </DialogHeader>
//                 {Content}
//             </DialogContent>
//         </Dialog>
//     );
// }
