"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import Link from "next/link";
import { Loader } from "lucide-react";
import { useRouter } from "next/navigation";
import { useState, useCallback } from "react";

import { useLogin } from "@/hooks/useAuthMutations";
import SocialLoginButtons from "@/components/SocialLoginButtons";
import { ReusableForm } from "@/components/ReusableForm";
import ReusablePopup from "@/components/ui/ReusablePopup";
import { LoginSchema, LoginValues, PROGRESS_ROUTES } from "@/types/schema";
import { useProgressStore } from "@/store/progressStore";
import PhoneInputField from '@/components/PhoneInputField';

export default function LoginPage() {
    const router = useRouter();
    const { mutate, isPending } = useLogin();
    const { setProgress, progress } = useProgressStore();
    const [openPopup, setOpenPopup] = useState(false);

    const form = useForm<LoginValues>({
        resolver: zodResolver(LoginSchema),
        defaultValues: { identifier: "", password: "" },
    });

    const {
        register,
        watch,
        setValue,
        formState: { errors },
    } = form;

    const onSubmit = useCallback(
        (values: LoginValues) => {
            mutate(values, {
                onSuccess: (res) => {
                    setProgress(res?.data?.user?.progress as any);
                    setOpenPopup(true);
                },
            });
        },
        [mutate, setProgress]
    );

    const handlePopupClose = useCallback(() => {
        setOpenPopup(false);
        router.replace(PROGRESS_ROUTES[progress!] ?? "/home");
    }, [router, progress]);

    return (
        <div className="flex items-center justify-center min-h-screen sm:bg-gray-100 py-4">
            <ReusableForm
                heading="Access Your Account"
                subHeading="Securely manage medicine requests documents and regulatory approvals."
                form={form}
                onSubmit={onSubmit}
            >
                {/* Identifier */}
                <div className="space-y-2 mt-5">
                    <Label className="font-normal">Email or phone number</Label>
                    <PhoneInputField
                        value={watch("identifier")}
                        onChange={(v) => setValue("identifier", v, { shouldValidate: true })}
                    />
                    {errors.identifier && (
                        <p className="text-red-600 text-sm pl-1">{errors.identifier.message}</p>
                    )}
                </div>

                {/* Password */}
                <div className="space-y-2">
                    <Label className="font-normal">Password</Label>
                    <Input
                        type="password"
                        {...register("password")}
                        placeholder="Enter Your Password"
                        maxLength={20}
                    />
                    {errors.password && (
                        <p className="text-red-600 text-sm pl-1">{errors.password.message}</p>
                    )}
                </div>

                <div className="w-full flex justify-end">
                    <Link href="/update-password" className="text-xs font-bold text-primary">
                        Reset password
                    </Link>
                </div>

                <Button type="submit" className="w-full text-xl py-6" disabled={isPending}>
                    {isPending ? (
                        <span className="flex items-center gap-2 ">
                            <Loader className="h-4 w-4 animate-spin" />
                            Processing...
                        </span>
                    ) : (
                        "Login here"
                    )}
                </Button>

                <div className="flex items-center w-full gap-3 my-5">
                    <span className="w-full border border-black/30" />
                    <p className="text-nowrap text-sm">Or continue with quick sign-in</p>
                    <span className="w-full border border-black/30" />
                </div>

                <SocialLoginButtons />

                <p className="text-center text-xs">
                    Don't have an account?{" "}
                    <Link href="/sign-up" className="text-primary">
                        Sign up here
                    </Link>
                </p>
            </ReusableForm>

            <ReusablePopup
                open={openPopup}
                onOpenChange={handlePopupClose}
                image="/login-popup.svg"
                title="Welcome! to the Named Patient Program"
                description="Get the medicines you need from over 20,000 options worldwide while easily managing prescriptions and requests"
            />
        </div>
    );
}