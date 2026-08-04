"use client";

import { useState } from "react";
import { useForm, useFieldArray } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { Loader, Plus, Trash2 } from "lucide-react";

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
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { ReusableForm } from "@/components/ReusableForm";
import { useCreateOrderDetails } from '@/hooks/useOrderMutation';


const paymentEntrySchema = z.object({
    amount: z
        .string()
        .min(1, "Required")
        .refine((val) => !isNaN(Number(val)) && Number(val) > 0, "Enter a valid amount"),
    receivedOn: z.string().min(1, "Date is required"),
});

const createOrderSchema = z.object({
    invoiceAmount: z
        .string()
        .min(1, "Invoice amount is required")
        .refine((val) => !isNaN(Number(val)) && Number(val) > 0, "Enter a valid amount"),
    payments: z.array(paymentEntrySchema),
});

type CreateOrderFormValues = z.infer<typeof createOrderSchema>;

function OrderCreateDialog({ userId }: { userId: string }) {
    const [open, setOpen] = useState(false);

    const form = useForm<CreateOrderFormValues>({
        resolver: zodResolver(createOrderSchema),
        defaultValues: {
            invoiceAmount: "",
            payments: [],
        },
    });

    const { fields, append, remove } = useFieldArray({
        control: form.control,
        name: "payments",
    });

    const { mutate, isPending } = useCreateOrderDetails(() => {
        form.reset();
        setOpen(false);
    });

    const onSubmit = (values: CreateOrderFormValues) => {
        mutate({
            userId,
            invoiceAmount: Number(values.invoiceAmount),
            payments: values.payments.map((p) => ({
                amount: Number(p.amount),
                receivedOn: p.receivedOn,
            })),
        });
    };

    return (
        <Dialog
            open={open}
            onOpenChange={(next) => {
                setOpen(next);
                if (!next) form.reset();
            }}
        >
            <DialogTrigger asChild>
                <Button>Fill Details</Button>
            </DialogTrigger>

            <DialogContent className="sm:max-w-[500px]">
                <DialogHeader>
                    <DialogTitle>Order Details</DialogTitle>
                    <DialogDescription>
                        Enter the invoice amount and add any payments already received.
                    </DialogDescription>
                </DialogHeader>

                <ReusableForm heading="" subHeading="" form={form} onSubmit={onSubmit}>
                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Invoice Amount</Label>
                        <Input
                            {...form.register("invoiceAmount")}
                            placeholder="Enter Invoice Amount"
                            maxLength={12}
                            allowPattern={/[^0-9.]/g}
                        />
                        {form.formState.errors.invoiceAmount && (
                            <p className="text-sm text-destructive pl-1">
                                {form.formState.errors.invoiceAmount.message}
                            </p>
                        )}
                    </div>

                    <div className="space-y-3">
                        <div className="flex items-center justify-between">
                            <Label className="font-medium pl-1">Payments Received</Label>
                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                onClick={() => append({ amount: "", receivedOn: "" })}
                            >
                                <Plus className="h-4 w-4 mr-1" />
                                Add Payment
                            </Button>
                        </div>

                        {fields.length === 0 && (
                            <p className="text-xs text-muted-foreground pl-1">
                                No payments added yet — you can still create the order and add payments later.
                            </p>
                        )}

                        {fields.map((field, index) => (
                            <div key={field.id} className="flex gap-2 items-start border rounded-md p-3">
                                <div className="flex-1 space-y-1">
                                    <Label className="text-xs">Amount</Label>
                                    <Input
                                        {...form.register(`payments.${index}.amount`)}
                                        placeholder="Amount"
                                        allowPattern={/[^0-9.]/g}
                                    />
                                    {form.formState.errors.payments?.[index]?.amount && (
                                        <p className="text-xs text-destructive">
                                            {form.formState.errors.payments[index]?.amount?.message}
                                        </p>
                                    )}
                                </div>

                                <div className="flex-1 space-y-1">
                                    <Label className="text-xs">Date Received</Label>
                                    <Input
                                        type="date"
                                        {...form.register(`payments.${index}.receivedOn`)}
                                    />
                                    {form.formState.errors.payments?.[index]?.receivedOn && (
                                        <p className="text-xs text-destructive">
                                            {form.formState.errors.payments[index]?.receivedOn?.message}
                                        </p>
                                    )}
                                </div>

                                <button
                                    type="button"
                                    onClick={() => remove(index)}
                                    className="mt-6 text-destructive"
                                    aria-label="Remove payment"
                                >
                                    <Trash2 className="h-4 w-4" />
                                </button>
                            </div>
                        ))}
                    </div>

                    <DialogFooter>
                        <Button type="submit" disabled={isPending}>
                            {isPending ? <Loader /> : "Submit"}
                        </Button>
                    </DialogFooter>
                </ReusableForm>
            </DialogContent>
        </Dialog>
    );
}

export default OrderCreateDialog;