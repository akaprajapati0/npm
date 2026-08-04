import stringSimilarity from "string-similarity";

export type MedicineInput = {
    medicineName: string;
    ActiveIngredients: string;
    strength?: string;
    dosage?: string;
    packSize?: string;
    quantity?: string
    storageConditions?: string;
    manufacturer?: string;
};

export const MEDICINE_HEADER_ALIASES: Record<keyof MedicineInput, string[]> = {
    medicineName: [
        "medicine name",
        "medicine",
        "drug name",
        "product name",
        "brand",
        "name",
    ],
    ActiveIngredients: [
        "active ingredients",
        "ingredients",
        "ingredient",
        "composition",
        "salt",
        "contents",
        "formula",
    ],
    strength: ["strength", "power", "mg"],
    dosage: ["dosage", "dose", "frequency"],
    packSize: ["pack size", "pack", "package"],
    quantity: ["quantity", "qty", "count", "units"],
    storageConditions: ["storage", "storage conditions"],
    manufacturer: ["manufacturer", "company", "maker"],
};

const normalize = (value: string): string =>
    value.toLowerCase().replace(/[^a-z0-9]/g, "").trim();


export const detectMedicineHeaders = (
    headers: string[]
): Partial<Record<keyof MedicineInput, string>> => {
    const result: Partial<Record<keyof MedicineInput, string>> = {};

    const normalizedHeaders = headers.map((h) => ({
        original: h,
        normalized: normalize(h),
    }));

    for (const field of Object.keys(
        MEDICINE_HEADER_ALIASES
    ) as (keyof MedicineInput)[]) {
        let bestScore = 0;
        let bestHeader: string | null = null;

        for (const header of normalizedHeaders) {
            for (const alias of MEDICINE_HEADER_ALIASES[field]) {
                const normAlias = normalize(alias);

                // STRONG MATCH: containment
                if (
                    header.normalized.includes(normAlias) ||
                    normAlias.includes(header.normalized)
                ) {
                    result[field] = header.original;
                    bestHeader = null;
                    break;
                }

                // FUZZY MATCH
                const score = stringSimilarity.compareTwoStrings(
                    header.normalized,
                    normAlias
                );

                if (score > bestScore) {
                    bestScore = score;
                    bestHeader = header.original;
                }
            }
            if (result[field]) break;
        }

        if (!result[field] && bestHeader && bestScore >= 0.45) {
            result[field] = bestHeader;
        }
    }

    return result;
};