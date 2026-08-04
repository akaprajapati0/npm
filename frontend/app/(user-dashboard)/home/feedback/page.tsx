"use client";

import { useCallback } from "react";
import GoBackBtn from "@/components/GoBackBtn";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { Facebook, Instagram, PawPrintIcon, Smile, Twitter } from "lucide-react";
import { ReusableForm } from "@/components/ReusableForm";
import { useForm, Controller } from "react-hook-form";
import { useSubmitFeedback } from "@/hooks/useFeedback";
import { successToast } from "@/utils/toast";
import type { LucideIcon } from "lucide-react";


const RATING_SCALE = [1, 2, 3, 4, 5] as const;

type SocialLink = { icon: LucideIcon; label: string; href: string };

const SOCIAL_LINKS: SocialLink[] = [
    { icon: Facebook, label: "Facebook", href: "https://facebook.com" },
    { icon: Instagram, label: "Instagram", href: "https://instagram.com" },
    { icon: Twitter, label: "Twitter", href: "https://twitter.com" },
    { icon: PawPrintIcon, label: "Other", href: "#" },
];

const FOLLOW_UP_OPTIONS = [
    { label: "Yes", value: true },
    { label: "No", value: false },
] as const;


interface FormValues {
    rating: number;
    feedback: string;
    followUp: boolean;
}

interface RatingItemProps {
    value: number;
    isActive: boolean;
    onClick: (value: number) => void;
}

function RatingItem({ value, isActive, onClick }: RatingItemProps) {
    return (
        <div onClick={() => onClick(value)} className="flex flex-col items-center cursor-pointer">
            <Smile
                className={`h-8 w-8 rounded-full p-1 transition-all duration-200 ${isActive
                    ? "bg-yellow-300 text-black scale-110 shadow-md"
                    : "bg-gray-200 text-gray-400 opacity-50"
                    }`}
            />
            <span className={`text-sm mt-1 ${isActive ? "text-yellow-400 font-semibold" : "text-gray-400"}`}>
                {value}
            </span>
        </div>
    );
}

// Reusable inline error message
function FieldError({ message }: { message?: string }) {
    if (!message) return null;
    return <p className="text-sm text-red-500 mt-1">{message}</p>;
}


export default function Feedback() {
    const { mutate, isPending } = useSubmitFeedback();

    const form = useForm<FormValues>({
        defaultValues: { rating: 0, feedback: "", followUp: false },
    });

    const {
        register,
        control,
        watch,
        setValue,
        reset,
        formState: { errors },
    } = form;

    const onSubmit = useCallback(
        (data: FormValues) => {
            mutate(
                { rating: data.rating, feedback: data.feedback, followUp: data.followUp },
                {
                    onSuccess: () => {
                        successToast("Feedback submitted");
                        reset();
                    },
                }
            );
        },
        [mutate, reset]
    );

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home" ariaLabel="Back to dashboard" />

            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]">
                <ReusableForm
                    heading="We Value Your Feedback"
                    subHeading="Help us improve by sharing your experience with our service and delivery."
                    form={form}
                    onSubmit={onSubmit}
                >

                    {/* ── Rating ── */}
                    <div className="space-y-1">
                        <Controller
                            name="rating"
                            control={control}
                            rules={{ required: "Rating is required", min: { value: 1, message: "Please select a rating" } }}
                            render={({ field }) => (
                                <div className="flex justify-center gap-4">
                                    {RATING_SCALE.map((value) => (
                                        <RatingItem
                                            key={value}
                                            value={value}
                                            isActive={!!field.value && value <= field.value}
                                            onClick={field.onChange}
                                        />
                                    ))}
                                </div>
                            )}
                        />
                        <FieldError message={errors.rating?.message} />
                    </div>

                    {/* ── Feedback Text ── */}
                    <div className="space-y-2">
                        <Label htmlFor="feedback">We'd love to hear your thoughts</Label>
                        <Textarea
                            id="feedback"
                            {...register("feedback", { required: "Feedback is required" })}
                            placeholder="Share your experience..."
                            className={`resize-y ${errors.feedback ? "border-red-500 focus-visible:ring-red-500" : ""}`}
                        />
                        <FieldError message={errors.feedback?.message} />
                    </div>

                    {/* ── Follow-up Permission ── */}
                    <div className="space-y-3">
                        <p className="font-medium">May we follow up on your feedback?</p>
                        <Controller
                            name="followUp"
                            control={control}
                            rules={{ validate: (val) => val !== undefined && val !== null || "Please select an option" }}
                            render={() => (
                                <div className="flex gap-8">
                                    {FOLLOW_UP_OPTIONS.map(({ label, value }) => (
                                        <label key={label} className="flex items-center gap-2 cursor-pointer">
                                            <Input
                                                type="radio"
                                                value={String(value)}
                                                checked={watch("followUp") === value}
                                                onChange={() => setValue("followUp", value, { shouldValidate: true })}
                                            />
                                            {label}
                                        </label>
                                    ))}
                                </div>
                            )}
                        />
                        <FieldError message={errors.followUp?.message} />
                    </div>

                    {/* ── Social Links ── */}
                    <div className="space-y-2">
                        <p className="font-medium">Follow Us On</p>
                        <div className="flex gap-5 text-muted-foreground">
                            {SOCIAL_LINKS.map(({ icon: Icon, label, href }) => (
                                <a key={label} href={href} aria-label={label} target="_blank" rel="noopener noreferrer">
                                    <Icon className="cursor-pointer text-primary font-bold transition hover:scale-110" />
                                </a>
                            ))}
                        </div>
                    </div>

                    {/* ── Submit ── */}
                    <Button type="submit" className="w-full" disabled={isPending}>
                        {isPending ? "Submitting..." : "Share Your Feedback"}
                    </Button>

                </ReusableForm>
            </div>
        </div>
    );
}