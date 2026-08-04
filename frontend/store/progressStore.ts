"use client";

import { create } from "zustand";
import { persist } from "zustand/middleware";

export type ProgressState =
    | "loading"
    | "none"
    | "caretaker_uploaded"
    | "prescribed_uploaded"
    | "doctor_uploaded"
    | "prescription_uploaded"
    | "kyc_uploaded"
    | "request_quotation"
    | "request_invoice"
    | "request_license"
    | "bank_receipt_uploaded"
    | "cdec_uploaded"
    | "address_added"
    | "completed";

interface ProgressStore {
    progress: ProgressState;
    setProgress: (p: ProgressState) => void;
    reset: () => void;
}

export const useProgressStore = create<ProgressStore>()(
    persist(
        (set) => ({
            progress: "loading",
            setProgress: (p) => set({ progress: p }),
            reset: () => set({ progress: "none" }),
        }),
        {
            name: "progress-store",
            partialize: (state) => ({ progress: state.progress }),
        }
    )
);

