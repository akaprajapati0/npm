"use client";

import { Select, SelectTrigger, SelectContent, SelectItem, SelectValue } from "@/components/ui/select";
import { Label } from "@/components/ui/label";

interface Option {
    label: string;
    value: string;
}

interface ReusableSelectProps {
    label: string;
    options: Option[];
    placeholder?: string;
    value?: string;
    onChange?: (value: string) => void;
    onBlur?: () => void;
    name?: string;
}

export function ReusableSelect({
    label,
    options,
    placeholder,
    value,
    onChange,
}: ReusableSelectProps) {
    return (
        <div className="w-full space-y-2">
            <Label className="font-medium pl-1">{label}</Label>

            <Select value={value} onValueChange={onChange}>
                <SelectTrigger className="w-full cursor-pointer">
                    <SelectValue placeholder={placeholder || "Select option"} />
                </SelectTrigger>

                <SelectContent>
                    {options.map((item) => (
                        <SelectItem key={item.value} value={item.value}>
                            {item.label}
                        </SelectItem>
                    ))}
                </SelectContent>
            </Select>
        </div>
    );
}
