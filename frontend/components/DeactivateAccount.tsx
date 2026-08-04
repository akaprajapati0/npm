"use client";

import { useState, useRef } from "react";
import {
    AlertDialog,
    AlertDialogContent,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogDescription,
    AlertDialogFooter,
} from "@/components/ui/alert-dialog";
import { Button } from "@/components/ui/button";
import { AlertTriangle, CheckCircle2 } from "lucide-react";

export default function DeactivateAccount() {
    const [showConfirm, setShowConfirm] = useState(false);
    const [showSuccess, setShowSuccess] = useState(false);
    const triggerRef = useRef<HTMLButtonElement>(null);

    const handleOpenConfirm = () => {
        triggerRef.current?.blur(); // release focus before dialog opens
        setShowConfirm(true);
    };

    const handleDeactivate = () => {
        setShowConfirm(false);
        setTimeout(() => setShowSuccess(true), 150);
    };

    const handleSuccessClose = () => {
        setShowSuccess(false);
        setTimeout(() => triggerRef.current?.focus(), 150); // return focus after close
    };

    return (
        <>
            <Button
                ref={triggerRef}
                variant="destructive"
                onClick={handleOpenConfirm}
                className='w-full'
            >
                Deactivate Account
            </Button>

            {/* Confirmation Dialog */}
            <AlertDialog open={showConfirm} onOpenChange={setShowConfirm}>
                <AlertDialogContent className="max-w-sm text-center">
                    <AlertDialogHeader className="items-center">
                        <div className="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 mb-2">
                            <AlertTriangle className="w-6 h-6 text-amber-600" />
                        </div>
                        <AlertDialogTitle>Deactivate Account?</AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to deactivate your account? This action can
                            be reversed later.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter className="flex-row justify-center gap-2 sm:justify-center">
                        <Button
                            variant="outline"
                            onClick={() => setShowConfirm(false)}
                            className="flex-1"
                        >
                            No
                        </Button>
                        <Button
                            variant="destructive"
                            onClick={handleDeactivate}
                            className="flex-1"
                        >
                            Yes, deactivate
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

            {/* Success Dialog */}
            <AlertDialog open={showSuccess} onOpenChange={setShowSuccess}>
                <AlertDialogContent className="max-w-sm text-center">
                    <AlertDialogHeader className="items-center">
                        <div className="flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-2">
                            <CheckCircle2 className="w-6 h-6 text-green-600" />
                        </div>
                        <AlertDialogTitle>Account Deactivated</AlertDialogTitle>
                        <AlertDialogDescription>
                            Your account has been successfully deactivated. You can reactivate
                            it anytime by logging back in.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter className="justify-center sm:justify-center">
                        <Button onClick={handleSuccessClose} className="w-full">
                            Done
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
}