"use client";

import { useEffect, useState } from "react";
import { Controller, useForm, useWatch } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { Loader2 } from "lucide-react";

import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { ReusableForm } from "@/components/ReusableForm";

import {
    PrescribedMedicineSchema,
    PrescribedFormValues,
    MedicineResult,
} from "@/types/schema";

import {
    useGetPrescribedMedCount,
    useMedicineSearch,
    usePrescribedMedicine,
} from "@/hooks/usePrescribedMutation";
import GoBackBtn from '@/components/GoBackBtn';
import { ReusableSelect } from '@/components/ReusableSelect';
import { dosageOptions, quantityOptions, strengthOptions } from '@/utils/pagesContent';

/* ---------------- helpers ---------------- */

type ActiveField = "medicineName" | "ActiveIngredients" | null;

const MIN_SEARCH_LENGTH = 3;
const MAX_SEARCH_LENGTH = 8;

const hasValue = (value?: string | null) =>
    typeof value === "string" && value.trim().length > 0;

function useDebounce<T>(value: T, delay = 400) {
    const [debouncedValue, setDebouncedValue] = useState(value);

    useEffect(() => {
        const timer = setTimeout(() => setDebouncedValue(value), delay);
        return () => clearTimeout(timer);
    }, [value, delay]);

    return debouncedValue;
}

/* ---------------- component ---------------- */

export default function PrescribedMedicinePage() {
    const createMedicine = usePrescribedMedicine();
    const { data, isError, isLoading } = useGetPrescribedMedCount();

    const [activeField, setActiveField] = useState<ActiveField>(null);
    const [showDropdown, setShowDropdown] = useState(false);
    const [isItemSelected, setIsItemSelected] = useState(false);

    const [autofilledFields, setAutofilledFields] = useState<
        Partial<Record<keyof PrescribedFormValues, true>>
    >({});

    const form = useForm<PrescribedFormValues>({
        resolver: zodResolver(PrescribedMedicineSchema),
        defaultValues: {
            medicineName: "",
            ActiveIngredients: "",
            strength: "",
            dosage: "",
            quantity: "",
            packSize: "",
            storageConditions: "",
            manufacturer: "",
        },
    });

    const medicineName = useWatch({ control: form.control, name: "medicineName" });

    useEffect(() => {
        if (!medicineName || medicineName.trim() === "") {
            form.reset({
                medicineName: "",
                ActiveIngredients: "",
                strength: "",
                dosage: "",
                quantity: "",
                packSize: "",
                storageConditions: "",
                manufacturer: "",
            });
            setIsItemSelected(false)
            setShowDropdown(true)
            setAutofilledFields({});
        }
    }, [medicineName, form]);

    const ingredientName = useWatch({
        control: form.control,
        name: "ActiveIngredients",
    });

    const searchQuery =
        activeField === "ActiveIngredients"
            ? ingredientName
            : medicineName;

    const debouncedQuery = useDebounce(searchQuery);

    const shouldSearch =
        debouncedQuery && debouncedQuery.length >= MIN_SEARCH_LENGTH && debouncedQuery.length <= MAX_SEARCH_LENGTH;

    const { data: results = [], isFetching } =
        useMedicineSearch(shouldSearch ? debouncedQuery : "");

    useEffect(() => {
        if (!isItemSelected) {
            setShowDropdown(Boolean(shouldSearch && results.length));
        }
    }, [shouldSearch, results.length, isItemSelected]);

    const autofill = (medicine: MedicineResult) => {
        setIsItemSelected(true);
        setShowDropdown(false);

        const locked: typeof autofilledFields = {};

        const setIfExists = (
            name: keyof PrescribedFormValues,
            value?: string
        ) => {
            if (hasValue(value)) {
                form.setValue(name, value!, {
                    shouldDirty: true,
                    shouldValidate: true,
                });
                locked[name] = true;
            } else {
                form.resetField(name);
            }
        };

        setIfExists("medicineName", medicine.medicineName);
        setIfExists("ActiveIngredients", medicine.ActiveIngredients);
        setIfExists("strength", medicine.strength);
        setIfExists("dosage", medicine.dosage);
        setIfExists("packSize", medicine.packSize);
        setIfExists("quantity", medicine.quantity);
        setIfExists("storageConditions", medicine.storageConditions);
        setIfExists("manufacturer", medicine.manufacturer);

        setAutofilledFields(locked);
    };

    const isLocked = (field: keyof PrescribedFormValues) =>
        Boolean(autofilledFields[field]);

    const onSubmit = (values: PrescribedFormValues) => {
        createMedicine.mutate(values);
    };

    if (isLoading) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }


    if (isError) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Error loading medicines</p>
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
            {/* <div className="flex items-center justify-center "> */}
            <ReusableForm
                heading="Prescribed Medicine Details"
                subHeading="Share medicine information based on your prescription for verification"
                form={form}
                onSubmit={onSubmit}
            >
                {/* MEDICINE NAME */}
                <div className="space-y-2 relative">
                    <Label>Medicine Name</Label>
                    <Input
                        {...form.register("medicineName")}
                        onFocus={() => setActiveField("medicineName")}
                        placeholder="Enter brand or generic name of the medicine"
                        allowPattern={/[^A-Za-z ]/g}
                        maxLength={50}
                        className='capitalize'
                    />
                    {form.formState.errors.medicineName && (
                        <p className="text-red-500 text-sm">{form.formState.errors.medicineName.message}</p>
                    )}
                </div>

                {searchQuery &&
                    searchQuery.length < MIN_SEARCH_LENGTH && (
                        <p className="text-xs text-gray-400">
                            Type at least {MIN_SEARCH_LENGTH} characters
                        </p>
                    )}

                {showDropdown && (
                    <ul className="relative z-30 bg-white border rounded shadow max-h-48 overflow-auto">
                        {results.map((item, index) => (
                            <li
                                key={index}
                                onClick={() => autofill(item)}
                                className="px-3 py-2 cursor-pointer hover:bg-gray-100"
                            >
                                <strong>{item.medicineName}</strong>
                                <div className="text-xs text-gray-500">
                                    {item.ActiveIngredients}
                                </div>
                            </li>
                        ))}
                    </ul>
                )}

                {isFetching && (
                    <p className="text-xs text-gray-400">Searching…</p>
                )}

                {/* ACTIVE INGREDIENT */}
                <div className="space-y-2">
                    <Label>Active Ingredient / Salt Composition</Label>
                    <Input
                        {...form.register("ActiveIngredients")}
                        onFocus={() =>
                            setActiveField("ActiveIngredients")
                        }
                        placeholder='Active Ingredient / Salt Composition in the medicine'
                        readOnly={isLocked("ActiveIngredients")}
                        allowPattern={/[^A-Za-z -]/g}
                        maxLength={50}
                        className='capitalize'
                    />
                    {form.formState.errors.ActiveIngredients && (
                        <p className="text-red-500 text-sm">{form.formState.errors.ActiveIngredients.message}</p>
                    )}
                </div>

                {/* STRENGTH + DOSAGE */}
                <div className="grid grid-cols-2 gap-4">
                    <div className="">
                        <Controller
                            control={form.control}
                            name="strength"
                            render={({ field }) =>
                                isLocked("strength") ? (
                                    <div className="space-y-2">
                                        <Label>Strength</Label>
                                        <Input readOnly {...field} />
                                    </div>
                                ) : (
                                    <ReusableSelect
                                        label="Strength"
                                        options={strengthOptions}
                                        {...field}
                                    />
                                )
                            }
                        />
                        {form.formState.errors.strength && (
                            <p className="text-red-500 text-sm">{form.formState.errors.strength.message}</p>
                        )}
                    </div>
                    <div className="">
                        <Controller
                            control={form.control}
                            name="dosage"
                            render={({ field }) =>
                                isLocked("dosage") ? (
                                    <div className="space-y-2">
                                        <Label>Dosage Form</Label>
                                        <Input readOnly {...field} />
                                    </div>
                                ) : (
                                    <ReusableSelect
                                        label="Dosage Form"
                                        options={dosageOptions}
                                        {...field}
                                    />
                                )
                            }
                        />
                        {form.formState.errors.dosage && (
                            <p className="text-red-500 text-sm">{form.formState.errors.dosage.message}</p>
                        )}
                    </div>
                </div>

                {/* PACK SIZE */}
                <div className="">
                    <Controller
                        control={form.control}
                        name="packSize"
                        render={({ field }) =>
                            isLocked("packSize") ? (
                                <div className="space-y-2">
                                    <Label>Pack Size</Label>
                                    <Input readOnly {...field} />
                                </div>
                            ) : (
                                <div className="space-y-2">
                                    <Label>Pack Size</Label>
                                    <Input readOnly {...field} placeholder='Pack size' />
                                </div>
                            )
                        }
                    />
                    {form.formState.errors.quantity && (
                        <p className="text-red-500 text-sm">{form.formState.errors.quantity.message}</p>
                    )}
                </div>

                {/* QUANTITY */}
                <div className="">
                    <Controller
                        control={form.control}
                        name="quantity"
                        render={({ field }) =>
                            isLocked("quantity") ? (
                                <div className="space-y-2">
                                    <Label>Quantity Required</Label>
                                    <Input readOnly {...field} />
                                </div>
                            ) : (
                                <ReusableSelect
                                    label="Quantity Required"
                                    options={quantityOptions}
                                    {...field}
                                />
                            )
                        }
                    />
                    {form.formState.errors.quantity && (
                        <p className="text-red-500 text-sm">{form.formState.errors.quantity.message}</p>
                    )}
                </div>

                {/* -------- TEXT INPUTS ------- */}
                <div className="space-y-2">
                    <Label>Storage Conditions</Label>
                    <Input
                        {...form.register("storageConditions")}
                        placeholder="e.g., 15-25, 2-8 Celcius"
                        readOnly
                        className='capitalize'
                    />
                </div>

                <div className="space-y-2">
                    <Label>Manufacturer</Label>
                    <Input
                        {...form.register("manufacturer")}
                        placeholder="Medicine's Manufacturer"
                        readOnly
                        className='capitalize'
                    />
                </div>

                <Button
                    type="submit"
                    disabled={createMedicine.isPending || isLoading}
                    className="w-full mt-5 py-6 text-xl font-medium"
                >
                    {createMedicine.isPending ? (
                        <Loader2 className="h-4 w-4 animate-spin" />
                    ) : (
                        "Continue"
                    )}
                </Button>
            </ReusableForm>
        </div>
        // </div>
    );
}
