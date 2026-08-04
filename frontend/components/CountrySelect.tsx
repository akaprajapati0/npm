"use client";

import dynamic from "next/dynamic";
import countryList from "react-select-country-list";
import { useMemo } from "react";

// Prevent hydration mismatch
const Select = dynamic(
    () => import("react-select"),
    { ssr: false }
);

type CountrySelectProps = {
    value: string;
    onChange: (value: string) => void;
    placeholder?: string;
    disabled?: boolean;
};

export default function CountrySelect({
    value,
    onChange,
    placeholder = "Select country",
    disabled = false,
}: CountrySelectProps) {
    const options = useMemo(
        () => countryList().getData(),
        []
    );

    return (
        <Select
            options={options}
            isSearchable
            isDisabled={disabled}
            placeholder={placeholder}
            value={
                options.find(
                    (country) =>
                        country.value === value
                ) || null
            }
            onChange={(selected: any) =>
                onChange(
                    selected?.value || ""
                )
            }
        />
    );
}
