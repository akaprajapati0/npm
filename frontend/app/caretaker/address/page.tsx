"use client";

import { useForm } from "react-hook-form";
import { Loader2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import { ReusableForm } from "@/components/ReusableForm";

import { AddressFormValues, AddressSchema } from "@/types/schema";
import { zodResolver } from "@hookform/resolvers/zod";
import { useCreateAddress } from '@/hooks/useCreateAddress';
import { useRouter } from 'next/navigation';
import { useState } from 'react';
import api from '@/lib/axios';

export default function Address() {
    const router = useRouter();
    const { mutate, isPending } = useCreateAddress();
    const [open, setOpen] = useState<Boolean>(false);

    const form = useForm<AddressFormValues>({
        resolver: zodResolver(AddressSchema),
        defaultValues: {
            name: "",
            phone: "",
            houseName: "",
            roadName: "",
            city: "",
            state: "",
            country: "",
            pincode: "",
            landmark: "",
            checkMark: false,
            isDefault: true,
        },
    });


    const {
        control,
        register,
        handleSubmit,
        formState: { errors, isSubmitting },
    } = form;


    const handleSkip = async () => {
        try {
            await api.put("/auth/update-progress", {
                progress: "address_skipped"
            });

            router.replace("/home");
        } catch (error) {
            console.log(error);
        }
    };
    const onSubmit = (values: AddressFormValues) => {
        mutate({
            ...values,
            phone: `+91${values.phone}`,
        }, {
            onSuccess: () => {
                setOpen(true)
                setTimeout(() => {
                    setOpen(false)
                    router.replace("/home");
                }, 3000);
            },
        });
    };

    if (open) {
        return (
            <div className="relative flex justify-center items-center bg-white w-full min-h-screen">
                <h1 className='font-bold absolute z-50 leading-tight tracking-wider bg-linear-to-b from-[#0040C6] to-[#00FF99] bg-clip-text text-transparent mb-1 text-4xl text-center'>India’s Leading <br /> Partner in Named <br /> Patient Medicine <br /> Access</h1>
            </div>
        )
    }

    return (
        <div className="min-h-screen bg-white md:bg-gray-100 flex justify-center items-center md:py-4">
            <ReusableForm
                onSkip={handleSkip}
                heading="Add Delivery Address"
                subHeading="Enter the address where you would like your medicines to be delivered."
                form={form}
                onSubmit={handleSubmit(onSubmit)}
            >
                <h2 className="font-medium">Contact Details :</h2>

                <div className="space-y-1">
                    <Label>Contact Person Name (Optional)</Label>
                    <Input {...register("name")} placeholder="Enter Your Name"
                        className='capitalize'
                        maxLength={30} allowPattern={/[^A-Za-z -]/g} />
                    {errors.name && (
                        <p className="text-sm text-red-500">
                            {errors.name.message}
                        </p>
                    )}
                </div>

                <div className="space-y-1">
                    <Label>Phone Number</Label>
                    <div className="flex items-center gap-1">
                        <span className="border p-1 shadow rounded-sm w-20">
                            IN +91
                        </span>
                        <Input
                            {...register("phone")}
                            placeholder="Enter phone number"
                            maxLength={10}
                            allowPattern={/[^0-9]/g}
                        />
                    </div>
                    {errors.phone && (
                        <p className="text-sm text-red-500">
                            {errors.phone.message}
                        </p>
                    )}
                </div>

                <h2 className="font-medium">Address Details :</h2>

                <div className="space-y-1">
                    <Label>House no / Building Name</Label>
                    <Input {...register("houseName")} placeholder='Enter house no / Building name' className='capitalize' maxLength={30} allowPattern={/[^A-Za-z0-9 -]/g} />
                    {errors.houseName && (
                        <p className="text-sm text-red-500">
                            {errors.houseName.message}
                        </p>
                    )}
                </div>

                <div className="space-y-1">
                    <Label>Road / Area / Colony</Label>
                    <Input {...register("roadName")}
                        placeholder='Enter road name / Area /Colony' className='capitalize' maxLength={30} allowPattern={/[^A-Za-z -]/g} />
                    {errors.roadName && (
                        <p className="text-sm text-red-500">
                            {errors.roadName.message}
                        </p>
                    )}
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <div className="space-y-2">
                        <Label>City</Label>
                        <Input {...register("city")} placeholder='Enter City' className='capitalize' maxLength={30} allowPattern={/[^A-Za-z -]/g} />
                        {errors.city && (
                            <p className="text-sm text-red-500">
                                {errors.city.message}
                            </p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <Label>State</Label>
                        <Input {...register("state")} placeholder='Enter State' className='capitalize' maxLength={30} allowPattern={/[^A-Za-z -]/g} />
                        {errors.state && (
                            <p className="text-sm text-red-500">
                                {errors.state.message}
                            </p>
                        )}
                    </div>
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <div className="space-y-1">
                        <Label>Country</Label>
                        <Input {...register("country")} placeholder='Enter Country' className='capitalize' maxLength={30} allowPattern={/[^A-Za-z -]/g} />
                        {errors.country && (
                            <p className="text-sm text-red-500">
                                {errors.country.message}
                            </p>
                        )}
                    </div>

                    <div className="space-y-1">
                        <Label>Pincode</Label>
                        <Input {...register("pincode")} placeholder='Enter Pincode' maxLength={6} allowPattern={/[^0-9]/g} />
                        {errors.pincode && (
                            <p className="text-sm text-red-500">
                                {errors.pincode.message}
                            </p>
                        )}
                    </div>
                </div>

                <div className="space-y-1">
                    <Label>Landmark (Optional)</Label>
                    <Input {...register("landmark")} placeholder='Enter Landmark / near location / famouse place' className='capitalize' maxLength={30} allowPattern={/[^A-Za-z0-9 -]/g} />
                </div>

                <div className="flex items-center gap-2">
                    <input
                        type="checkbox"
                        {...form.register("checkMark")}
                        className="h-4 w-4"
                    />
                    <Label className="text-sm opacity-70">
                        I declare this is my current delivery address
                    </Label>
                </div>

                {errors.checkMark && (
                    <p className="text-sm text-red-500">
                        {errors.checkMark.message}
                    </p>
                )}

                <Button
                    type="submit"
                    className="w-full mt-6"
                    disabled={!form.watch("checkMark") || isPending}
                >
                    {isPending ? (
                        <span className="flex items-center gap-2">
                            <Loader2 className="h-4 w-4 animate-spin" />
                            Saving...
                        </span>
                    ) : (
                        "Save Address"
                    )}
                </Button>
            </ReusableForm>
        </div>
    );
}
