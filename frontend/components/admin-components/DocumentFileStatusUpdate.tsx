"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { ReusableForm } from "@/components/ReusableForm";
import { Loader } from 'lucide-react';

const MAX_FILE_SIZE_MB = 10;
const MAX_FILES = 5;
const ACCEPTED_FILE_TYPES = ["application/pdf", "image/jpeg", "image/png", "image/webp"];

const updateStatusSchema = z
    .object({
        status: z.enum(["Approved", "Rejected"], { error: "Please select a status" }),
        remarks: z.string().max(500, "Remarks must be under 500 characters").optional(),
        documents: z
            .custom<FileList>()
            .refine((files) => !files || files.length <= MAX_FILES, `Up to ${MAX_FILES} files allowed`)
            .refine(
                (files) =>
                    !files || Array.from(files).every((f) => f.size <= MAX_FILE_SIZE_MB * 1024 * 1024),
                `Each file must be under ${MAX_FILE_SIZE_MB}MB`
            )
            .refine(
                (files) => !files || Array.from(files).every((f) => ACCEPTED_FILE_TYPES.includes(f.type)),
                "Only PDF, JPG, PNG, or WEBP files are allowed"
            )
            .optional(),
    })
    .refine((data) => data.status !== "Rejected" || !!data.remarks?.trim(), {
        message: "Remarks are required when rejecting",
    });

export type UpdateStatusFormValues = z.infer<typeof updateStatusSchema>;

interface UpdateDocumentStatusDialogProps {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    documentType: string;
    currentStatus: string;
    isSubmitting: boolean;
    onSubmit: (values: UpdateStatusFormValues) => void;
    trigger?: React.ReactNode;
}

export function UpdateDocumentStatusDialog({
    open,
    onOpenChange,
    documentType,
    currentStatus,
    isSubmitting,
    onSubmit,
    trigger,
}: UpdateDocumentStatusDialogProps) {
    const form = useForm<UpdateStatusFormValues>({
        resolver: zodResolver(updateStatusSchema),
        defaultValues: { status: undefined, remarks: "", documents: undefined },
    });

    return (
        <Dialog
            open={open}
            onOpenChange={(next) => {
                onOpenChange(next);
                if (!next) form.reset();
            }}
        >
            <DialogTrigger asChild>{trigger ?? <Button>Update</Button>}</DialogTrigger>

            <DialogContent className="sm:max-w-[500px]">
                <DialogHeader>
                    <DialogTitle>Update {documentType}</DialogTitle>
                    <DialogDescription>
                        Current status: <span className="font-medium">{currentStatus}</span>
                    </DialogDescription>
                </DialogHeader>

                <ReusableForm heading="" subHeading="" form={form} onSubmit={onSubmit}>
                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Status</Label>
                        <Select
                            value={form.watch("status")}
                            onValueChange={(value) =>
                                form.setValue("status", value as "Approved" | "Rejected", {
                                    shouldValidate: true,
                                })
                            }
                        >
                            <SelectTrigger>
                                <SelectValue placeholder="Select status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="Approved">Approved</SelectItem>
                                {documentType !== "import_license" &&
                                    <SelectItem value="Rejected">Rejected</SelectItem>
                                }
                            </SelectContent>
                        </Select>
                        {form.formState.errors.status && (
                            <p className="text-sm text-destructive pl-1">
                                {form.formState.errors.status.message}
                            </p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Upload Documents</Label>
                        <input
                            type="file"
                            multiple
                            accept=".pdf,.jpg,.jpeg,.png,.webp"
                            {...form.register("documents")}
                            className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:bg-muted file:px-2 file:py-1 file:text-sm"
                        />
                        {form.formState.errors.documents && (
                            <p className="text-sm text-destructive pl-1">
                                {form.formState.errors.documents.message as string}
                            </p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Remarks</Label>
                        <Textarea
                            {...form.register("remarks")}
                            placeholder="Optional note (required if rejecting)"
                            maxLength={500}
                        />
                        {form.formState.errors.remarks && (
                            <p className="text-sm text-destructive pl-1">
                                {form.formState.errors.remarks.message}
                            </p>
                        )}
                    </div>

                    <DialogFooter>
                        <Button type="submit" disabled={isSubmitting}>
                            {isSubmitting ? <Loader /> : "Update"}
                        </Button>
                    </DialogFooter>
                </ReusableForm>
            </DialogContent>
        </Dialog>
    );
}