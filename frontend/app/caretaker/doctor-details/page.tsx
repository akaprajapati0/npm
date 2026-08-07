"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Loader2 } from "lucide-react";
import { useRouter } from "next/navigation";

import {
    DoctorDetailsSchema,
    DoctorDetailsFormValues,
} from "@/types/schema";

import { ReusableForm } from "@/components/ReusableForm";
import ReusablePopup from '@/components/ui/ReusablePopup';
import { useState } from 'react';
import { useDoctorDetails, useGetDoctorCount } from '@/hooks/useDoctorMutation';
import GoBackBtn from '@/components/GoBackBtn';

export default function DoctorDetailsPage() {
    const router = useRouter();
    const { data, isPending } = useGetDoctorCount()
    const doctorMutation = useDoctorDetails(() => {
        setOpenPopup(true);
    });


    const [openPopup, setOpenPopup] = useState(false);


    const form = useForm<DoctorDetailsFormValues>({
        resolver: zodResolver(DoctorDetailsSchema),
        defaultValues: {
            fullname: "",
            specialization: "",
            clinicName: "",
            country: "",
            city: "",
            doctorRegistrationNumber: "",
            email: "",
        },
    });

    const onSubmit = (values: DoctorDetailsFormValues) => {
        doctorMutation.mutate(values);
    };


    const handlePopupClose = (open: boolean) => {
        setOpenPopup(open);
        if (!open) {
            router.push("/caretaker/upload-document");

        }
    };

    if (isPending) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    return (
        <div className="min-h-screen flex items-center justify-center flex-col bg-white md:bg-gray-100">
            {data > 0 &&
                <div className="flex items-start justify-start w-full top-0">
                    <GoBackBtn href="/home" ariaLabel="back to home" />
                </div>
            }

            <ReusableForm
                heading="Treating Doctor Details"
                subHeading="Provide the prescribing doctor's information to proceed with verification."
                form={form}
                onSubmit={onSubmit}
            >
                <div className="space-y-2">
                    <Label className="font-medium pl-1 relative w-fit">Doctor's Full Name<span className="text-red-400 absolute -right-2 bottom-1">*</span></Label>
                    <Input
                        {...form.register("fullname")}
                        placeholder="Enter full name of the prescribing doctor"
                        allowPattern={/[^A-Za-z ]/g}
                        maxLength={30}
                        className='capitalize'
                    />
                    {form.formState.errors.fullname && (
                        <p className="text-red-600 text-sm pl-1">
                            {form.formState.errors.fullname.message}
                        </p>
                    )}
                </div>

                <div className="space-y-2">
                    <Label className="font-medium pl-1">Specialization</Label>
                    <Input
                        {...form.register("specialization")}
                        placeholder="Enter medical speciality (e.g, Oncologist, Neurologist)"
                        allowPattern={/[^A-Za-z-, ]/g}
                        maxLength={50}
                        className='capitalize'
                    />
                    {form.formState.errors.specialization && (
                        <p className="text-red-600 text-sm pl-1">
                            {form.formState.errors.specialization.message}
                        </p>
                    )}
                </div>

                <div className="space-y-2">
                    <Label className="font-medium pl-1 relative w-fit">Hospital / Clinic Name<span className="text-red-400 absolute -right-2 bottom-1">*</span></Label>
                    <Input
                        {...form.register("clinicName")}
                        placeholder="Enter name of hospital or clinic"
                        allowPattern={/[^A-Za-z-, ]/g}
                        maxLength={50}
                        className='capitalize'
                    />
                    {form.formState.errors.clinicName && (
                        <p className="text-red-600 text-sm pl-1">
                            {form.formState.errors.clinicName.message}
                        </p>
                    )}
                </div>

                <div className="grid grid-cols-2 gap-4">
                    {/* <div>
                            <Controller
                                control={form.control}
                                name="country"
                                render={({ field }) => (
                                    <ReusableSelect
                                        label="Country"
                                        options={country}
                                        value={field.value}
                                        onChange={field.onChange}
                                    />
                                )}
                            /> */}
                    <div className="space-y-2">
                        <Label className="font-medium pl-1 relative w-fit">Country</Label>
                        <Input
                            {...form.register("country")}
                            placeholder="Enter Country Name"
                            allowPattern={/[^A-Za-z-, ]/g}
                            maxLength={50}
                            className='capitalize'
                        />

                        {form.formState.errors.country && (
                            <p className="text-red-600 text-sm pl-1">
                                {form.formState.errors.country.message}
                            </p>
                        )}
                    </div>

                    {/* </div> */}
                    <div className="space-y-2">
                        <Label className="font-medium pl-1 relative w-fit">City</Label>
                        <Input
                            {...form.register("city")}
                            placeholder="Enter City Name"
                            allowPattern={/[^A-Za-z-, ]/g}
                            maxLength={50}
                            className='capitalize'
                        />

                        {form.formState.errors.city && (
                            <p className="text-red-600 text-sm pl-1">
                                {form.formState.errors.city.message}
                            </p>
                        )}
                    </div>
                    {/* <div>
                            <Controller
                                control={form.control}
                                name="city"
                                render={({ field }) => (
                                    <ReusableSelect
                                        label="City"
                                        options={city}
                                        value={field.value}
                                        onChange={field.onChange}
                                    />
                                )}
                            />
                        </div> */}

                </div>

                <div className="space-y-2">
                    <Label className="font-medium pl-1">
                        Doctor's Registration Number
                    </Label>

                    <Input
                        {...form.register("doctorRegistrationNumber")}
                        placeholder="Enter doctor's license or registration number"
                        allowPattern={/[^A-Za-z0-9\-\/]/g}
                        maxLength={20}
                    />

                    {form.formState.errors.doctorRegistrationNumber && (
                        <p className="text-red-600 text-sm pl-1">
                            {form.formState.errors.doctorRegistrationNumber.message}
                        </p>
                    )}
                </div>

                {/* Email */}
                <div className="space-y-2">
                    <Label className="font-medium pl-1">Doctor's Contact Email</Label>
                    <Input
                        type="email"
                        {...form.register("email")}
                        placeholder="Enter official email for verification (if available)"
                        allowPattern={/[^a-zA-Z0-9@._-]/g}
                        maxLength={50}
                    />
                    {form.formState.errors.email && (
                        <p className="text-red-600 text-sm pl-1">
                            {form.formState.errors.email.message}
                        </p>
                    )}
                </div>

                <Button
                    type="submit"
                    disabled={doctorMutation.isPending}
                    className="w-full mt-5 py-6 text-xl font-medium"
                >
                    {doctorMutation.isPending ? (
                        <Loader2 className="h-4 w-4 animate-spin" />
                    ) : (
                        "Continue"
                    )}
                </Button>
            </ReusableForm>

            <ReusablePopup
                open={openPopup}
                onOpenChange={handlePopupClose}
                image="/successfull-popup.svg"
                title="Submission Received"
                description="Thank you! To move forward, please upload your prescription and complete your KYC."
            />
        </div>
    );
}
