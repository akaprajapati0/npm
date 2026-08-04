"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Loader2 } from "lucide-react";

import { useUpdatePassword } from "@/hooks/useAuthMutations";
import {
    UpdatePasswordSchema,
    UpdatePasswordValues,
} from "@/types/schema";

import { ReusableForm } from "@/components/ReusableForm";
import PhoneInputField from "@/components/PhoneInputField";
import { useRouter } from "next/navigation";

interface UpdatePasswordFormProps {
    redirectPath?: string;
    showIdentifierField?: boolean;
}

export default function UpdatePasswordForm({
    redirectPath = "/login",
    showIdentifierField = true,
}: UpdatePasswordFormProps) {
    const router = useRouter();

    const { mutate, isPending } = useUpdatePassword();

    const form = useForm<UpdatePasswordValues>({
        resolver: zodResolver(UpdatePasswordSchema),
        defaultValues: {
            identifier: "",
            // oldPassword: "",
            newPassword: "",
            confirmPassword: "",
        },
    });

    const onSubmit = (data: UpdatePasswordValues) => {
        const { confirmPassword, ...payload } = data;

        mutate(payload, {
            onSuccess: () => {
                if (redirectPath) {
                    router.push(redirectPath);
                }
            },
        });
    };

    return (
        <div className="flex items-center justify-center min-h-screen sm:bg-gray-100 py-4">
            <ReusableForm
                heading="Update Password"
                subHeading="Please enter your details to change your password."
                onSubmit={onSubmit}
                form={form}
            >
                {/* Identifier */}
                {showIdentifierField && (
                    <div className="space-y-2 mt-10">
                        <Label className="font-normal">
                            Email or phone number
                        </Label>

                        <PhoneInputField
                            value={form.watch("identifier")}
                            onChange={(v) =>
                                form.setValue("identifier", v, {
                                    shouldValidate: true,
                                })
                            }
                        />

                        {form.formState.errors.identifier && (
                            <p className="text-red-600 text-sm pl-1">
                                {form.formState.errors.identifier.message}
                            </p>
                        )}
                    </div>
                )}

                {/* Old Password */}
                {/* <div className="space-y-1">
                    <Label>Old Password</Label>

                    <Input
                        type="password"
                        {...form.register("oldPassword")}
                        placeholder="••••••••"
                    />

                    {form.formState.errors.oldPassword && (
                        <p className="text-red-500 text-xs">
                            {form.formState.errors.oldPassword.message}
                        </p>
                    )}
                </div> */}

                {/* New Password */}
                <div className="space-y-1">
                    <Label>New Password</Label>

                    <Input
                        type="password"
                        {...form.register("newPassword")}
                        placeholder="••••••••"
                    />

                    {form.formState.errors.newPassword && (
                        <p className="text-red-500 text-xs">
                            {form.formState.errors.newPassword.message}
                        </p>
                    )}
                </div>

                {/* Confirm Password */}
                <div className="space-y-1">
                    <Label>Confirm New Password</Label>

                    <Input
                        type="password"
                        {...form.register("confirmPassword")}
                        placeholder="••••••••"
                    />

                    {form.formState.errors.confirmPassword && (
                        <p className="text-red-500 text-xs">
                            {form.formState.errors.confirmPassword.message}
                        </p>
                    )}
                </div>

                <Button
                    type="submit"
                    className="w-full"
                    disabled={isPending}
                >
                    {isPending ? (
                        <span className="flex items-center justify-center gap-2">
                            <Loader2 className="h-4 w-4 animate-spin" />
                            Processing...
                        </span>
                    ) : (
                        "Update"
                    )}
                </Button>
            </ReusableForm>
        </div>
    );
}