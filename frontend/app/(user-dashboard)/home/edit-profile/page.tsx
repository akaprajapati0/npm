"use client";

import { ChangeEvent, Suspense, useEffect, useState } from 'react';
import { Loader2 } from "lucide-react";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm, Controller } from "react-hook-form";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { AddressFormValues, AddressSchema, RegisterFormValues, RegisterSchema } from "@/types/schema";
import { ReusableForm } from "@/components/ReusableForm";
import { ReusableSelect } from "@/components/ReusableSelect";
import { Button } from "@/components/ui/button";
import { useGetCaretaker, useUpdateCaretaker } from '@/hooks/useCaretakerMutation'; // change to your update hook
import { useGetProfile } from '@/hooks/useAuthMutations';
import { getImageUrl } from '@/lib/getImage';
import GoBackBtn from '@/components/GoBackBtn';
import { useGetAddress, useUpsertAddress } from '@/hooks/useCreateAddress';
import { useSearchParams } from 'next/navigation';


function EditProfileContent() {
    const searchParams = useSearchParams();
    const { data, isPending: isProfilePending } = useGetProfile();
    const { data: caretakerData, isPending: isCaretakerPending } = useGetCaretaker()
    const { mutate, isPending } = useUpdateCaretaker();
    const { data: address, isPending: isAddressPending } = useGetAddress();
    const updateAddress = useUpsertAddress();
    const [imageFile, setImageFile] = useState<File | null>(null);
    const [localPreview, setLocalPreview] = useState<string | null>(null);



    const caretaker = caretakerData?.caretaker;
    const patient = caretakerData?.patient;
    const profileImg = data?.user?.image?.url;
    const activeSection = searchParams.get("section") === "delivery-address"
        ? "delivery-address"
        : "user-details";
    const showUserDetails = activeSection === "user-details";
    const showAddressDetails = activeSection === "delivery-address";

    const form = useForm<RegisterFormValues>({
        resolver: zodResolver(RegisterSchema),
        defaultValues: {
            patient: {
                fullname: "",
                dateOfBirth: "",
                gender: "",
            },
            fullname: "",
            email: "",
            relationship: "",
            relationshipOther: "",
            country: "",
            city: "",
            pincode: "",
            phone: "",
            otp: "",
        },
    });

    const addressForm = useForm<AddressFormValues>({
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
            checkMark: true,
            isDefault: true,
        },
    });

    // Prefill all fields when data loads
    useEffect(() => {
        if (!data) return;

        const relationshipRaw = caretaker?.relationship || "";
        const genderRaw = patient?.gender || "";

        // Check if relationship is a known option or "other" (case-insensitive match)
        const knownRelationships = ["father", "mother", "sibling", "spouse", "child"];
        const matchedRelationship = knownRelationships.find(
            (r) => r === relationshipRaw.trim().toLowerCase()
        );
        const isOtherRelationship = relationshipRaw && !matchedRelationship;

        // Check if gender is a known option or "other" (case-insensitive match)
        const knownGenders = ["male", "female", "other"];
        const matchedGender = knownGenders.find(
            (g) => g === genderRaw.trim().toLowerCase()
        );
        const isOtherGender = genderRaw && !matchedGender;

        form.reset({
            patient: {
                fullname: patient?.fullname || "",
                dateOfBirth: patient?.dateOfBirth?.slice(0, 10) || "", // format for date input
                gender: isOtherGender ? "other" : (matchedGender || ""),
            },
            fullname: caretaker?.fullname || "",
            email: caretaker?.email || "",
            relationship: isOtherRelationship ? "other" : (matchedRelationship || ""),
            relationshipOther: isOtherRelationship ? relationshipRaw : "",
            country: caretaker?.country || "",
            city: caretaker?.city || "",
            pincode: caretaker?.pincode || "",
            phone: caretaker?.phone || "",
            otp: "",
        });
    }, [data, caretakerData]);

    useEffect(() => {
        if (!address) return;

        addressForm.reset({
            name: address.name || "",
            phone: address.phone?.replace(/^\+91/, "") || "",
            houseName: address.houseName || "",
            roadName: address.roadName || "",
            city: address.city || "",
            state: address.state || "",
            country: address.country || "",
            pincode: address.pincode || "",
            landmark: address.landmark || "",
            checkMark: true,
            isDefault: address.isDefault ?? true,
        });
    }, [address, addressForm]);


    const onSubmit = (values: RegisterFormValues) => {
        mutate({
            caretakerId: caretaker?._id,
            image: imageFile,
            data: {
                ...values,
                relationship:
                    values.relationship === "other"
                        ? values.relationshipOther?.trim()
                        : values.relationship,
                patient: {
                    ...values.patient,
                    patientId: patient?._id,
                },
            },
        });
    };

    const onAddressSubmit = (values: AddressFormValues) => {
        updateAddress.mutate({
            addressId: address?._id,
            payload: {
                ...values,
                phone: `+91${values.phone}`,
                checkMark: true,
                isDefault: values.isDefault ?? true,
            },
        });
    };

    const handleImageChange = (e: ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (!file) return;

        setImageFile(file);
        setLocalPreview(URL.createObjectURL(file));
    };

    const isLoading = isProfilePending || isCaretakerPending || isAddressPending;

    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href='/home' ariaLabel='back to home' />

            {isLoading ? (
                <div className="flex items-center justify-center min-h-screen">
                    Loading profile...
                </div>
            ) : showUserDetails ? (
                <ReusableForm
                    heading=""
                    subHeading=""
                    form={form}
                    onSubmit={onSubmit}
                >
                    <div className="flex flex-col items-center mb-6">
                        <div className="w-28 h-28 rounded-full overflow-hidden border shrink-0">
                            <img
                                src={
                                    localPreview
                                        ? localPreview
                                        : profileImg && getImageUrl(profileImg)
                                }
                                alt="Profile"
                                className="w-full h-full object-cover p-2"
                            />
                        </div>

                        <label className="mt-3 text-sm text-blue-600 cursor-pointer">
                            Change Photo
                            <input
                                type="file"
                                accept="image/*"
                                onChange={handleImageChange}
                                className="hidden"
                            />
                        </label>
                    </div>
                    {/* -------- PATIENT SECTION -------- */}

                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Medicine Recipient Full Name</Label>
                        <Input
                            {...form.register("patient.fullname")}
                            placeholder="Enter Medicine recipient's full name (as per ID)"
                            maxLength={30}
                            allowPattern={/[^A-Za-z -]/g}
                            className='capitalize'
                        />
                        {form.formState.errors.patient?.fullname && (
                            <p className="text-red-500 text-sm">
                                {form.formState.errors.patient.fullname.message}
                            </p>
                        )}
                    </div>

                    <div className="grid grid-cols-2 gap-4 w-full">
                        <div className="space-y-2">
                            <Label className="font-medium pl-1">Date of Birth</Label>
                            <Input type="date" {...form.register("patient.dateOfBirth")} />
                            {form.formState.errors.patient?.dateOfBirth && (
                                <p className="text-red-500 text-sm">
                                    {form.formState.errors.patient.dateOfBirth.message}
                                </p>
                            )}
                        </div>

                        <div className="space-y-2">
                            <Controller
                                key={`gender-${patient?._id ?? "new"}`}
                                control={form.control}
                                name="patient.gender"
                                render={({ field }) => (
                                    <ReusableSelect
                                        label="Gender"
                                        placeholder="Select gender"
                                        value={field.value}
                                        onChange={(value) => {
                                            field.onChange(value)
                                        }}
                                        options={[
                                            { label: "Male", value: "male" },
                                            { label: "Female", value: "female" },
                                            { label: "Other", value: "other" },
                                        ]}
                                    />
                                )}
                            />


                            {(form.formState.errors.patient?.gender) && (
                                <p className="text-red-500 text-sm">
                                    {form.formState.errors.patient?.gender?.message ||
                                        form.formState.errors.patient?.message}
                                </p>
                            )}
                        </div>
                    </div>

                    {/* -------- CARETAKER SECTION -------- */}

                    <div className="flex items-center w-full gap-3 mt-8">
                        <span className="w-full border border-gray-400"></span>
                        <p className="w-full text-nowrap font-light text-sm">Caretaker Contact Details</p>
                        <span className="w-full border border-gray-400"></span>
                    </div>

                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Caretaker Full Name</Label>
                        <Input
                            {...form.register("fullname")}
                            placeholder="Enter full name (as per ID)"
                            maxLength={30}
                            allowPattern={/[^A-Za-z -]/g}
                            className='capitalize'
                        />
                        {form.formState.errors.fullname && (
                            <p className="text-red-500 text-sm">{form.formState.errors.fullname.message}</p>
                        )}
                    </div>

                    <div className="space-y-2">
                        <Label className="font-medium pl-1">Email ( Optional )</Label>
                        <Input
                            {...form.register("email")}
                            disabled={!!caretaker?.email}
                            placeholder="Enter email address"
                            allowPattern={/[^a-zA-Z0-9@._-]/g}
                            maxLength={50}
                        />
                    </div>

                    <div className="grid grid-cols-2 gap-4 w-full">
                        <div className="space-y-2">
                            <Controller
                                key={`relationship-${caretaker?._id ?? "new"}`}
                                control={form.control}
                                name="relationship"
                                render={({ field }) => (
                                    <ReusableSelect
                                        label="Relationship"
                                        placeholder="Select"
                                        value={field.value}
                                        onChange={(value) => {
                                            field.onChange(value);
                                            if (value !== "other") {
                                                form.setValue("relationshipOther", "");
                                                form.clearErrors("relationshipOther");
                                            }
                                        }}
                                        options={[
                                            { label: "Father", value: "father" },
                                            { label: "Mother", value: "mother" },
                                            { label: "Sibling", value: "sibling" },
                                            { label: "Spouse", value: "spouse" },
                                            { label: "Child", value: "child" },
                                            { label: "Other", value: "other" },
                                        ]}
                                    />
                                )}
                            />

                            {form.watch("relationship") === "other" && (
                                <Input
                                    placeholder="Enter relationship"
                                    {...form.register("relationshipOther", {
                                        required: "Please specify the relationship",
                                    })}
                                    maxLength={30}
                                    allowPattern={/[^A-Za-z0-9-]/g}
                                />
                            )}

                            {(form.formState.errors.relationship ||
                                form.formState.errors.relationshipOther) && (
                                    <p className="text-red-500 text-sm">
                                        {form.formState.errors.relationship?.message ||
                                            form.formState.errors.relationshipOther?.message}
                                    </p>
                                )}
                        </div>

                        <div className="space-y-2">
                            <Label className="font-medium pl-1">Country</Label>
                            <Input
                                {...form.register("country")}
                                placeholder="Enter country name"
                                maxLength={30}
                                allowPattern={/[^A-Za-z -]/g}
                                className='capitalize'
                            />
                            {form.formState.errors.country && (
                                <p className="text-red-500 text-sm">{form.formState.errors.country.message}</p>
                            )}
                        </div>
                    </div>

                    <div className="grid grid-cols-2 gap-4 w-full">
                        <div className="space-y-2">
                            <Label className="font-medium pl-1">City</Label>
                            <Input
                                {...form.register("city")}
                                placeholder="Enter city name"
                                maxLength={30}
                                allowPattern={/[^A-Za-z -]/g}
                                className='capitalize'
                            />
                            {form.formState.errors.city && (
                                <p className="text-red-500 text-sm">{form.formState.errors.city.message}</p>
                            )}
                        </div>
                        <div className="space-y-2">
                            <Label className="font-medium pl-1">Pin Code</Label>
                            <Input
                                {...form.register("pincode")}
                                placeholder="Enter pincode"
                                maxLength={6}
                                allowPattern={/[^0-9]/g}
                            />
                            {form.formState.errors.pincode && (
                                <p className="text-red-500 text-sm">{form.formState.errors.pincode.message}</p>
                            )}
                        </div>
                    </div>

                    {/* -------- PHONE SECTION -------- */}

                    <div className="space-y-2">
                        <Label>Phone Number</Label>

                        <Input
                            {...form.register("phone")}
                            placeholder="Enter phone number"
                            maxLength={10}
                            disabled
                            allowPattern={/[^0-9]/g}
                        />

                    </div>

                    <Button
                        type="submit"
                        className="w-full mt-5 py-6 text-xl font-medium"
                        disabled={isPending}
                    >
                        {isPending ? (
                            <span className="flex items-center justify-center gap-2">
                                <Loader2 className="h-4 w-4 animate-spin" />
                                Updating...
                            </span>
                        ) : (
                            "Update Details"
                        )}
                    </Button>
                </ReusableForm>
            ) : null}

            {!isLoading && showAddressDetails && (
                <ReusableForm
                    heading=""
                    subHeading=""
                    form={addressForm}
                    onSubmit={onAddressSubmit}
                >
                    <div className="flex items-center w-full gap-3">
                        <span className="w-full border border-gray-400"></span>
                        <p className="w-full text-nowrap font-light text-sm">Delivery Address Details</p>
                        <span className="w-full border border-gray-400"></span>
                    </div>

                    <div className="space-y-1">
                        <Label>Contact Person Name (Optional)</Label>
                        <Input
                            {...addressForm.register("name")}
                            placeholder="Enter Your Name"
                            className="capitalize"
                            maxLength={30}
                            allowPattern={/[^A-Za-z -]/g}
                        />
                        {addressForm.formState.errors.name && (
                            <p className="text-sm text-red-500">
                                {addressForm.formState.errors.name.message}
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
                                {...addressForm.register("phone")}
                                placeholder="Enter phone number"
                                maxLength={10}
                                allowPattern={/[^0-9]/g}
                            />
                        </div>
                        {addressForm.formState.errors.phone && (
                            <p className="text-sm text-red-500">
                                {addressForm.formState.errors.phone.message}
                            </p>
                        )}
                    </div>

                    <div className="space-y-1">
                        <Label>House no / Building Name</Label>
                        <Input
                            {...addressForm.register("houseName")}
                            placeholder="Enter house no / Building name"
                            className="capitalize"
                            maxLength={30}
                            allowPattern={/[^A-Za-z0-9 -]/g}
                        />
                        {addressForm.formState.errors.houseName && (
                            <p className="text-sm text-red-500">
                                {addressForm.formState.errors.houseName.message}
                            </p>
                        )}
                    </div>

                    <div className="space-y-1">
                        <Label>Road / Area / Colony</Label>
                        <Input
                            {...addressForm.register("roadName")}
                            placeholder="Enter road name / Area / Colony"
                            className="capitalize"
                            maxLength={30}
                            allowPattern={/[^A-Za-z -]/g}
                        />
                        {addressForm.formState.errors.roadName && (
                            <p className="text-sm text-red-500">
                                {addressForm.formState.errors.roadName.message}
                            </p>
                        )}
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        <div className="space-y-2">
                            <Label>City</Label>
                            <Input
                                {...addressForm.register("city")}
                                placeholder="Enter City"
                                className="capitalize"
                                maxLength={30}
                                allowPattern={/[^A-Za-z -]/g}
                            />
                            {addressForm.formState.errors.city && (
                                <p className="text-sm text-red-500">
                                    {addressForm.formState.errors.city.message}
                                </p>
                            )}
                        </div>

                        <div className="space-y-2">
                            <Label>State</Label>
                            <Input
                                {...addressForm.register("state")}
                                placeholder="Enter State"
                                className="capitalize"
                                maxLength={30}
                                allowPattern={/[^A-Za-z -]/g}
                            />
                            {addressForm.formState.errors.state && (
                                <p className="text-sm text-red-500">
                                    {addressForm.formState.errors.state.message}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="grid grid-cols-2 gap-4">
                        <div className="space-y-1">
                            <Label>Country</Label>
                            <Input
                                {...addressForm.register("country")}
                                placeholder="Enter Country"
                                className="capitalize"
                                maxLength={30}
                                allowPattern={/[^A-Za-z -]/g}
                            />
                            {addressForm.formState.errors.country && (
                                <p className="text-sm text-red-500">
                                    {addressForm.formState.errors.country.message}
                                </p>
                            )}
                        </div>

                        <div className="space-y-1">
                            <Label>Pincode</Label>
                            <Input
                                {...addressForm.register("pincode")}
                                placeholder="Enter Pincode"
                                maxLength={6}
                                allowPattern={/[^0-9]/g}
                            />
                            {addressForm.formState.errors.pincode && (
                                <p className="text-sm text-red-500">
                                    {addressForm.formState.errors.pincode.message}
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="space-y-1">
                        <Label>Landmark (Optional)</Label>
                        <Input
                            {...addressForm.register("landmark")}
                            placeholder="Enter Landmark / near location / famous place"
                            className="capitalize"
                            maxLength={30}
                            allowPattern={/[^A-Za-z0-9 -]/g}
                        />
                    </div>

                    <div className="flex items-center gap-2">
                        <input
                            type="checkbox"
                            {...addressForm.register("checkMark")}
                            className="h-4 w-4"
                        />
                        <Label className="text-sm opacity-70">
                            I declare this is my current delivery address
                        </Label>
                    </div>

                    {addressForm.formState.errors.checkMark && (
                        <p className="text-sm text-red-500">
                            {addressForm.formState.errors.checkMark.message}
                        </p>
                    )}

                    <Button
                        type="submit"
                        className="w-full mt-5 py-6 text-xl font-medium"
                        disabled={!addressForm.watch("checkMark") || updateAddress.isPending}
                    >
                        {updateAddress.isPending ? (
                            <span className="flex items-center justify-center gap-2">
                                <Loader2 className="h-4 w-4 animate-spin" />
                                Updating...
                            </span>
                        ) : (
                            "Update Address"
                        )}
                    </Button>
                </ReusableForm>
            )}
        </div>
    );
}

export default function EditProfile() {
    return (
        <Suspense
            fallback={
                <div className="flex items-center justify-center min-h-screen">
                    Loading profile...
                </div>
            }
        >
            <EditProfileContent />
        </Suspense>
    );
}


// export default function EditProfile() {
//     const { data, isPending: isProfilePending } = useGetProfile();
//     const { data: caretakerData, isPending: isCaretakerPending } = useGetCaretaker()
//     const { mutate, isPending } = useUpdateCaretaker();
//     const [imageFile, setImageFile] = useState<File | null>(null);
//     const [localPreview, setLocalPreview] = useState<string | null>(null);

//     const caretaker = caretakerData?.caretaker;
//     const patient = caretakerData?.patient;
//     const profileImg = data?.user?.image?.url;

//     const form = useForm<RegisterFormValues>({
//         resolver: zodResolver(RegisterSchema),
//         defaultValues: {
//             patient: {
//                 fullname: "",
//                 dateOfBirth: "",
//                 gender: "",
//             },
//             fullname: "",
//             email: "",
//             relationship: "",
//             relationshipOther: "",
//             country: "",
//             city: "",
//             pincode: "",
//             phone: "",
//             otp: "",
//         },
//     });

//     // Prefill all fields when data loads
//     useEffect(() => {
//         if (!data) return;

//         const relationship = caretaker?.relationship || "";
//         const gender = patient?.gender || "";

//         // Check if relationship is a known option or "other"
//         const knownRelationships = ["father", "mother", "sibling", "spouse", "child"];
//         const isOtherRelationship = relationship && !knownRelationships.includes(relationship);

//         // Check if gender is a known option or "other"
//         const knownGenders = ["male", "female", "other"];
//         const isOtherGender = gender && !knownGenders.includes(gender);

//         form.reset({
//             patient: {
//                 fullname: patient?.fullname || "",
//                 dateOfBirth: patient?.dateOfBirth?.slice(0, 10) || "", // format for date input
//                 gender: isOtherGender ? "other" : gender,
//             },
//             fullname: caretaker?.fullname || "",
//             email: caretaker?.email || "",
//             relationship: isOtherRelationship ? "other" : relationship,
//             relationshipOther: isOtherRelationship ? relationship : "",
//             country: caretaker?.country || "",
//             city: caretaker?.city || "",
//             pincode: caretaker?.pincode || "",
//             phone: caretaker?.phone || "",
//             otp: "",
//         });
//     }, [data]);


//     const onSubmit = (values: RegisterFormValues) => {
//         mutate({
//             caretakerId: caretaker?._id,
//             image: imageFile,
//             data: {
//                 ...values,
//                 relationship:
//                     values.relationship === "other"
//                         ? values.relationshipOther?.trim()
//                         : values.relationship,
//                 patient: {
//                     ...values.patient,
//                     patientId: patient?._id,
//                 },
//             },
//         });
//     };

//     const handleImageChange = (e: ChangeEvent<HTMLInputElement>) => {
//         const file = e.target.files?.[0];
//         if (!file) return;

//         setImageFile(file);
//         setLocalPreview(URL.createObjectURL(file));
//     };

//     return (
//         <div className="min-h-screen bg-white md:bg-gray-100">
//             <GoBackBtn href='/home' ariaLabel='back to home' />
//             {
//                 (isProfilePending || isCaretakerPending) ? (
//                     <div className="flex items-center justify-center min-h-screen">
//                         Loading profile...
//                     </div>
//                 ) : null
//             }
//             <ReusableForm
//                 heading=""
//                 subHeading=""
//                 form={form}
//                 onSubmit={onSubmit}
//             >
//                 <div className="flex flex-col items-center mb-6">
//                     <div className="w-28 h-28 rounded-full overflow-hidden border shrink-0">
//                         <img
//                             src={
//                                 localPreview
//                                     ? localPreview
//                                     : profileImg && getImageUrl(profileImg)
//                             }
//                             alt="Profile"
//                             className="w-full h-full object-cover p-2"
//                         />
//                     </div>

//                     <label className="mt-3 text-sm text-blue-600 cursor-pointer">
//                         Change Photo
//                         <input
//                             type="file"
//                             accept="image/*"
//                             onChange={handleImageChange}
//                             className="hidden"
//                         />
//                     </label>
//                 </div>
//                 {/* -------- PATIENT SECTION -------- */}

//                 <div className="space-y-2">
//                     <Label className="font-medium pl-1">Medicine Recipient Full Name</Label>
//                     <Input
//                         {...form.register("patient.fullname")}
//                         placeholder="Enter Medicine recipient's full name (as per ID)"
//                         maxLength={30}
//                         allowPattern={/[^A-Za-z -]/g}
//                         className='capitalize'
//                     />
//                     {form.formState.errors.patient?.fullname && (
//                         <p className="text-red-500 text-sm">
//                             {form.formState.errors.patient.fullname.message}
//                         </p>
//                     )}
//                 </div>

//                 <div className="grid grid-cols-2 gap-4 w-full">
//                     <div className="space-y-2">
//                         <Label className="font-medium pl-1">Date of Birth</Label>
//                         <Input type="date" {...form.register("patient.dateOfBirth")} />
//                         {form.formState.errors.patient?.dateOfBirth && (
//                             <p className="text-red-500 text-sm">
//                                 {form.formState.errors.patient.dateOfBirth.message}
//                             </p>
//                         )}
//                     </div>

//                     <div className="space-y-2">
//                         <Controller
//                             control={form.control}
//                             name="patient.gender"
//                             render={({ field }) => (
//                                 <ReusableSelect
//                                     label="Gender"
//                                     placeholder="Select gender"
//                                     value={field.value}
//                                     onChange={(value) => {
//                                         field.onChange(value)
//                                     }}
//                                     options={[
//                                         { label: "Male", value: "male" },
//                                         { label: "Female", value: "female" },
//                                         { label: "Other", value: "other" },
//                                     ]}
//                                 />
//                             )}
//                         />


//                         {(form.formState.errors.patient?.gender) && (
//                             <p className="text-red-500 text-sm">
//                                 {form.formState.errors.patient?.gender?.message ||
//                                     form.formState.errors.patient?.message}
//                             </p>
//                         )}
//                     </div>
//                 </div>

//                 {/* -------- CARETAKER SECTION -------- */}

//                 <div className="flex items-center w-full gap-3 mt-8">
//                     <span className="w-full border border-gray-400"></span>
//                     <p className="w-full text-nowrap font-light text-sm">Caretaker Contact Details</p>
//                     <span className="w-full border border-gray-400"></span>
//                 </div>

//                 <div className="space-y-2">
//                     <Label className="font-medium pl-1">Caretaker Full Name</Label>
//                     <Input
//                         {...form.register("fullname")}
//                         placeholder="Enter full name (as per ID)"
//                         maxLength={30}
//                         allowPattern={/[^A-Za-z -]/g}
//                         className='capitalize'
//                     />
//                     {form.formState.errors.fullname && (
//                         <p className="text-red-500 text-sm">{form.formState.errors.fullname.message}</p>
//                     )}
//                 </div>

//                 <div className="space-y-2">
//                     <Label className="font-medium pl-1">Email ( Optional )</Label>
//                     <Input
//                         {...form.register("email")}
//                         disabled={!!caretaker?.email}
//                         placeholder="Enter email address"
//                         allowPattern={/[^a-zA-Z0-9@._-]/g}
//                         maxLength={50}
//                     />
//                 </div>

//                 <div className="grid grid-cols-2 gap-4 w-full">
//                     <div className="space-y-2">
//                         <Controller
//                             control={form.control}
//                             name="relationship"
//                             render={({ field }) => (
//                                 <ReusableSelect
//                                     label="Relationship"
//                                     placeholder="Select"
//                                     value={field.value}
//                                     onChange={(value) => {
//                                         field.onChange(value);
//                                         if (value !== "other") {
//                                             form.setValue("relationshipOther", "");
//                                             form.clearErrors("relationshipOther");
//                                         }
//                                     }}
//                                     options={[
//                                         { label: "Father", value: "father" },
//                                         { label: "Mother", value: "mother" },
//                                         { label: "Sibling", value: "sibling" },
//                                         { label: "Spouse", value: "spouse" },
//                                         { label: "Child", value: "child" },
//                                         { label: "Other", value: "other" },
//                                     ]}
//                                 />
//                             )}
//                         />

//                         {form.watch("relationship") === "other" && (
//                             <Input
//                                 placeholder="Enter relationship"
//                                 {...form.register("relationshipOther", {
//                                     required: "Please specify the relationship",
//                                 })}
//                                 maxLength={30}
//                                 allowPattern={/[^A-Za-z0-9-]/g}
//                             />
//                         )}

//                         {(form.formState.errors.relationship ||
//                             form.formState.errors.relationshipOther) && (
//                                 <p className="text-red-500 text-sm">
//                                     {form.formState.errors.relationship?.message ||
//                                         form.formState.errors.relationshipOther?.message}
//                                 </p>
//                             )}
//                     </div>

//                     <div className="space-y-2">
//                         <Label className="font-medium pl-1">Country</Label>
//                         <Input
//                             {...form.register("country")}
//                             placeholder="Enter country name"
//                             maxLength={30}
//                             allowPattern={/[^A-Za-z -]/g}
//                             className='capitalize'
//                         />
//                         {form.formState.errors.country && (
//                             <p className="text-red-500 text-sm">{form.formState.errors.country.message}</p>
//                         )}
//                     </div>
//                 </div>

//                 <div className="grid grid-cols-2 gap-4 w-full">
//                     <div className="space-y-2">
//                         <Label className="font-medium pl-1">City</Label>
//                         <Input
//                             {...form.register("city")}
//                             placeholder="Enter city name"
//                             maxLength={30}
//                             allowPattern={/[^A-Za-z -]/g}
//                             className='capitalize'
//                         />
//                         {form.formState.errors.city && (
//                             <p className="text-red-500 text-sm">{form.formState.errors.city.message}</p>
//                         )}
//                     </div>
//                     <div className="space-y-2">
//                         <Label className="font-medium pl-1">Pin Code</Label>
//                         <Input
//                             {...form.register("pincode")}
//                             placeholder="Enter pincode"
//                             maxLength={15}
//                             allowPattern={/[^A-Za-z0-9]/g}
//                             className='capitalize'
//                         />
//                         {form.formState.errors.pincode && (
//                             <p className="text-red-500 text-sm">{form.formState.errors.pincode.message}</p>
//                         )}
//                     </div>
//                 </div>

//                 {/* -------- PHONE SECTION -------- */}

//                 <div className="space-y-2">
//                     <Label>Phone Number</Label>

//                     <Input
//                         {...form.register("phone")}
//                         placeholder="Enter phone number"
//                         maxLength={10}
//                         disabled
//                         allowPattern={/[^0-9]/g}
//                     />

//                 </div>

//                 <Button
//                     type="submit"
//                     className="w-full mt-5 py-6 text-xl font-medium"
//                     disabled={isPending}
//                 >
//                     {isPending ? (
//                         <span className="flex items-center justify-center gap-2">
//                             <Loader2 className="h-4 w-4 animate-spin" />
//                             Updating...
//                         </span>
//                     ) : (
//                         "Update Details"
//                     )}
//                 </Button>
//             </ReusableForm>
//         </div>
//     );
// }
