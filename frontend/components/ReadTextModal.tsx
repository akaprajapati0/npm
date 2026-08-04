"use client";

import { useState, useRef } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription } from "@/components/ui/dialog";
import { ScrollArea } from "@/components/ui/scroll-area";
import Link from 'next/link';

interface ReadableDocumentDialogProps {
    title: string;
    triggerLabel?: string;
    markdown: string;
    fileName?: string;
    open?: boolean;
    redirect?: string;
    onOpenChange?: (open: boolean) => void;
}

export default function ReadTextModal({
    title,
    markdown,
    redirect,
    open: controlledOpen,
    onOpenChange,
}: ReadableDocumentDialogProps) {
    const [internalOpen, setInternalOpen] = useState(false);

    const open = controlledOpen ?? internalOpen;
    const setOpen = onOpenChange ?? setInternalOpen;
    const contentRef = useRef<HTMLDivElement>(null);


    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogContent className="max-w-xs p-0 ">
                <DialogHeader className="px-6 pt-6 flex flex-col gap-3">
                    <DialogDescription className="sr-only">
                        Read and review the document content. You can search, print, or download it as PDF.
                    </DialogDescription>

                    <DialogTitle className="text-md text-center font-semibold">{title}</DialogTitle>
                </DialogHeader>

                <ScrollArea className="max-h-[70vh] px-4 pb-2 text-xs lg:text-sm">
                    <article
                        ref={contentRef}
                        className="prose prose-sm sm:prose-base max-w-none space-y-1"
                    >
                        <ReactMarkdown remarkPlugins={[remarkGfm]}>
                            {markdown}
                        </ReactMarkdown>
                        <div className="flex justify-center mt-6">
                            <Link href={redirect || "tel:18001200365"} className='mx-auto text-primary font-bold'>Call for Any Help</Link>
                        </div>
                    </article>
                </ScrollArea>
            </DialogContent>
        </Dialog>
    );
}

//     const handlePrint = () => {
//         if (!contentRef.current) return;
//         const printWindow = window.open("", "", "width=900,height=650");
//         if (!printWindow) return;

//         printWindow.document.write(`
//       <html>
//         <head>
//           <title>${title}</title>
//           <style>
//             body { font-family: system-ui, sans-serif; padding: 24px; }
//             h1, h2, h3 { margin-top: 1.5em; }
//           </style>
//         </head>
//         <body>
//           ${contentRef.current.innerHTML}
//         </body>
//       </html>
//     `);
//         printWindow.document.close();
//         printWindow.focus();
//         printWindow.print();
//     };

//     const handleDownloadPdf = async () => {
//         if (!contentRef.current) return;

//         // Clone content safely
//         const clone = contentRef.current.cloneNode(true) as HTMLElement;

//         // Inject a compatibility stylesheet for html2canvas
//         const style = document.createElement("style");
//         style.innerHTML = `
//     * {
//       color: #000 !important;
//       background-color: transparent !important;
//       border-color: #000 !important;
//     }
//   `;

//         clone.prepend(style);

//         const html2pdf = (await import("html2pdf.js")).default;

//         await html2pdf()
//             .set({
//                 margin: 10,
//                 filename: `${fileName}.pdf`,
//                 image: { type: "jpeg", quality: 0.98 },
//                 html2canvas: {
//                     scale: 2,
//                     backgroundColor: "#ffffff",
//                     useCORS: true,
//                 },
//                 jsPDF: {
//                     unit: "mm",
//                     format: "a4",
//                     orientation: "portrait",
//                 },
//             })
//             .from(clone)
//             .save();
//     };

/* <div className="flex flex-wrap items-center gap-2">
                       <Button variant="outline" size="icon" onClick={handlePrint}>
                           <Printer className="h-4 w-4" />
                       </Button>

                       <Button variant="outline" size="icon" onClick={handleDownloadPdf}>
                           <Download className="h-4 w-4" />
                       </Button>
                   </div> */