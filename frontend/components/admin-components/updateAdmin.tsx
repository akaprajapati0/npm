"use client";

import {
    Dialog, DialogContent, DialogHeader, DialogTitle,
} from "@/components/ui/dialog";
import { useUpdateAdmin, useGetAdminById } from "@/hooks/useAdmin";
import { Loader2 } from "lucide-react";
import { AdminForm } from './adminForm';

interface Props {
    adminId: string;
    open: boolean;
    setOpen: (val: boolean) => void;
}

export function UpdateAdminDialog({ adminId, open, setOpen }: Props) {
    const { data, isLoading } = useGetAdminById(adminId, open);
    const updateMutation = useUpdateAdmin();

    if (!adminId) return null;

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogContent aria-describedby={undefined}>
                <DialogHeader>
                    <DialogTitle>Update Admin</DialogTitle>
                </DialogHeader>

                {isLoading ? (
                    <div className="flex justify-center py-10">
                        <Loader2 className="animate-spin h-6 w-6" />
                    </div>
                ) : (
                    <AdminForm
                        mode="update"
                        defaultValues={{
                            fullname: data?.admin?.fullname,
                            email: data?.admin?.email,
                            role: data?.admin?.role,
                            expiresAt: data?.admin?.expiresAt
                                ? new Date(data.admin.expiresAt)
                                : undefined,
                        }}
                        isLoading={updateMutation.isPending}
                        onSubmit={(values) => {
                            updateMutation.mutate(
                                {
                                    id: adminId,
                                    ...values,
                                    expiresAt:
                                        values.role === "TEMP_ADMIN" && values.expiresAt
                                            ? values.expiresAt
                                            : undefined,
                                },
                                {
                                    onSuccess: () => setOpen(false),
                                }
                            );
                        }}
                    />
                )}
            </DialogContent>
        </Dialog>
    );
}