"use client";

import FilePreviewDialog from '@/components/admin-components/FilePreviewDialog';
import { ReusableDataTable } from "@/components/admin-components/table/data-table";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { TableCell, TableHead } from "@/components/ui/table";
import {
    useGetAdminDocument,
    useUploadAdminDocument,
} from "@/hooks/useCdecMutation";
import { getImageUrl } from "@/lib/getImage";
import { isImage, isPdf } from "@/types/adminSchema";
import { Loader, Upload } from "lucide-react";
import { useState } from "react";

export default function UploadCdec() {
    const { data, isLoading } = useGetAdminDocument("admin");
    const { mutate: uploadDocument, isPending } = useUploadAdminDocument();

    const [preview, setPreview] = useState<{
        url: string;
        type: "image" | "pdf";
    } | null>(null);

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const files = Array.from(e.target.files || []);
        if (!files.length) return;

        uploadDocument({ files });
        e.target.value = ""; // reset input
    };

    // Ensure at least one row always exists
    const tableData = [data || { documents: [] }];

    return (
        <>
            <ReusableDataTable
                heading="Upload CDEC Form"
                subHeading=""
                data={tableData}
                head={
                    <>
                        <TableHead>Document</TableHead>
                        <TableHead>Action</TableHead>
                    </>
                }
            >
                {(row, index) => {
                    const inputId = `admin-doc-upload-${index}`;

                    return (
                        <>
                            {/* Documents Preview */}
                            <TableCell>
                                <div className="flex items-center gap-2 flex-wrap">
                                    {row?.documents?.length > 0 ? (
                                        row.documents.map((doc: any, i: number) => {
                                            const fileUrl = getImageUrl(doc?.url);

                                            return (
                                                <div key={doc?.url || i}>
                                                    {isImage(fileUrl) ? (
                                                        <img
                                                            src={fileUrl}
                                                            alt="Document"
                                                            className="w-20 h-20 object-cover rounded-md border cursor-pointer hover:opacity-80"
                                                            onClick={() =>
                                                                setPreview({
                                                                    url: fileUrl,
                                                                    type: "image",
                                                                })
                                                            }
                                                        />
                                                    ) : isPdf(fileUrl) ? (
                                                        <div
                                                            onClick={() =>
                                                                setPreview({
                                                                    url: fileUrl,
                                                                    type: "pdf",
                                                                })
                                                            }
                                                            className="w-20 h-20 flex items-center justify-center border rounded-md cursor-pointer bg-muted hover:bg-muted/70"
                                                        >
                                                            📄 PDF
                                                        </div>
                                                    ) : (
                                                        <div className="w-20 h-20 flex items-center justify-center border rounded-md text-xs">
                                                            File
                                                        </div>
                                                    )}
                                                </div>
                                            );
                                        })
                                    ) : (
                                        <span className="text-sm text-muted-foreground">
                                            No documents uploaded
                                        </span>
                                    )}
                                </div>
                            </TableCell>

                            {/* Upload Action (Always visible) */}
                            <TableCell>
                                <Label htmlFor={inputId}>
                                    <Button
                                        type="button"
                                        variant="outline"
                                        size="sm"
                                        disabled={isPending}
                                        className="flex items-center gap-2 cursor-pointer"
                                        asChild
                                    >
                                        <span>
                                            {isPending ? (
                                                <Loader className="w-4 h-4 animate-spin" />
                                            ) : (
                                                <Upload className="w-4 h-4" />
                                            )}
                                            {isPending ? "Uploading..." : "Upload Files"}
                                        </span>
                                    </Button>
                                </Label>

                                <input
                                    id={inputId}
                                    type="file"
                                    multiple
                                    className="hidden"
                                    onChange={handleFileChange}
                                    disabled={isPending}
                                />
                            </TableCell>
                        </>
                    );
                }}
            </ReusableDataTable>

            <FilePreviewDialog
                preview={preview}
                onClose={() => setPreview(null)}
            />
        </>
    );
}