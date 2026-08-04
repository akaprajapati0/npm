"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";

import GoBackBtn from "@/components/GoBackBtn";

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog";

import { Button } from "@/components/ui/button";

import { Loader2 } from "lucide-react";

import useAuth from "@/store/useAuth";

import { toast } from "sonner";
import { useDeactivateAccount } from '@/hooks/useAuthMutations';

export default function Deactivate() {
    const router = useRouter();

    const { clearAuth } = useAuth();

    const [open, setOpen] =
        useState(false);

    const { mutate, isPending } = useDeactivateAccount();

    const handleDeactivate = () => {
        mutate(undefined, {
            onSuccess: () => {
                // clear frontend auth
                clearAuth();

                toast.success(
                    "Account deactivated successfully"
                );

                router.replace("/caretaker");
            },

            onError: (
                error: any
            ) => {
                toast.error(
                    error?.response?.data
                        ?.message ||
                    "Failed to deactivate account"
                );
            },
        });
    };

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn
                href="/home/deactivate-account"
                ariaLabel="back to deactivate account"
            />

            <div className="px-4 space-y-6 max-w-2xl">
                <h1 className="text-base sm:text-xl font-semibold">
                    Deactivate my account
                </h1>

                <p className="text-xs sm:text-sm leading-6 text-muted-foreground">
                    If you proceed with deactivation, this action will permanently delete your payment history, order history, and login information from your account. However, you may request data recovery by contacting us at <span className="text-primary">info@namedpatinetprogram.com</span> Our support team will assist you with further verification and possible restoration of your account data.
                </p>

                <AlertDialog
                    open={open}
                    onOpenChange={setOpen}
                >
                    <AlertDialogTrigger
                        asChild
                    >
                        <Button
                            variant="destructive"
                            className="w-full sm:w-auto"
                        >
                            Deactivate
                            Account
                        </Button>
                    </AlertDialogTrigger>

                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                Are you sure?
                            </AlertDialogTitle>

                            <AlertDialogDescription>
                                This will
                                deactivate your
                                account
                                immediately.

                                <br />
                                <br />

                                Your account
                                data will be
                                permanently
                                deleted after
                                90 days.
                            </AlertDialogDescription>
                        </AlertDialogHeader>

                        <AlertDialogFooter>
                            <AlertDialogCancel>
                                Cancel
                            </AlertDialogCancel>

                            <AlertDialogAction
                                onClick={
                                    handleDeactivate
                                }
                                disabled={
                                    isPending
                                }
                            >
                                {isPending ? (
                                    <span className="flex items-center gap-2">
                                        <Loader2 className="h-4 w-4 animate-spin" />
                                        Processing...
                                    </span>
                                ) : (
                                    "Yes, deactivate"
                                )}
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </div>
    );
}