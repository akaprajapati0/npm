"use client";

import { ReusableCard } from "@/components/ReusableCard";
import Image from "next/image";
import { uploadDocumentStore } from '@/store/uploadDocumentStore';
import GoBackBtn from '@/components/GoBackBtn';
import UploadDocument from '@/components/UploadDocument';
import { useState } from 'react';
import { PopupType } from '@/types/componentTypes';
import { Button } from '@/components/ui/button';
import { useUploadPrescription } from '@/hooks/usePrescriptionMutation';
import ReusablePopup from '@/components/ui/ReusablePopup';
import { useRouter } from 'next/navigation';
import { File, Loader } from 'lucide-react';
import { useComponentStore } from '@/store/componentStore';
import ReadTextModal from "@/components/ReadTextModal";
import { Prescription_CONFIG } from '@/lib/allReadableText';

export default function UploadPrescription() {
    const router = useRouter();
    const { setIsPrescriptionUploaded } = useComponentStore();
    const { files, removeFile, clearFiles } = uploadDocumentStore();
    const { isPending, mutate, isSuccess } = useUploadPrescription(() => {
        setOpenPopup(true);
        setIsPrescriptionUploaded(true);
    });

    const [uploadType, setUploadType] = useState<PopupType>("");
    const [openPopup, setOpenPopup] = useState(false);
    const [activeTextModal, setActiveTextModal] = useState<boolean>(false);

    const onSubmit = () => {
        mutate(files)
        if (isSuccess)
            clearFiles()
    }

    const handlePopupClose = (open: boolean) => {
        setOpenPopup(open);
        if (!open) {
            router.replace("/caretaker/upload-document");
        }
        clearFiles()
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
            {/* <GoBackBtn href="/caretaker/upload-document" ariaLabel="back prescribed medicine" />
            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}
            <ReusableCard
                title={`${files.length} Prescription attached`}
                description="You can upload up to twelve images at once for your prescription submission."
            >
                <div className="space-y-5">
                    {/* Image Grid */}
                    <div className="grid grid-cols-3 gap-4">
                        {files.map((file, index) => (
                            <div
                                key={index}
                                className="relative h-24 w-24 rounded-md border"
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
                                        src={URL.createObjectURL(file)}
                                        alt={`Prescription ${index + 1}`}
                                        fill
                                        className="object-cover rounded-md"
                                    />
                                )}

                                <button
                                    onClick={() => removeFile(index)}
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
                        Every prescription you submit is carefully verified before your order is processed.
                    </p>

                    {/* <Button variant="link" onClick={() => setActiveTextModal(true)} className='p-0'>Need Help?</Button> */}


                    <Button
                        disabled={isPending || files.length == 0}
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
                open={!!activeTextModal}
                onOpenChange={(open) => !open && setActiveTextModal(false)}
                title={Prescription_CONFIG['Valid_pres'].title || ""}
                markdown={Prescription_CONFIG['Valid_pres'].markdown || ""}
                fileName={Prescription_CONFIG['Valid_pres'].fileName || ""}
                triggerLabel="Read Terms"
            />
            {/* </div> */}
        </div>
    );
}



// "use client";

// import { ReusableCard } from "@/components/ReusableCard";
// import Image from "next/image";
// import { uploadDocumentStore } from '@/store/uploadDocumentStore';
// import GoBackBtn from '@/components/GoBackBtn';
// import UploadDocument from '@/components/UploadDocument';
// import { useState } from 'react';
// import { PopupType } from '@/types/componentTypes';
// import { Button } from '@/components/ui/button';
// import { useUploadPrescription } from '@/hooks/usePrescriptionMutation';
// import ReusablePopup from '@/components/ui/ReusablePopup';
// import { useRouter } from 'next/navigation';
// import { Loader } from 'lucide-react';
// import { useComponentStore } from '@/store/componentStore';
// import ReadTextModal from "@/components/ReadTextModal";
// import { Prescription_CONFIG } from '@/lib/allReadableText';

// export default function UploadPrescription() {
//     const router = useRouter();
//     const { setIsPrescriptionUploaded } = useComponentStore();
//     const { files, removeFile, clearFiles } = uploadDocumentStore();
//     const { isPending, mutate, isSuccess } = useUploadPrescription(() => {
//         setOpenPopup(true);
//         setIsPrescriptionUploaded(true);
//     });

//     const [uploadType, setUploadType] = useState<PopupType>("");
//     const [openPopup, setOpenPopup] = useState(false);
//     const [activeTextModal, setActiveTextModal] = useState<boolean>(false);

//     const onSubmit = () => {
//         mutate(files)
//         if (isSuccess)
//             clearFiles()
//     }

//     const handlePopupClose = (open: boolean) => {
//         setOpenPopup(open);
//         if (!open) {
//             router.replace("/caretaker/upload-document");
//         }
//     };

//     return (
//         <div className="min-h-screen bg-white md:bg-gray-100">
//             <GoBackBtn href="/caretaker/upload-document" ariaLabel="back prescribed medicine" />
//             <div className="flex items-center justify-center min-h-[calc(100vh-100px)]">
//                 <ReusableCard
//                     title={`${files.length} Prescription attached`}
//                     description="You can upload up to twelve images at once for your prescription submission."
//                 >
//                     <div className="space-y-5">
//                         {/* Image Grid */}
//                         <div className="grid grid-cols-3 gap-4">
//                             {files.map((file, index) => (
//                                 <div
//                                     key={index}
//                                     className="relative h-24 w-24 rounded-md border"
//                                 >
//                                     <Image
//                                         src={URL.createObjectURL(file)}
//                                         alt={`Prescription ${index + 1}`}
//                                         fill
//                                         className="object-cover rounded-md"
//                                     />

//                                     <button
//                                         onClick={() => removeFile(index)}
//                                         className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center cursor-pointer"
//                                     >
//                                         ×
//                                     </button>
//                                 </div>
//                             ))}

//                             {/* Add More */}
//                             {files.length < 12 && (
//                                 <div className="flex h-24 w-24 items-center justify-center rounded-md border border-dotted border-primary text-primary text-2xl cursor-pointer" onClick={() => setUploadType("document")}>
//                                     +
//                                 </div>
//                             )}
//                         </div>

//                         <p className="text-gray-500 text-sm">
//                             All uploads are encrypted and accessible only to our backend team.
//                             Every prescription you submit is carefully verified before your order is processed.
//                         </p>

//                         {/* <Button variant="link" onClick={() => setActiveTextModal(true)} className='p-0'>Need Help?</Button> */}


//                         <Button
//                             disabled={isPending || files.length == 0}
//                             className="w-full mt-10"
//                             onClick={onSubmit}
//                         >
//                             {isPending ? <Loader /> : "Continue"}
//                         </Button>
//                     </div>
//                 </ReusableCard>
//             </div>

//             <UploadDocument
//                 open={uploadType}
//                 onOpenChange={setUploadType}
//                 purpose="document"
//                 heading="Upload Prescription"
//             />

//             <ReusablePopup
//                 open={openPopup}
//                 onOpenChange={handlePopupClose}
//                 image="/successfull-popup.svg"
//                 title="Uploaded Successfully"
//                 description="Thank you for uploading your prescription. Please complete KYC verification by submitting a valid ID proof to proceed."
//             />

//             <ReadTextModal
//                 open={!!activeTextModal}
//                 onOpenChange={(open) => !open && setActiveTextModal(false)}
//                 title={Prescription_CONFIG['Valid_pres'].title || ""}
//                 markdown={Prescription_CONFIG['Valid_pres'].markdown || ""}
//                 fileName={Prescription_CONFIG['Valid_pres'].fileName || ""}
//                 triggerLabel="Read Terms"
//             />
//         </div>
//     );
// }
