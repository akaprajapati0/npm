"use client";

import { useState } from "react";
import { Plus } from "lucide-react";
import {
    Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { useAdminRegister } from "@/hooks/useAdmin";
import { AdminForm } from './adminForm';

export function CreateAdminDialog() {
    const [open, setOpen] = useState(false);
    const registerMutation = useAdminRegister();

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button size="sm">
                    <Plus className="mr-2 h-4 w-4" />
                    Create Admin
                </Button>
            </DialogTrigger>

            <DialogContent aria-describedby={undefined}>
                <DialogHeader>
                    <DialogTitle>Create Admin</DialogTitle>
                </DialogHeader>

                <AdminForm
                    mode="create"
                    isLoading={registerMutation.isPending}
                    onSubmit={(values) => {
                        registerMutation.mutate(
                            {
                                ...values,
                                expiresAt:
                                    values.role === "TEMP_ADMIN" && values.expiresAt
                                        ? values.expiresAt
                                        : undefined,
                            },
                            {
                                onSuccess: () => setOpen(false),
                            }
                        );
                    }}
                />
            </DialogContent>
        </Dialog>
    );
}

// "use client";

// import { useState } from "react";
// import { Plus, Eye, EyeOff, CalendarIcon } from "lucide-react";
// import { Button } from "@/components/ui/button";
// import { Input } from "@/components/ui/input";
// import { Label } from "@/components/ui/label";
// import {
//     Dialog, DialogContent, DialogDescription,
//     DialogFooter, DialogHeader, DialogTitle, DialogTrigger,
// } from "@/components/ui/dialog";
// import {
//     Select, SelectContent, SelectItem, SelectTrigger, SelectValue,
// } from "@/components/ui/select";
// import {
//     Popover, PopoverContent, PopoverTrigger,
// } from "@/components/ui/popover";
// import { Calendar } from "@/components/ui/calendar";
// import { format } from "date-fns";

// import { useForm, useWatch } from "react-hook-form";
// import { zodResolver } from "@hookform/resolvers/zod";
// import {
//     AdminRegisterFormValues,
//     AdminRegisterSchema,
//     AdminRole,
//     AdminRegisterPayload,
// } from "@/types/adminSchema";
// import { useAdminRegister } from "@/hooks/useAdmin";
// import { Loader2 } from "lucide-react";

// interface CreateAdminDialogProps {
//     onCreated?: () => void;
// }

// export function CreateAdminDialog({ onCreated }: CreateAdminDialogProps) {
//     const adminRegisterMutation = useAdminRegister();
//     const [open, setOpen] = useState(false);
//     const [showPassword, setShowPassword] = useState(false);

//     const form = useForm<AdminRegisterFormValues>({
//         resolver: zodResolver(AdminRegisterSchema),
//         defaultValues: {
//             email: "",
//             password: "",
//             role: "ADMIN",
//             expiresAt: undefined,
//         },
//     });

//     const role = useWatch({
//         control: form.control,
//         name: "role",
//     });

//     const expiresAt = useWatch({
//         control: form.control,
//         name: "expiresAt",
//     });

//     const handleSubmit = (values: AdminRegisterFormValues) => {
//         const payload: AdminRegisterPayload = {
//             fullname: values.fullname,
//             email: values.email,
//             password: values.password,
//             role: values.role,
//             expiresAt:
//                 values.role === "TEMP_ADMIN" && values.expiresAt
//                     ? values.expiresAt.toISOString()
//                     : undefined,
//         };

//         adminRegisterMutation.mutate(payload as any, {
//             onSuccess: () => {
//                 form.reset();
//                 setOpen(false);
//                 onCreated?.();
//             },
//         });
//     };

//     return (
//         <Dialog open={open} onOpenChange={setOpen}>
//             <DialogTrigger asChild>
//                 <Button size="sm" className="gap-1.5 h-8 text-xs">
//                     <Plus className="h-3.5 w-3.5" />
//                     Create Admin
//                 </Button>
//             </DialogTrigger>

//             <DialogContent className="sm:max-w-[440px]">
//                 <DialogHeader>
//                     <DialogTitle>Create Admin Account</DialogTitle>
//                     <DialogDescription>
//                         Create an Admin or Temporary Admin account. Only Super Admins can perform this action.
//                     </DialogDescription>
//                 </DialogHeader>

//                 <form
//                     onSubmit={form.handleSubmit(handleSubmit)}
//                     className="space-y-4 py-2"
//                 >
//                     {/* Fullname */}
//                     <div className="space-y-1.5">
//                         <Label>Fullname</Label>
//                         <Input
//                             placeholder="Enter full name"
//                             {...form.register("fullname")}
//                         />
//                     </div>

//                     {/* Email */}
//                     <div className="space-y-1.5">
//                         <Label>Email Address</Label>
//                         <Input
//                             placeholder="jane@company.com"
//                             {...form.register("email")}
//                         />
//                     </div>

//                     {/* Password */}
//                     <div className="space-y-1.5">
//                         <Label>Password</Label>
//                         <div className="relative">
//                             <Input
//                                 type={showPassword ? "text" : "password"}
//                                 placeholder="Min. 6 chars"
//                                 {...form.register("password")}
//                                 className="pr-9"
//                             />
//                             <button
//                                 type="button"
//                                 onClick={() => setShowPassword((p) => !p)}
//                                 className="absolute right-2.5 top-1/2 -translate-y-1/2"
//                             >
//                                 {showPassword ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
//                             </button>
//                         </div>
//                     </div>

//                     {/* Role */}
//                     <div className="space-y-1.5">
//                         <Label>Role</Label>
//                         <Select
//                             defaultValue={form.getValues("role")}
//                             onValueChange={(value) =>
//                                 form.setValue("role", value as AdminRole)
//                             }
//                         >
//                             <SelectTrigger>
//                                 <SelectValue />
//                             </SelectTrigger>
//                             <SelectContent>
//                                 <SelectItem value="ADMIN">Admin — Read-only</SelectItem>
//                                 <SelectItem value="TEMP_ADMIN">
//                                     Temporary Admin — With expiry
//                                 </SelectItem>
//                             </SelectContent>
//                         </Select>
//                     </div>

//                     {/* Expiry */}
//                     {role === "TEMP_ADMIN" && (
//                         <div className="space-y-1.5">
//                             <Label>Account Expiry</Label>

//                             <Popover>
//                                 <PopoverTrigger asChild>
//                                     <Button
//                                         type="button"
//                                         variant="outline"
//                                         className="w-full justify-start"
//                                     >
//                                         <CalendarIcon className="mr-2 h-4 w-4" />
//                                         {expiresAt
//                                             ? format(expiresAt, "PPP")
//                                             : "Pick a date"}
//                                     </Button>
//                                 </PopoverTrigger>

//                                 <PopoverContent className="w-auto p-0">
//                                     <Calendar
//                                         mode="single"
//                                         selected={expiresAt}
//                                         onSelect={(date) =>
//                                             form.setValue("expiresAt", date)
//                                         }
//                                         disabled={(date) => date < new Date()}
//                                         autoFocus
//                                     />
//                                 </PopoverContent>
//                             </Popover>

//                             <p className="text-xs text-muted-foreground">
//                                 Account will auto-expire on selected date.
//                             </p>
//                         </div>
//                     )}

//                     {/* Info */}
//                     <div className="rounded-lg bg-muted/60 p-3 text-xs space-y-1">
//                         <p className="font-medium">Access granted:</p>
//                         {role === "ADMIN" ? (
//                             <p>Read-only access to all modules</p>
//                         ) : (
//                             <p>Limited read-only access with expiry</p>
//                         )}
//                     </div>

//                     {/* Footer */}
//                     <DialogFooter>
//                         <Button
//                             type="button"
//                             variant="outline"
//                             size="sm"
//                             onClick={() => setOpen(false)}
//                         >
//                             Cancel
//                         </Button>

//                         <Button
//                             type="submit"
//                             size="sm"
//                             disabled={adminRegisterMutation.isPending}
//                         >
//                             {adminRegisterMutation.isPending && (
//                                 <Loader2 className="mr-2 h-4 w-4 animate-spin" />
//                             )}
//                             Create Account
//                         </Button>
//                     </DialogFooter>
//                 </form>
//             </DialogContent>
//         </Dialog>
//     );
// }