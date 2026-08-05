"use client";

import { useCallback, useMemo, useState } from "react";
import { useRouter } from "next/navigation";

import CarouselInfo from "@/components/CarouselInfo";
import { Button } from "@/components/ui/button";
import ReusablePopup from "@/components/ui/ReusablePopup";
import ReadTextModal from "@/components/ReadTextModal";

import { QUOTATION_CONFIG } from "@/lib/allReadableText";
import { quotationCarouselItems } from "@/utils/carouselData";
import { POPUP_CONTENT, RequestStep } from "@/types/quotationtypes";

import { useDocRequest, useGetdocs } from "@/hooks/useDocRequest";
import { errorToast, successToast } from '@/utils/toast';
import { useGetKyc } from '@/hooks/useKycMutation';
import { useGetProfile } from '@/hooks/useAuthMutations';

/* ------------------ CONSTANTS ------------------ */

// const REDIRECT_DELAY = 6000;

const STEP_ROUTE_MAP: Record<RequestStep, string> = {
    medicine_quotation: "/caretaker/request-docs/medicine-quotation",
    proforma_invoice: "/caretaker/request-docs/proforma-invoice",
    import_license: "/caretaker/request-docs/import-license",
};

const REQUEST_BUTTONS: Array<{
    step: RequestStep;
    label: string;
    requestedLabel: string;
    approvedLabel: string;
    rejectedLabel: string;
    infoKey: keyof typeof QUOTATION_CONFIG;
    statusKey: "quotation_requested" | "invoice_requested" | "license_requested";
}> = [
        {
            step: "medicine_quotation",
            label: "Request Medicine Quotation",
            requestedLabel: "Medicine Quotation Requested",
            approvedLabel: "View Medicine Quotation",
            rejectedLabel: "Medicine Quotation Rejected",
            infoKey: "WHY_QUOTE_REQUIRED",
            statusKey: "quotation_requested",
        },
        {
            step: "proforma_invoice",
            label: "Request Proforma Invoice",
            requestedLabel: "Proforma Invoice Requested",
            approvedLabel: "View Proforma Invoice",
            rejectedLabel: "Proforma Invoice Rejected",
            infoKey: "WHAT_PROFORMA",
            statusKey: "invoice_requested",
        },
        {
            step: "import_license",
            label: "Request Import License",
            requestedLabel: "Import License Requested",
            approvedLabel: "View Import License",
            rejectedLabel: "Import License Rejected",
            infoKey: "WHY_LICENSE_REQUIRED",
            statusKey: "license_requested",
        },
    ];

type RequestDocStatus = "Pending" | "Requested" | "Approved" | "Rejected" | "Revise_Request";
type ApiError = {
    response?: {
        data?: {
            message?: string;
        };
    };
};

/* ------------------ COMPONENT ------------------ */

export default function RequestDocument() {
    const router = useRouter();
    // const { data, isPending: isGetDataPending } = useGetAllDocuments();
    const { isPending: isGetProgress } = useGetProfile()
    const { mutate, isPending } = useDocRequest();
    // const { data: docsCount, isPending: isDocsCountPending } = useDocumentCount()
    const kycStatus = useGetKyc()
    const medicineQuotationDoc = useGetdocs("medicine_quotation");
    const proformaInvoiceDoc = useGetdocs("proforma_invoice");
    const importLicenseDoc = useGetdocs("import_license");
    // console.log(data)

    // const isSecondOrder = Number(docsCount) >= 1;
    /* ------------------ LOCAL STATE ------------------ */

    const [activeModal, setActiveModal] =
        useState<keyof typeof QUOTATION_CONFIG | null>(null);

    const [openPopup, setOpenPopup] = useState(false);
    const [lastRequestedStep, setLastRequestedStep] =
        useState<RequestStep | null>(null);

    const [loadingStep, setLoadingStep] = useState<RequestStep | null>(null);
    const [requestedSteps, setRequestedSteps] = useState<Set<RequestStep>>(
        () => new Set()
    );

    // Optimistic UI state
    // const [optimisticSteps, setOptimisticSteps] = useState<RequestStep[]>([]);

    /* ------------------ DERIVED DATA ------------------ */

    // const remarks: string[] = data?.remarks ?? [];

    // const completedSteps = useMemo(
    //     () => new Set(optimisticSteps),
    //     [optimisticSteps]
    // );

    const currentModalData = activeModal
        ? QUOTATION_CONFIG[activeModal]
        : undefined;

    const existingDocs = useMemo(() => ({
        medicine_quotation: medicineQuotationDoc.data,
        proforma_invoice: proformaInvoiceDoc.data,
        import_license: importLicenseDoc.data,
    }), [medicineQuotationDoc.data, proformaInvoiceDoc.data, importLicenseDoc.data]);

    /* ------------------ HANDLERS ------------------ */

    const handleRequest = useCallback(
        (step: RequestStep) => {
            const existingDoc = existingDocs[step];

            if (existingDoc) {
                router.push(STEP_ROUTE_MAP[step]);
                return;
            }

            // Optimistic update
            // setOptimisticSteps((prev) => [...prev, step]);
            setLoadingStep(step);

            mutate(step, {
                onSuccess: (res) => {
                    successToast(res.message || "Request submitted");

                    setRequestedSteps((prev) => new Set(prev).add(step));
                    setOpenPopup(true);
                    setLastRequestedStep(step);
                    setLoadingStep(null);
                },
                onError: (err: unknown) => {
                    const apiError = err as ApiError;
                    errorToast(
                        apiError.response?.data?.message ||
                        (err instanceof Error ? err.message : "Something went wrong")
                    );

                    // Rollback optimistic UI
                    // setOptimisticSteps((prev) =>
                    //     prev.filter((s) => s !== step)
                    // );
                    setLoadingStep(null);
                },
            });
        },
        [existingDocs, mutate, router]
    );

    const handlePopupChange = (open: boolean) => {
        setOpenPopup(open);

        // Stay on the request hub so users can submit the remaining forms.
    };

    if (
        kycStatus.isPending ||
        isGetProgress ||
        medicineQuotationDoc.isPending ||
        proformaInvoiceDoc.isPending ||
        importLicenseDoc.isPending
    ) {
        return (
            <div className="w-full min-h-screen flex items-center justify-center">
                <p>Loading...</p>
            </div>
        );
    }

    const isDisabled = isPending || !kycStatus.data;

    const getButtonState = (button: (typeof REQUEST_BUTTONS)[number]) => {
        const doc = existingDocs[button.step];
        const status = doc?.status as RequestDocStatus | undefined;
        const wasRequested = requestedSteps.has(button.step);

        if (loadingStep === button.step) {
            return {
                label: "Processing...",
                disabled: true,
                className: "bg-gray-300 text-gray-600 hover:bg-gray-300",
            };
        }

        if (status === "Approved") {
            return {
                label: button.approvedLabel,
                disabled: isDisabled,
                className: "",
            };
        }

        if (status === "Rejected") {
            return {
                label: button.rejectedLabel,
                disabled: true,
                className: "bg-gray-300 text-gray-600 hover:bg-gray-300",
            };
        }

        if (doc || wasRequested) {
            return {
                label: button.requestedLabel,
                disabled: true,
                className: "bg-gray-300 text-gray-600 hover:bg-gray-300",
            };
        }

        return {
            label: button.label,
            disabled: isDisabled,
            className: "",
        };
    };

    /* ------------------ UI ------------------ */

    return (
        <div className="min-h-screen flex justify-center items-center md:py-5 bg-white md:bg-gray-100">
            <CarouselInfo
                heading="Manage Your Request Process"
                subHeading="Easily manage each stage of your request in a structured and compliant workflow."
                items={quotationCarouselItems}
            >
                {REQUEST_BUTTONS.map((button) => {
                    const buttonState = getButtonState(button);

                    return (
                        <div key={button.step} className="w-full relative">
                            <button
                                type="button"
                                className="absolute rounded-full h-6 w-6 bg-yellow-300 text-black -right-1 cursor-pointer"
                                onClick={() => setActiveModal(button.infoKey)}
                                aria-label="More info"
                            >
                                ?
                            </button>

                            <Button
                                className={`w-full mt-5 py-6 text-base font-medium ${buttonState.className}`}
                                onClick={() => handleRequest(button.step)}
                                disabled={buttonState.disabled}
                            >
                                {buttonState.label}
                            </Button>
                        </div>
                    );
                })}

            </CarouselInfo>

            {/* STATUS POPUP */}
            {lastRequestedStep && (
                <ReusablePopup
                    open={openPopup}
                    onOpenChange={handlePopupChange}
                    image="/successfull-popup.svg"
                    title={POPUP_CONTENT[lastRequestedStep].title}
                    description={
                        POPUP_CONTENT[lastRequestedStep].description
                    }
                />
            )}


            {/* INFO MODAL */}
            <ReadTextModal
                open={Boolean(activeModal)}
                onOpenChange={(open) => !open && setActiveModal(null)}
                title={currentModalData?.title ?? ""}
                markdown={currentModalData?.markdown ?? ""}
                fileName={currentModalData?.fileName ?? ""}
                triggerLabel="Read Terms"
            />
        </div>
    );
}
