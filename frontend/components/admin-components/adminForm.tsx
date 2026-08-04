"use client";

import { useState } from "react";
import { Eye, EyeOff, CalendarIcon } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Select, SelectContent, SelectItem, SelectTrigger, SelectValue,
} from "@/components/ui/select";
import {
    Popover, PopoverContent, PopoverTrigger,
} from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { format } from "date-fns";

import { useForm, useWatch } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import {
    AdminRegisterFormValues,
    AdminRegisterSchema,
    AdminRole,
} from "@/types/adminSchema";
import { Loader2 } from "lucide-react";

interface AdminFormProps {
    defaultValues?: Partial<AdminRegisterFormValues>;
    onSubmit: (values: AdminRegisterFormValues) => void;
    isLoading?: boolean;
    mode?: "create" | "update";
}

export function AdminForm({
    defaultValues,
    onSubmit,
    isLoading,
    mode = "create",
}: AdminFormProps) {
    const [showPassword, setShowPassword] = useState(false);

    const form = useForm<AdminRegisterFormValues>({
        resolver: zodResolver(AdminRegisterSchema),
        defaultValues: {
            fullname: "",
            email: "",
            password: "",
            role: "ADMIN",
            expiresAt: undefined,
            ...defaultValues,
        },
    });

    const role = useWatch({ control: form.control, name: "role" });
    const expiresAt = useWatch({ control: form.control, name: "expiresAt" });

    return (
        <form
            onSubmit={form.handleSubmit(onSubmit)}
            className="space-y-4 py-2"
        >
            {/* Fullname */}
            <div className="space-y-1.5">
                <Label>Fullname</Label>
                <Input {...form.register("fullname")} />
            </div>

            {/* Email */}
            <div className="space-y-1.5">
                <Label>Email</Label>
                <Input {...form.register("email")} />
            </div>

            {/* Password */}
            <div className="space-y-1.5">
                <Label>
                    Password
                </Label>

                <div className="relative">
                    <Input
                        type={showPassword ? "text" : "password"}
                        {...form.register("password")}
                        className="pr-9"
                    />
                    <button
                        type="button"
                        onClick={() => setShowPassword((p) => !p)}
                        className="absolute right-2 top-1/2 -translate-y-1/2"
                    >
                        {showPassword ? <EyeOff size={16} /> : <Eye size={16} />}
                    </button>
                </div>
            </div>

            {/* Role */}
            <div className="space-y-1.5">
                <Label>Role</Label>
                <Select
                    value={role}
                    onValueChange={(value) =>
                        form.setValue("role", value as AdminRole)
                    }
                >
                    <SelectTrigger>
                        <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="ADMIN">Admin — Read-only</SelectItem>
                        <SelectItem value="TEMP_ADMIN">
                            Temporary Admin — With expiry
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>

            {/* Expiry */}
            {role === "TEMP_ADMIN" && (
                <div className="space-y-1.5">
                    <Label>Account Expiry</Label>

                    <Popover>
                        <PopoverTrigger asChild>
                            <Button type="button" variant="outline" className="w-full justify-start">
                                <CalendarIcon className="mr-2 h-4 w-4" />
                                {expiresAt ? format(expiresAt, "PPP") : "Pick a date"}
                            </Button>
                        </PopoverTrigger>

                        <PopoverContent className="w-auto p-0">
                            <Calendar
                                mode="single"
                                selected={expiresAt}
                                onSelect={(date) => form.setValue("expiresAt", date)}
                                disabled={(date) => date < new Date()}
                            />
                        </PopoverContent>
                    </Popover>
                </div>
            )}

            <Button type="submit" className="w-full" disabled={isLoading}>
                {isLoading && <Loader2 className="mr-2 h-4 w-4 animate-spin" />}
                {mode === "create" ? "Create Admin" : "Update Admin"}
            </Button>
        </form>
    );
}