"use client";

import { useState } from "react";
import { Button } from "@/components/ui/button";
import {
    Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger,
} from "@/components/ui/dialog";
import adminApi from '@/lib/adminApi';

export function UploadDocumentDialog({ requestId, type }: any) {
    const [open, setOpen] = useState(false);

    const handleUpload = async (e: any) => {
        const file = e.target.files[0];

        const formData = new FormData();
        formData.append("file", file);
        formData.append("type", type);

        await adminApi.post(`request/upload/${requestId}`, { formData });

        setOpen(false);
    };

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button size="sm" variant="outline">
                    Upload
                </Button>
            </DialogTrigger>

            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Upload Document</DialogTitle>
                </DialogHeader>

                <input type="file" onChange={handleUpload} />
            </DialogContent>
        </Dialog>
    );
}