"use client";

import { useParams } from "next/navigation";
import { ReusableDataTable } from "@/components/admin-components/table/data-table";
import { TableHead, TableCell } from "@/components/ui/table";
import { Loader, Upload } from "lucide-react";
import { getImageUrl } from '@/lib/getImage';
import { ReusableSelect } from '@/components/ReusableSelect';
import { useState } from 'react';
import FilePreviewDialog from '@/components/admin-components/FilePreviewDialog';
import { useGetAdminDocument, useUpdateCdecStatus, useUploadAdminDocument } from '@/hooks/useCdecMutation';
import { useUpdatePrescriptionStatus } from '@/hooks/usePrescriptionMutation';
import { useUpdateKycStatus } from '@/hooks/useKycMutation';
import { useUpdateBankReceiptStatus } from '@/hooks/useBankReciept';
import DateDisplay from '@/lib/readableDate';
import { isImage, isPdf, PaymentFormValues } from '@/types/adminSchema';
import { useGetUserAllData } from '@/hooks/useCaretakerMutation';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { useForm } from 'react-hook-form';
import { ReusableForm } from '@/components/ReusableForm';
import { useCreatePayment, useGetPaymentByUserId } from '@/hooks/usePayment';
import { DocumentUploadDialog } from '@/components/admin-components/Documentuploaddialog';
import { UpdateDocumentStatusDialog, UpdateStatusFormValues } from '@/components/admin-components/DocumentFileStatusUpdate';
import { useUpdateDocumentStatus } from '@/hooks/useDocRequest';
import OrderCreateDialog from '@/components/admin-components/OrderCreateDialog';
import { useGetUserFeedback } from '@/hooks/useFeedback';
import { useGetOrdersByAdmin } from '@/hooks/useOrderMutation';

const statusOptions = [
    { label: "Pending", value: "pending" },
    { label: "Approved", value: "approved" },
    { label: "Rejected", value: "rejected" },
];

export default function CaretakerDetailPage() {

    const { id } = useParams<{ id: string }>();
    const [open, setOpen] = useState(false);

    const { data, isPending } = useGetUserAllData(id)

    const {
        data: paymentData,
        isError,
    } = useGetPaymentByUserId(id);

    const payments = paymentData;

    const prescription = useUpdatePrescriptionStatus();
    const cdec = useUpdateCdecStatus();
    const kyc = useUpdateKycStatus();
    const bankReceipt = useUpdateBankReceiptStatus();
    const { data: downloadableForm } = useGetAdminDocument("admin", id);
    const { mutate: uploadDocument } = useUploadAdminDocument();
    // const { mutate: updateDocument } = useUpdateAdminDocument();
    const { mutate, isPending: isCreatingPayment } =
        useCreatePayment(() => {
            form.reset();
            setOpen(false);
        });

    const { data: order } = useGetOrdersByAdmin(id)
    console.log(order)

    const { data: feedback, isError: FeddbackError } = useGetUserFeedback(id);


    const form = useForm<PaymentFormValues>({
        defaultValues: {
            user: id,
            paymentReceived: "",
            paymentLeft: "",
            accountNumber: "",
            ifsc: "",
            branch: "",
        },
    });

    const [preview, setPreview] = useState<{
        url: string;
        type: "image" | "pdf";
    } | null>(null);

    const handleFileChange = (
        e: React.ChangeEvent<HTMLInputElement>
    ) => {
        const file = e.target.files?.[0];

        if (!file) return;

        uploadDocument({
            files: [file],
            id
        });

        e.target.value = "";
    };

    const handleFileUpdate = (
        e: React.ChangeEvent<HTMLInputElement>
    ) => {
        const file = e.target.files?.[0];

        if (!file) return;

        uploadDocument({
            files: [file],
            id
        });

        e.target.value = "";
    };

    const documentUrl = downloadableForm?.downloadDocument?.url
        ? getImageUrl(downloadableForm?.downloadDocument?.url)
        : null;


    const onSubmit = (values: PaymentFormValues) => {
        mutate(
            values,
        );
    };

    function DocumentRequest({ row, documentType }: { row: any; documentType: string }) {
        const [open, setOpen] = useState(false);

        const { mutate, isPending } = useUpdateDocumentStatus(() => {
            setOpen(false);
        });

        const handleSubmit = (values: UpdateStatusFormValues) => {
            mutate({
                id: row._id,
                type: documentType,
                status: values.status,
                files: values.documents ? Array.from(values.documents) : undefined,
                remarks: values.remarks,
            });
        };

        return (
            <UpdateDocumentStatusDialog
                open={open}
                onOpenChange={setOpen}
                documentType={documentType}
                currentStatus={row.status!}
                isSubmitting={isPending}
                onSubmit={handleSubmit}
            />
        );
    }


    if (isPending) {
        return <div className="min-h-screen flex items-center justify-center">
            <Loader className="animate-spin h-8 w-8 text-primary" />
        </div>;
    }

    return (
        <>
            {/* Patient Details */}
            <ReusableDataTable
                heading="Patient Details"
                subHeading="Patient's personal information"
                data={data?.patients ?? []}
                loading={isPending}
                head={
                    <>
                        <TableHead>Full Name</TableHead>
                        <TableHead>Date of Birth</TableHead>
                        <TableHead>Gender</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>{row.fullname}</TableCell>
                        <TableCell>{DateDisplay({ isoString: row.dateOfBirth })}</TableCell>
                        <TableCell>{row.gender}</TableCell>
                    </>
                )}
            </ReusableDataTable>

            {/* Caretaker Details */}
            <ReusableDataTable
                heading="Caretaker Details"
                subHeading="Caretaker personal information"
                data={data?.caretakers ?? []}
                loading={isPending}
                head={
                    <>
                        <TableHead>Full Name</TableHead>
                        <TableHead>Phone</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Relationship</TableHead>
                        <TableHead>Country</TableHead>
                        <TableHead>City</TableHead>
                        <TableHead>Pincode</TableHead>
                        {/* <TableHead>Status</TableHead> */}
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>{row.fullname}</TableCell>
                        <TableCell>{row.phone}</TableCell>
                        <TableCell>{row.email}</TableCell>
                        <TableCell>{row.relationship}</TableCell>
                        <TableCell>{row.country}</TableCell>
                        <TableCell>{row.city}</TableCell>
                        <TableCell>{row.pincode}</TableCell>
                        {/* <TableCell>
                            <ReusableSelect
                                label=""
                                placeholder="Select"
                                value={row.status}
                                onChange={(val) =>
                                    caretaker.mutate({
                                        id: row._id,
                                        status: val,
                                    })
                                }
                                options={statusOptions}
                            />
                        </TableCell> */}
                    </>
                )}
            </ReusableDataTable>

            {/* Prescribed Medicines */}
            <ReusableDataTable
                heading="Prescribed Medicines"
                subHeading="Prescribed medicines details"
                data={data?.prescribedMedicines ?? []}
                loading={isPending}
                head={
                    <>
                        <TableHead>Medicine Name</TableHead>
                        <TableHead>Strength</TableHead>
                        <TableHead>Quantity</TableHead>
                        <TableHead>Dosage</TableHead>
                        <TableHead>Pack Size</TableHead>
                        <TableHead>Active Ingredients</TableHead>
                        <TableHead>manufacturer</TableHead>
                        <TableHead>Storage Conditions</TableHead>
                        {/* <TableHead>Status</TableHead> */}
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>{row.medicineName}</TableCell>
                        <TableCell>{row.strength}</TableCell>
                        <TableCell>{row.quantity}</TableCell>
                        <TableCell>{row.dosage}</TableCell>
                        <TableCell>{row.packSize}</TableCell>
                        <TableCell>{row.ActiveIngredients}</TableCell>
                        <TableCell>{row.manufacturer}</TableCell>
                        <TableCell>{row.storageConditions}</TableCell>
                        {/* <TableCell>
                            <ReusableSelect
                                label=""
                                placeholder="Select"
                                value={row.status}
                                onChange={(val) =>
                                    presMedicine.mutate({
                                        id: row._id,
                                        status: val,
                                    })
                                }
                                options={statusOptions}
                            />
                        </TableCell> */}
                    </>
                )}
            </ReusableDataTable>

            {/* Doctor Details */}
            <ReusableDataTable
                heading="Doctor Details"
                subHeading="Doctor information"
                data={data?.doctorDetails ?? []}
                head={
                    <>
                        <TableHead>Doctor Name</TableHead>
                        <TableHead>Specialization</TableHead>
                        <TableHead>Clinic Name</TableHead>
                        <TableHead>City</TableHead>
                        <TableHead>Country</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Registration Number</TableHead>
                        {/* <TableHead>Status</TableHead> */}

                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>{row.fullname}</TableCell>
                        <TableCell>{row.specialization}</TableCell>
                        <TableCell>{row.clinicName}</TableCell>
                        <TableCell>{row.city}</TableCell>
                        <TableCell>{row.country}</TableCell>
                        <TableCell>{row.email || "N/A"}</TableCell>
                        <TableCell>{row.doctorRegistrationNumber || "N/A"}</TableCell>
                        {/* <TableCell>
                            <ReusableSelect
                                label=""
                                placeholder="Select"
                                value={row.status}
                                onChange={(val) =>
                                    doctorDetail.mutate({
                                        id: row._id,
                                        status: val,
                                    })
                                }
                                options={statusOptions}
                            />
                        </TableCell> */}
                    </>
                )}
            </ReusableDataTable>

            {/* Prescription Details */}
            <ReusableDataTable
                heading="Prescription"
                subHeading="All Prescription"
                data={data?.prescriptions ?? []}
                head={
                    <>
                        <TableHead>Document</TableHead>
                        <TableHead>Status</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>
                            <div className="flex items-center gap-2 flex-wrap">
                                {row?.documents.map((doc, index) => {
                                    const fileUrl = getImageUrl(doc?.url as any);

                                    return (
                                        <div key={doc?.url as any || index}>
                                            {isImage(fileUrl) ? (
                                                <img
                                                    src={fileUrl}
                                                    alt="Prescription"
                                                    className="w-20 h-20 object-cover rounded-md border cursor-pointer hover:opacity-80"
                                                    onClick={() =>
                                                        setPreview({ url: fileUrl, type: "image" })
                                                    }
                                                />
                                            ) : isPdf(fileUrl) ? (
                                                <div
                                                    onClick={() =>
                                                        setPreview({ url: fileUrl, type: "pdf" })
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
                                })}
                            </div>
                        </TableCell>

                        <TableCell>
                            <ReusableSelect
                                label=""
                                placeholder="Select"
                                value={row.status}
                                onChange={(val) =>
                                    prescription.mutate({
                                        id: row._id,
                                        status: val,
                                    })
                                }
                                options={statusOptions}
                            />
                        </TableCell>
                    </>
                )}
            </ReusableDataTable>

            {/* KYC Details */}
            <ReusableDataTable
                heading="KYC Details"
                subHeading="All KYC Documents"
                data={data?.kycs ?? []}
                head={
                    <>
                        <TableHead>Document Type</TableHead>
                        <TableHead>Document Number</TableHead>
                        <TableHead>Front Image</TableHead>
                        <TableHead>Back Image</TableHead>
                        <TableHead>Status</TableHead>
                    </>
                }
            >
                {(row) => {
                    const frontUrl = getImageUrl(row?.documents[0]?.url as any);
                    const backUrl = getImageUrl(row?.documents[1]?.url as any);

                    return (
                        <>
                            <TableCell>{row.documentType}</TableCell>
                            <TableCell>{row.documentNumber}</TableCell>

                            {/* Front Document */}
                            <TableCell>
                                {frontUrl && (
                                    <div
                                        className="cursor-pointer"
                                        onClick={() =>
                                            setPreview({
                                                url: frontUrl,
                                                type: isPdf(frontUrl) ? "pdf" : "image",
                                            })
                                        }
                                    >
                                        {isImage(frontUrl) ? (
                                            <img
                                                src={frontUrl}
                                                alt="Front Document"
                                                className="w-20 h-20 object-cover rounded-md border hover:opacity-80"
                                            />
                                        ) : isPdf(frontUrl) ? (
                                            <div className="w-20 h-20 flex items-center justify-center border rounded-md bg-muted">
                                                📄 PDF
                                            </div>
                                        ) : (
                                            <div className="w-20 h-20 flex items-center justify-center border rounded-md text-xs">
                                                File
                                            </div>
                                        )}
                                    </div>
                                )}
                            </TableCell>

                            {/* Back Document */}
                            <TableCell>
                                {backUrl && (
                                    <div
                                        className="cursor-pointer"
                                        onClick={() =>
                                            setPreview({
                                                url: backUrl,
                                                type: isPdf(backUrl) ? "pdf" : "image",
                                            })
                                        }
                                    >
                                        {isImage(backUrl) ? (
                                            <img
                                                src={backUrl}
                                                alt="Back Document"
                                                className="w-20 h-20 object-cover rounded-md border hover:opacity-80"
                                            />
                                        ) : isPdf(backUrl) ? (
                                            <div className="w-20 h-20 flex items-center justify-center border rounded-md bg-muted">
                                                📄 PDF
                                            </div>
                                        ) : (
                                            <div className="w-20 h-20 flex items-center justify-center border rounded-md text-xs">
                                                File
                                            </div>
                                        )}
                                    </div>
                                )}
                            </TableCell>

                            <TableCell>
                                <ReusableSelect
                                    label=""
                                    placeholder="Select"
                                    value={row.status}
                                    onChange={(val) =>
                                        kyc.mutate({
                                            id: row._id,
                                            status: val,
                                        })
                                    }
                                    options={statusOptions}
                                />
                            </TableCell>
                        </>
                    );
                }}
            </ReusableDataTable>

            {/* Medicine Quotation Request Documents */}
            <ReusableDataTable
                heading="Medicine Quotation Request"
                subHeading="All Medicine Quotation Documents"
                data={data?.medicineQuotation ?? []}
                head={
                    <>
                        <TableHead>Document Type</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Action</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>Medicine Quotation</TableCell>

                        <TableCell>{row?.status}</TableCell>

                        <TableCell>
                            <DocumentRequest row={row} documentType='medicine_quotation' />
                        </TableCell>

                    </>
                )}
            </ReusableDataTable>

            {/* Proforma Request Documents */}
            < ReusableDataTable
                heading="Proforma Invoice Request"
                subHeading="All Proforma Invoice Documents"
                data={data?.proformaInvoice ?? []
                }
                head={
                    <>
                        <TableHead>Document Type</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Document</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>
                            Proforma Invoice
                        </TableCell>

                        <TableCell>
                            {row?.status}
                        </TableCell>

                        <TableCell>
                            <DocumentRequest row={row} documentType='proforma_invoice' />
                        </TableCell>

                    </>
                )}
            </ReusableDataTable >

            {/* Import License Documents */}
            < ReusableDataTable
                heading="Import License Request"
                subHeading="All Import License Documents"
                data={data?.importLicense ?? []}
                head={
                    <>
                        <TableHead>Document Type</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Document</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>
                            Import License
                        </TableCell>

                        <TableCell>
                            {row?.status}
                        </TableCell>

                        <TableCell>
                            <DocumentRequest row={row} documentType='import_license' />
                        </TableCell>

                    </>
                )}
            </ReusableDataTable >

            {/* Bank Receipt Details */}
            < ReusableDataTable
                heading="Bank Reciept"
                subHeading="All Bank Reciept"
                data={data?.bankReceipts ?? []}
                head={
                    <>
                        <TableHead>Document</TableHead>
                        <TableHead>Status</TableHead>

                    </>
                }
            >

                {(row) => (
                    <>
                        <TableCell>
                            <div className="flex items-center gap-2 flex-wrap">
                                {row?.documents?.map((doc, index) => {
                                    const fileUrl = getImageUrl(doc?.url as any);

                                    return (
                                        <div key={doc?.url as any || index}>
                                            {isImage(fileUrl) ? (
                                                <img
                                                    src={fileUrl}
                                                    alt="Prescription"
                                                    className="w-20 h-20 object-cover rounded-md border cursor-pointer hover:opacity-80"
                                                    onClick={() =>
                                                        setPreview({ url: fileUrl, type: "image" })
                                                    }
                                                />
                                            ) : isPdf(fileUrl) ? (
                                                <div
                                                    onClick={() =>
                                                        setPreview({ url: fileUrl, type: "pdf" })
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
                                })}
                            </div>
                        </TableCell>

                        <TableCell>
                            <ReusableSelect
                                label=""
                                placeholder="Select"
                                value={row.status}
                                onChange={(val) =>
                                    bankReceipt.mutate({
                                        id: row._id,
                                        status: val,
                                    })
                                }
                                options={statusOptions}
                            />
                        </TableCell>
                    </>
                )}
            </ReusableDataTable >

            {/* Downloadable CDEC Form */}
            <ReusableDataTable
                heading="Upload Downloadable CDEC Document"
                subHeading="You can upload only one document which will be downloadable by caretaker"
                data={[{ action: "Upload Document" }]}
                head={
                    <>
                        <TableHead>Document</TableHead>
                        <TableHead>Action</TableHead>
                    </>
                }
            >
                {(_, index) => {
                    const inputId = `downloadable-cdec-${index}`;

                    return (
                        <>
                            {/* Preview */}
                            <TableCell>
                                {documentUrl ? (
                                    isImage(documentUrl) ? (
                                        <img
                                            src={documentUrl}
                                            alt="CDEC Document"
                                            className="w-20 h-20 object-cover rounded-md border cursor-pointer hover:opacity-80"
                                            onClick={() =>
                                                setPreview({
                                                    url: documentUrl,
                                                    type: "image",
                                                })
                                            }
                                        />
                                    ) : isPdf(documentUrl) ? (
                                        <div
                                            onClick={() =>
                                                setPreview({
                                                    url: documentUrl,
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
                                    )
                                ) : (
                                    <span className="text-sm text-muted-foreground">
                                        No document uploaded
                                    </span>
                                )}
                            </TableCell>

                            {/* Upload */}
                            <TableCell>
                                <div className="flex items-center gap-2">
                                    {/* Upload */}
                                    {!documentUrl && (
                                        <>
                                            <Label htmlFor={`${inputId}-upload`}>
                                                <Button
                                                    type="button"
                                                    variant="outline"
                                                    size="sm"
                                                    disabled={isPending}
                                                    className="cursor-pointer"
                                                    asChild
                                                >
                                                    <span>
                                                        {isPending ? (
                                                            <Loader className="w-4 h-4 animate-spin" />
                                                        ) : (
                                                            <Upload className="w-4 h-4" />
                                                        )}

                                                        Upload
                                                    </span>
                                                </Button>
                                            </Label>

                                            <input
                                                id={`${inputId}-upload`}
                                                type="file"
                                                className="hidden"
                                                onChange={handleFileChange}
                                                disabled={isPending}
                                            />
                                        </>
                                    )}

                                    {/* Update */}
                                    {documentUrl && (
                                        <>
                                            <Label htmlFor={`${inputId}-update`}>
                                                <Button
                                                    type="button"
                                                    variant="secondary"
                                                    size="sm"
                                                    disabled={isPending}
                                                    className="cursor-pointer"
                                                    asChild
                                                >
                                                    <span>
                                                        {isPending ? (
                                                            <Loader className="w-4 h-4 animate-spin" />
                                                        ) : (
                                                            <Upload className="w-4 h-4" />
                                                        )}

                                                        Update
                                                    </span>
                                                </Button>
                                            </Label>

                                            <input
                                                id={`${inputId}-update`}
                                                type="file"
                                                className="hidden"
                                                onChange={handleFileUpdate}
                                                disabled={isPending}
                                            />
                                        </>
                                    )}
                                </div>
                            </TableCell>
                        </>
                    );
                }}
            </ReusableDataTable>

            {/* CDEC Details */}
            <ReusableDataTable
                heading="CDEC"
                subHeading="All CDEC"
                data={data?.cdecs ?? []}

                head={
                    <>
                        <TableHead>Document</TableHead>
                        <TableHead>Status</TableHead>

                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>
                            <div className="flex items-center gap-2 flex-wrap">
                                {row?.documents.map((doc, index) => {
                                    const fileUrl = getImageUrl(doc?.url as any);

                                    return (
                                        <div key={doc?.url as any || index}>
                                            {isImage(fileUrl) ? (
                                                <img
                                                    src={fileUrl}
                                                    alt="Prescription"
                                                    className="w-20 h-20 object-cover rounded-md border cursor-pointer hover:opacity-80"
                                                    onClick={() =>
                                                        setPreview({ url: fileUrl, type: "image" })
                                                    }
                                                />
                                            ) : isPdf(fileUrl) ? (
                                                <div
                                                    onClick={() =>
                                                        setPreview({ url: fileUrl, type: "pdf" })
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
                                })}
                            </div>
                        </TableCell>

                        <TableCell>
                            <ReusableSelect
                                label=""
                                placeholder="Select"
                                value={row.status}
                                onChange={(val) =>
                                    cdec.mutate({
                                        id: row._id,
                                        status: val,
                                    })
                                }
                                options={statusOptions}
                            />
                        </TableCell>
                    </>
                )}
            </ReusableDataTable>


            {/* Add Payment details */}
            <ReusableDataTable
                heading="Add Payment Details"
                subHeading="Add caretaker payment details"
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
                                    <Button>
                                        Fill Details
                                    </Button>
                                </DialogTrigger>

                                <DialogContent className="sm:max-w-[500px]">
                                    <DialogHeader>
                                        <DialogTitle>
                                            Payment Details
                                        </DialogTitle>

                                        <DialogDescription>
                                            Fill caretaker payment information.
                                        </DialogDescription>
                                    </DialogHeader>
                                    <ReusableForm
                                        heading=""
                                        subHeading=""
                                        form={form}
                                        onSubmit={onSubmit}
                                    >

                                        <div className="space-y-2">
                                            <Label className="font-medium pl-1">Payment Received</Label>
                                            <Input {...form.register("paymentReceived")} placeholder="Enter Payment Amount" maxLength={30} allowPattern={/[^0-9.]/g} required />
                                        </div>

                                        <div className="space-y-2">
                                            <Label className="font-medium pl-1">Payment Left</Label>
                                            <Input {...form.register("paymentLeft")} placeholder="Enter Rest Payment Amount" maxLength={30} allowPattern={/[^0-9.]/g} required />
                                        </div>

                                        <div className="space-y-2">
                                            <Label className="font-medium pl-1">Account Number</Label>
                                            <Input {...form.register("accountNumber")} placeholder="Enter Account Number" maxLength={30} allowPattern={/[^A-Za-z0-9-/ ]/g} required />
                                        </div>

                                        <div className="space-y-2">
                                            <Label className="font-medium pl-1">IFSC Code</Label>
                                            <Input {...form.register("ifsc")} placeholder="Enter IFSC Code" maxLength={30} allowPattern={/[^A-Za-z0-9-/]/g} required />
                                        </div>

                                        <div className="space-y-2">
                                            <Label className="font-medium pl-1">Branch Name</Label>
                                            <Input {...form.register("branch")} placeholder="Enter Branch Name" maxLength={30} allowPattern={/[^A-Za-z ]/g} required />
                                        </div>

                                        <DialogFooter>
                                            <Button
                                                type="submit"
                                                disabled={isCreatingPayment}
                                            >
                                                {isCreatingPayment
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

            {/* Payment details */}
            <ReusableDataTable
                heading="Payment Details"
                subHeading="Caretaker payment details"
                data={payments ?? []}
                head={
                    <>
                        <TableHead>Branch</TableHead>
                        <TableHead>IFSC</TableHead>
                        <TableHead>Account Num.</TableHead>
                        <TableHead>Received Payment</TableHead>
                        <TableHead>Left Payment</TableHead>
                        <TableHead>Date</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        {
                            isError ?
                                <TableCell>Payment details is not exist</TableCell>
                                :
                                <>
                                    <TableCell>{row?.branch}</TableCell>
                                    <TableCell>{row.ifsc}</TableCell>
                                    <TableCell>{row.accountNumber}</TableCell>
                                    <TableCell>{row.paymentReceived}</TableCell>
                                    <TableCell>{row.paymentLeft}</TableCell>
                                    <TableCell><DateDisplay isoString={row.createdAt} /></TableCell>
                                </>
                        }
                    </>
                )}
            </ReusableDataTable>

            {/* Add order details */}
            <ReusableDataTable
                heading="Add Order Details"
                subHeading="Add caretaker order details"
                data={[{ id: id }]}
                head={
                    <>
                        <TableHead>Action</TableHead>
                    </>
                }
            >
                {() => (
                    <>
                        <TableCell>
                            <OrderCreateDialog userId={id} />
                        </TableCell>
                    </>
                )}
            </ReusableDataTable>

            {/* order details */}
            <ReusableDataTable
                heading="Order Details"
                subHeading="Caretaker order details"
                data={order || []}
                head={
                    <>
                        <TableHead>Balance Ammount</TableHead>
                        <TableHead>Total Received</TableHead>
                        <TableHead>Invoice Ammount</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>{row?.balanceAmount}</TableCell>
                        <TableCell>{row?.totalReceived}</TableCell>
                        <TableCell>{row?.invoiceAmount}</TableCell>
                    </>
                )}
            </ReusableDataTable>

            {/* Upload user document */}
            < DocumentUploadDialog id={id} />

            {/* Feedback */}
            <ReusableDataTable
                heading="User Feedback"
                subHeading="All feedback submitted by this user"
                data={feedback ?? []}
                head={
                    <>
                        <TableHead>Rating</TableHead>
                        <TableHead>Message</TableHead>
                        <TableHead>Submitted On</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        {
                            isError ?
                                <TableCell>Feedback details is not exist</TableCell>
                                :
                                <>
                                    <TableCell>{row.rating!}</TableCell>
                                    <TableCell className="max-w-xs truncate">{row.feedback}</TableCell>
                                    <TableCell>
                                        <DateDisplay isoString={row.createdAt} />
                                    </TableCell>
                                </>
                        }
                    </>
                )}
            </ReusableDataTable>

            <FilePreviewDialog
                preview={preview}
                onClose={() => setPreview(null)}
            />
        </>
    );
}



