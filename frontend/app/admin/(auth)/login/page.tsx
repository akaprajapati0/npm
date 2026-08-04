"use client";

import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import {
  AdminLoginSchema,
  AdminLoginValues,
} from "@/types/adminSchema";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { useAdminLogin } from "@/hooks/useAdmin";
import { Loader2 } from "lucide-react";
import { ReusableForm } from "@/components/ReusableForm";
import { useState } from "react";

export default function Login() {
  const login = useAdminLogin();
  const [showPassword, setShowPassword] = useState(false);

  const form = useForm<AdminLoginValues>({
    resolver: zodResolver(AdminLoginSchema),
    defaultValues: { email: "", password: "" },
  });

  const onSubmit = (values: AdminLoginValues) => {
    if (login.isPending) return;
    login.mutate(values);
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-[radial-gradient(#d2f1df,#d3d7fa,#bad8f4)] px-4">
      <ReusableForm
        heading="Admin Login"
        subHeading="Login to your account"
        form={form}
        onSubmit={onSubmit}
      >
        {/* Email */}
        <div className="space-y-2">
          <Label>Email address</Label>
          <Input
            type="email"
            placeholder="example@email.com"
            autoFocus
            disabled={login.isPending}
            {...form.register("email")}
          />
          {form.formState.errors.email && (
            <p className="text-sm text-red-500">
              {form.formState.errors.email.message}
            </p>
          )}
        </div>

        {/* Password */}
        <div className="space-y-2">
          <Label>Password</Label>
          <div className="relative">
            <Input
              type={showPassword ? "text" : "password"}
              placeholder="••••••••"
              disabled={login.isPending}
              {...form.register("password")}
            />

            {/* Show/Hide Toggle */}
            <button
              type="button"
              onClick={() => setShowPassword((prev) => !prev)}
              className="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-muted-foreground"
            >
              {showPassword ? "Hide" : "Show"}
            </button>
          </div>

          {form.formState.errors.password && (
            <p className="text-sm text-red-500">
              {form.formState.errors.password.message}
            </p>
          )}
        </div>

        {/* Submit */}
        <Button
          type="submit"
          className="w-full"
          disabled={login.isPending}
        >
          {login.isPending && (
            <Loader2 className="mr-2 h-4 w-4 animate-spin" />
          )}
          {login.isPending ? "Logging in..." : "Login"}
        </Button>
      </ReusableForm >
    </div >
  );
}