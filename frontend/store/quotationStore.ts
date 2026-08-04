import { create } from "zustand";
import { RequestStep, STEP_ORDER } from "@/types/quotationtypes";

interface QuotationJourneyState {
    activeStep: RequestStep;
    completedSteps: RequestStep[];
    lastRequestedStep: RequestStep | null;

    openPopup: boolean;
    activeModal: string | null;

    completeStep: (step: RequestStep) => void;
    closePopup: () => void;
    openInfoModal: (key: string) => void;
    closeInfoModal: () => void;

    isDisabled: (step: RequestStep) => boolean;
    isCompleted: (step: RequestStep) => boolean;
}

export const quotationStore = create<QuotationJourneyState>(
    (set, get) => ({
        activeStep: "medicine_quotation",
        completedSteps: [],
        lastRequestedStep: null,

        openPopup: false,
        activeModal: null,

        completeStep: (step) => {
            const { completedSteps } = get();

            if (completedSteps.includes(step)) return;

            const currentIndex = STEP_ORDER.indexOf(step);
            const nextStep = STEP_ORDER[currentIndex + 1];

            set({
                completedSteps: [...completedSteps, step],
                activeStep: nextStep ?? step,
                lastRequestedStep: step,
                openPopup: true,
            });
        },

        closePopup: () =>
            set({
                openPopup: false,
            }),

        openInfoModal: (key) =>
            set({
                activeModal: key,
            }),

        closeInfoModal: () =>
            set({
                activeModal: null,
            }),

        isDisabled: (step) => {
            const { activeStep, completedSteps } = get();
            return step !== activeStep || completedSteps.includes(step);
        },

        isCompleted: (step) => {
            return get().completedSteps.includes(step);
        },
    })
);
