"use client";

import { useForm } from "react-hook-form";
import { useRouter } from "next/navigation";
import Link from "next/link";
import { Loader, Loader2 } from "lucide-react";
import { zodResolver } from "@hookform/resolvers/zod";
import { useState } from "react";

import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";

import {
    useSendOtpRequest,
    useUserSignUp,
} from "@/hooks/useAuthMutations";

import { ReusableForm } from "@/components/ReusableForm";
import { SignUpSchema, SignUpValues, } from "@/types/schema";

import SocialLoginButtons from "@/components/SocialLoginButtons";
import { useOtpTimer } from "@/hooks/useOtpTimer";

import CountrySelect from "@/components/CountrySelect";

export default function SignUp() {
    const router = useRouter();

    const sendOtp = useSendOtpRequest();
    const signUp = useUserSignUp();

    const otpTimer = useOtpTimer(120);

    const [country, setCountry] =
        useState("IN");

    const form = useForm<SignUpValues>({
        resolver: zodResolver(SignUpSchema),

        // shouldUnregister: true,

        defaultValues: {
            country: "IN",
            phone: "",
            email: "",
            otp: "",
        },
    });

    const {
        register,
        setValue,
        watch,
        trigger,
        formState: { errors },
    } = form;

    // ---------- COUNTRY CHANGE ----------
    const handleCountryChange = (
        value: string
    ) => {
        setCountry(value);

        // sync form country
        setValue("country", value);

        // reset fields
        setValue("phone", "");
        setValue("email", "");
        setValue("otp", "");
    };

    // ---------- Send OTP ----------
    const handleSendOtp = async () => {
        const phone =
            form.getValues("phone");

        const email =
            form.getValues("email");

        // ---------- INDIA PHONE ----------
        if (
            country === "IN" &&
            typeof phone === "string" &&
            phone.trim()
        ) {
            const isPhoneValid =
                await trigger("phone");

            if (!isPhoneValid) return;

            // convert to E.164
            const formattedPhone = `+91${phone.trim()}`;

            sendOtp.mutate(
                {
                    phone:
                        formattedPhone,
                },
                {
                    onSuccess: () =>
                        otpTimer.start(),
                }
            );

            return;
        }

        // ---------- EMAIL ----------
        if (
            typeof email === "string" &&
            email.trim()
        ) {
            const isEmailValid =
                await trigger("email");

            if (!isEmailValid) return;

            sendOtp.mutate(
                {
                    email: email
                        .trim()
                        .toLowerCase(),
                },
                {
                    onSuccess: () =>
                        otpTimer.start(),
                }
            );

            return;
        }
    };

    // ---------- Submit ----------
    const onSubmit = (
        values: SignUpValues
    ) => {
        const payload = {
            ...values,

            country,

            phone:
                country === "IN" &&
                    values.phone
                    ? `+91${values.phone.trim()}`
                    : "",
        };

        signUp.mutate(payload, {
            onSuccess: () => {
                router.replace(
                    "/caretaker/register"
                );
            },
        });
    };


    return (
        <div className="min-h-screen flex items-center justify-center md:py-5 bg-white md:bg-gray-100">
            <ReusableForm
                heading="Sign-up with Email/Phone Number"
                subHeading="New here? Let's get you started"
                form={form}
                onSubmit={onSubmit}
            >
                {/* ---------- COUNTRY ---------- */}

                <div className="space-y-2">
                    <Label className="font-normal">
                        Select Country
                    </Label>

                    <CountrySelect
                        value={country}
                        onChange={
                            handleCountryChange
                        }
                    />
                </div>

                {/* ---------- IDENTIFIER ---------- */}

                <div className="space-y-2 mt-5">
                    <Label className="font-normal">
                        {country === "IN"
                            ? "Phone Number"
                            : "Email Address"}
                    </Label>

                    {country === "IN" ? (
                        <div className="flex items-center gap-2">
                            <span className="border rounded-md px-3 py-2 bg-muted text-sm w-20 text-center">
                                +91
                            </span>

                            <Input
                                placeholder="Enter phone number"
                                maxLength={10}
                                allowPattern={
                                    /[^0-9]/g
                                }
                                value={watch(
                                    "phone"
                                )}
                                onChange={(e) =>
                                    setValue(
                                        "phone",
                                        e.target
                                            .value,
                                        {
                                            shouldValidate:
                                                true,
                                        }
                                    )
                                }
                            />
                        </div>
                    ) : (
                        <Input
                            placeholder="Enter email address"
                            maxLength={50}
                            allowPattern={
                                /[^a-zA-Z0-9@._-]/g
                            }
                            value={watch(
                                "email"
                            )}
                            onChange={(e) =>
                                setValue(
                                    "email",
                                    e.target
                                        .value,
                                    {
                                        shouldValidate:
                                            true,
                                    }
                                )
                            }
                        />
                    )}

                    {/* ---------- SEND OTP ---------- */}

                    <div className="flex justify-end">
                        <button
                            type="button"
                            className="text-xs text-primary disabled:opacity-50 cursor-pointer"
                            disabled={
                                !otpTimer.canResend ||
                                sendOtp.isPending
                            }
                            onClick={
                                handleSendOtp
                            }
                        >
                            {otpTimer.secondsLeft >
                                0 ? (
                                ""
                            ) : sendOtp.isPending ? (
                                <Loader />
                            ) : (
                                "Send OTP"
                            )}
                        </button>
                    </div>
                </div>

                {/* ---------- OTP ---------- */}

                <div className="space-y-2">
                    <Label className="font-normal">
                        Enter OTP
                    </Label>

                    <Input
                        type="text"
                        {...register("otp")}
                        allowPattern={
                            /[^0-9]/g
                        }
                        maxLength={6}
                        placeholder="Enter OTP"
                    />

                    {errors.otp && (
                        <p className="text-red-600 text-sm pl-1">
                            {
                                errors.otp
                                    .message
                            }
                        </p>
                    )}
                </div>

                {/* ---------- OTP TIMER ---------- */}

                {otpTimer.secondsLeft > 0 && (
                    <div className="w-full flex justify-end">
                        <span className="text-xs text-muted-foreground">
                            OTP resend in{" "}
                            {Math.floor(
                                otpTimer.secondsLeft /
                                60
                            )}
                            :
                            {(
                                otpTimer.secondsLeft %
                                60
                            )
                                .toString()
                                .padStart(
                                    2,
                                    "0"
                                )}{" "}
                            min
                        </span>
                    </div>
                )}

                {/* ---------- SUBMIT ---------- */}

                <Button
                    type="submit"
                    className="w-full text-xl py-6 mt-10"
                    disabled={
                        signUp.isPending
                    }
                >
                    {signUp.isPending ? (
                        <span className="flex items-center gap-2">
                            <Loader2 className="h-4 w-4 animate-spin" />
                            Processing...
                        </span>
                    ) : (
                        "Continue"
                    )}
                </Button>

                <SocialLoginButtons />

                <p className="text-center text-xs">
                    Or continue with quick{" "}
                    <Link
                        href="/login"
                        className="text-primary"
                    >
                        sign-in.
                    </Link>
                </p>
            </ReusableForm>
        </div>
    );
}