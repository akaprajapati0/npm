"use client";

import { useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { TableCell, TableHead } from "@/components/ui/table";
import { DOCUMENT_FIELDS, DocumentDetailsFormValues, documentDetailsSchema, useUploadDocuments } from '@/hooks/useDocument';
import { ReusableDataTable } from './table/data-table';
import { ReusableForm } from '../ReusableForm';
import { Loader } from 'lucide-react';



interface DocumentUploadDialogProps {
    id: string; // e.g. caretaker id — ties the 7 documents to this record
}

export function DocumentUploadDialog({ id }: DocumentUploadDialogProps) {
    const [open, setOpen] = useState(false);

    const form = useForm<DocumentDetailsFormValues>({
        resolver: zodResolver(documentDetailsSchema),
    });

    const { mutate: createDocuments, isPending: isUploadingDocuments } =
        useUploadDocuments(id);

    const onSubmit = (values: DocumentDetailsFormValues) => {
        createDocuments(values, {
            onSuccess: () => {
                form.reset();
                setOpen(false);
            },
        });
    };

    return (
        <ReusableDataTable
            heading="Caretaker Documents"
            subHeading="Upload caretaker documents"
            data={[{ id: 1 }]}
            head={
                <>
                    <TableHead>Action</TableHead>
                </>
            }
        >
            {(row) => (
                <>
                    <TableCell>
                        <Dialog open={open} onOpenChange={setOpen}>
                            <DialogTrigger asChild>
                                <Button>Fill Details</Button>
                            </DialogTrigger>

                            <DialogContent className="sm:max-w-[500px] max-h-[85vh] overflow-y-auto">
                                <DialogHeader>
                                    <DialogTitle>Document Details</DialogTitle>

                                    <DialogDescription>
                                        Upload all required documents.
                                    </DialogDescription>
                                </DialogHeader>

                                <ReusableForm
                                    heading=""
                                    subHeading=""
                                    form={form}
                                    onSubmit={onSubmit}
                                >
                                    {DOCUMENT_FIELDS.map(({ name, label }) => {
                                        const fieldError = form.formState.errors[name];
                                        return (
                                            <div className="space-y-2" key={name}>
                                                <Label className="font-medium pl-1">{label}</Label>
                                                <Input
                                                    type="file"
                                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                                    onChange={(e) => {
                                                        const file = e.target.files?.[0];
                                                        if (file) {
                                                            form.setValue(name, file, { shouldValidate: true });
                                                        }
                                                    }}
                                                />
                                                {fieldError && (
                                                    <p className="text-sm text-red-500 pl-1">
                                                        {fieldError.message as string}
                                                    </p>
                                                )}
                                            </div>
                                        );
                                    })}

                                    <DialogFooter>
                                        <Button
                                            type="submit"
                                            disabled={isUploadingDocuments}
                                        >
                                            {isUploadingDocuments
                                                ? <Loader />
                                                : "Submit"}
                                        </Button>
                                    </DialogFooter>
                                </ReusableForm>
                            </DialogContent>
                        </Dialog>
                    </TableCell>
                </>
            )}
        </ReusableDataTable>
    );
}