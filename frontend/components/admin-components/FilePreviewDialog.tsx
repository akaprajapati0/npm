"use client";

import {
    Dialog,
    DialogContent,
    DialogTitle,
    DialogDescription,
} from "@/components/ui/dialog";

import { VisuallyHidden } from "@radix-ui/react-visually-hidden";
import { Button } from "@/components/ui/button";
import { useEffect, useState } from "react";

type PreviewType = {
    url: string;
    type: "image" | "pdf";
} | null;

interface Props {
    preview: PreviewType;
    onClose: () => void;
}

export default function FilePreviewDialog({
    preview,
    onClose,
}: Props) {
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (preview) {
            setLoading(true);
        }
    }, [preview]);

    const handleDownload = () => {
        if (!preview?.url) return;

        const a = document.createElement("a");
        a.href = preview.url;
        a.target = "_blank";
        a.download = preview.url.split("/").pop() || "file";
        document.body.appendChild(a);
        a.click();
        a.remove();
    };

    return (
        <Dialog
            open={!!preview}
            onOpenChange={(open) => !open && onClose()}
        >
            <DialogContent className="max-w-5xl h-[90vh] p-0 overflow-hidden">
                <VisuallyHidden>
                    <DialogTitle>File Preview</DialogTitle>
                    <DialogDescription>
                        Preview of uploaded document
                    </DialogDescription>
                </VisuallyHidden>

                {/* Download Button */}
                <Button
                    size="sm"
                    variant="outline"
                    onClick={handleDownload}
                    className="absolute top-3 left-3 z-20"
                >
                    Download
                </Button>

                {/* Loader */}
                {loading && (
                    <div className="absolute inset-0 z-10 flex items-center justify-center bg-white/70">
                        Loading...
                    </div>
                )}

                {/* IMAGE PREVIEW */}
                {preview?.type === "image" && (
                    <img
                        src={preview.url}
                        alt="Preview"
                        className="w-full h-full object-contain"
                        onLoad={() => setLoading(false)}
                        onError={() => setLoading(false)}
                    />
                )}

                {/* PDF PREVIEW */}
                {preview?.type === "pdf" && (
                    <iframe
                        src={`${preview.url}#toolbar=0`}
                        className="w-full h-full"
                        onLoad={() => setLoading(false)}
                    />
                )}
            </DialogContent>
        </Dialog>
    );
}

// useEffect(() => {
//     if (preview?.type !== "pdf") return;

//     setLoading(true);
//     setBlobUrl(null);

//     // Replace localhost URL with production domain
//     const resolvedUrl = preview.url.replace(
//         "http://localhost:5000",
//         "https://api.namedpatientprogram.cam"
//     );

//     fetch(resolvedUrl)
//         .then((res) => res.blob())
//         .then((blob) => {
//             const url = URL.createObjectURL(blob);
//             setBlobUrl(url);
//         })
//         .catch((err) => {
//             console.error("Failed to load PDF", err);
//             setLoading(false);
//         });

//     return () => {
//         setBlobUrl((prev) => {
//             if (prev) URL.revokeObjectURL(prev);
//             return null;
//         });
//     };
// }, [preview]);