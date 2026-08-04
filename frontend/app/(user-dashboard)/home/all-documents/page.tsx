"use client";

import { useState } from "react";
import GoBackBtn from "@/components/GoBackBtn";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { DownloadIcon, FileText, Loader2 } from "lucide-react";
import { DOCUMENT_FIELDS, useGetDocumentByUser } from "@/hooks/useDocument";

const API_BASE_URL = process.env.NEXT_PUBLIC_IMAGE_URL! ?? "";

interface DocumentCardProps {
    title: string;
    description: string;
    fileUrl?: string;
    fileType?: string;
}

type Image = {
    url: string;
    mimeType?: string;
    size?: number;
};

// ------- Reusable Document Card ---------
function DocumentCard({ title, description, fileUrl, fileType }: DocumentCardProps) {
    const [isDownloading, setIsDownloading] = useState(false);

    const handleDownload = async () => {
        if (!fileUrl) return;
        const fullUrl = `${API_BASE_URL}${fileUrl}`;
        console.log("Fetching:", fullUrl);
        window.open(fullUrl, "_blank"); // bypass fetch entirely, just see if browser can load it
    };

    return (
        <Card className="rounded-2xl border border-black/20 hover:shadow-md transition w-72">
            <CardContent className="flex gap-4 p-4">
                <FileText className="h-8 w-8 text-primary" />

                <div className="flex flex-col justify-between gap-4 w-full">
                    <div className="space-y-1">
                        <h2 className="font-semibold text-base">{title}</h2>
                        <p className="text-sm text-muted-foreground">{description}</p>
                    </div>

                    <Button
                        variant="link"
                        onClick={handleDownload}
                        disabled={isDownloading || !fileUrl}
                        className="p-0 h-auto self-start"
                    >
                        {isDownloading ? (
                            <>
                                <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                                Downloading...
                            </>
                        ) : (
                            <>
                                <DownloadIcon className="mr-2 h-4 w-4" />
                                Download
                            </>
                        )}
                    </Button>
                </div>
            </CardContent>
        </Card>
    );
}

// ------- Page --------
export default function AllDocuments() {
    const { data, isPending, isError } = useGetDocumentByUser();

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home" ariaLabel="Back to dashboard" />
            <h1 className="text-center text-2xl md:text-3xl font-bold mb-3">Download Your Documents</h1>
            <p className="text-center max-w-xs mx-auto mb-4 text-black">
                Access and download all important order-related documents in one secure place.
            </p>

            {isPending && (
                <p className="text-center text-muted-foreground">Loading documents...</p>
            )}

            {isError && (
                <p className="text-center text-red-500">Document is not uploaded</p>
            )}

            {!isPending && !isError && (
                <div className="flex flex-wrap justify-center gap-10 p-4 md:p-6">
                    {DOCUMENT_FIELDS.map(({ name, label }) => {
                        const file = data?.[name] as Image | undefined;
                        return (
                            <DocumentCard
                                key={name}
                                title={label}
                                description={
                                    file
                                        ? `${(file?.size! / (1024 * 1024)).toFixed(2)} MB`
                                        : "Not uploaded"
                                }
                                fileUrl={file?.url}
                                fileType={file?.mimeType}
                            />
                        );
                    })}
                </div>
            )}
        </div>
    );
}