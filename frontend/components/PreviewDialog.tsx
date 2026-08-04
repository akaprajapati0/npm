"use client";

import Image from "next/image";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/components/ui/dialog";
import { Button } from './ui/button';

interface PreviewDialogProps {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    previewUrl: string | null;
    fileType?: string;
    onConfirm?: () => void;
}

export default function PreviewDialog({
    open,
    onOpenChange,
    previewUrl,
    fileType,
    onConfirm
}: PreviewDialogProps) {
    const isPdf = fileType === "application/pdf";
    const isMobile = typeof navigator !== "undefined" && /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    const renderPreview = () => {
        if (!previewUrl) {
            return <p className="text-gray-500 text-center">No preview available.</p>;
        }

        if (isPdf) {
            if (isMobile) {
                return (
                    <div className="flex flex-col items-center justify-center gap-4 py-8">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="56"
                            height="56"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#e53e3e"
                            strokeWidth="1.5"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                        >
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="9" y1="13" x2="15" y2="13" />
                            <line x1="9" y1="17" x2="15" y2="17" />
                            <polyline points="9 9 10 9" />
                        </svg>
                        <p className="text-gray-500 text-sm text-center">
                            PDF preview is not supported on mobile browsers.
                        </p>

                        <a href={previewUrl}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-primary underline text-sm font-medium"
                        >
                            Open PDF in browser
                        </a>
                    </div >
                );
            }

            return (
                <iframe
                    src={previewUrl}
                    className="w-full rounded-md"
                    style={{ height: "65vh" }}
                    title="PDF Preview"
                />
            );
        }

        return (
            <Image
                src={previewUrl}
                alt="Preview"
                width={800}
                height={800}
                className="w-full h-auto rounded-md object-contain max-h-[70vh]"
            />
        );
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="p-0 max-w-[95%] sm:max-w-lg rounded-xl overflow-hidden border-none">
                {/* Header */}
                <DialogHeader className="p-4 pb-0">
                    <DialogTitle className="text-lg sm:text-xl">Preview</DialogTitle>
                    <DialogDescription className="flex items-end justify-end">
                        {onConfirm && <Button onClick={onConfirm}>Continue</Button>}
                    </DialogDescription>
                </DialogHeader>

                <div className="max-h-[75vh] overflow-y-auto p-4 pb-6 flex justify-center items-center bg-white">
                    {renderPreview()}
                </div>
            </DialogContent>
        </Dialog>
    );
}



// "use client";

// import Image from "next/image";
// import {
//     Dialog,
//     DialogContent,
//     DialogHeader,
//     DialogTitle,
//     DialogDescription,
// } from "@/components/ui/dialog";
// import { Button } from './ui/button';

// interface PreviewDialogProps {
//     open: boolean;
//     onOpenChange: (open: boolean) => void;
//     previewUrl: string | null;
//     onConfirm?: () => void
// }

// export default function PreviewDialog({
//     open,
//     onOpenChange,
//     previewUrl,
//     onConfirm
// }: PreviewDialogProps) {
//     return (
//         <Dialog open={open} onOpenChange={onOpenChange}>
//             <DialogContent
//                 className="
//           p-0
//           max-w-[95%]
//           sm:max-w-lg
//           rounded-xl
//           overflow-hidden
//           border-none
//         "
//             >
//                 {/* Header */}
//                 <DialogHeader className="p-4 pb-0">
//                     <DialogTitle className="text-lg sm:text-xl">Preview</DialogTitle>
//                     <DialogDescription className='flex items-end justify-end'>
//                         {onConfirm && <Button onClick={onConfirm}>Continue</Button>}
//                     </DialogDescription>
//                 </DialogHeader>
//                 <div
//                     className="max-h-[75vh] overflow-y-auto p-4 pb-6 flex justify-center items-center bg-white"
//                 >
//                     {previewUrl ? (
//                         <Image
//                             src={previewUrl}
//                             alt="Preview"
//                             width={800}
//                             height={800}
//                             className="w-full h-auto rounded-md object-contain max-h-[70vh]"
//                         />
//                     ) : (
//                         <p className="text-gray-500 text-center">No preview available.</p>
//                     )}
//                 </div>
//             </DialogContent>
//         </Dialog>
//     );
// }
