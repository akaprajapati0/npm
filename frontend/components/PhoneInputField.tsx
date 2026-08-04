"use client";

import { useEffect, useRef, useState } from "react";
import PhoneInput from "react-phone-number-input";
import "react-phone-number-input/style.css";
import { Input } from "@/components/ui/input";

type Props = {
    value: string;
    onChange: (value: string) => void;
    disabled?: boolean;
    type?: string;
};

export default function PhoneInputField({ value, onChange, disabled = false, type }: Props) {
    const [mode, setMode] = useState<"email" | "phone">("email");
    const wrapperRef = useRef<HTMLDivElement>(null);
    const emailInputRef = useRef<HTMLInputElement>(null);

    useEffect(() => {
        if (!value) setMode("email");
    }, [value]);

    // Single effect handles focus for both modes
    useEffect(() => {
        const frame = requestAnimationFrame(() => {
            const input = mode === "phone"
                ? wrapperRef.current?.querySelector("input")
                : emailInputRef.current;
            input?.focus();
        });
        return () => cancelAnimationFrame(frame);
    }, [mode]);

    const handleTextChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const v = e.target.value;
        if (/^\d+$/.test(v)) {
            setMode("phone");
            onChange("");
        } else {
            setMode("email");
            onChange(v);
        }
    };

    const isPhone = mode === "phone" || type === "phone";

    return isPhone ? (
        <div ref={wrapperRef} className="w-full">
            <PhoneInput
                international
                defaultCountry="IN"
                disabled={disabled}
                value={value || undefined}
                onChange={(v) => onChange(v ?? "")}
                inputComponent={Input as any}
                className="w-full"
                limitMaxLength
            />
        </div>
    ) : (
        <Input
            ref={emailInputRef}
            value={value}
            onChange={handleTextChange}
            placeholder="Enter email or phone number"
            inputMode="email"
            allowPattern={/[^a-zA-Z0-9@._-]/g}
            maxLength={50}
        />
    );
}