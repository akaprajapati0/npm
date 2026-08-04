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
    infoKey: keyof typeof QUOTATION_CONFIG;
    statusKey: "quotation_requested" | "invoice_requested" | "license_requested";
}> = [
        {
            step: "medicine_quotation",
            label: "Request Medicine Quotation",
            infoKey: "WHY_QUOTE_REQUIRED",
            statusKey: "quotation_requested",
        },
        {
            step: "proforma_invoice",
            label: "Request Proforma Invoice",
            infoKey: "WHAT_PROFORMA",
            statusKey: "invoice_requested",
        },
        {
            step: "import_license",
            label: "Request Import License",
            infoKey: "WHY_LICENSE_REQUIRED",
            statusKey: "license_requested",
        },
    ];

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
                router.replace(STEP_ROUTE_MAP[step]);
                return;
            }

            // Optimistic update
            // setOptimisticSteps((prev) => [...prev, step]);
            setLoadingStep(step);

            mutate(step, {
                onSuccess: (res) => {
                    successToast(res.message || "Request submitted");

                    setOpenPopup(true);
                    setLastRequestedStep(step);
                    setLoadingStep(null);
                },
                onError: (err: any) => {
                    errorToast(
                        err?.response?.data?.message || "Something went wrong"
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

    /* ------------------ UI ------------------ */

    return (
        <div className="min-h-screen flex justify-center items-center md:py-5 bg-white md:bg-gray-100">
            <CarouselInfo
                heading="Manage Your Request Process"
                subHeading="Easily manage each stage of your request in a structured and compliant workflow."
                items={quotationCarouselItems}
            >
                <div className="w-full relative">
                    <button
                        type="button"
                        className="absolute rounded-full h-6 w-6 bg-yellow-300 text-black -right-1 cursor-pointer"
                        onClick={() => setActiveModal("WHY_QUOTE_REQUIRED")}
                        aria-label="More info"
                    >
                        ?
                    </button>

                    <Button
                        className="w-full mt-5 py-6 text-base font-medium"
                        onClick={() => handleRequest("medicine_quotation")}
                        disabled={isDisabled}
                    >
                        {loadingStep === "medicine_quotation" ? "Processing..." : "Request Medicine Quotation"}
                    </Button>
                </div>

                <div className="w-full relative">
                    <button
                        type="button"
                        className="absolute rounded-full h-6 w-6 bg-yellow-300 text-black -right-1 cursor-pointer"
                        onClick={() => setActiveModal("WHAT_PROFORMA")}
                        aria-label="More info"
                    >
                        ?
                    </button>

                    <Button
                        className="w-full mt-5 py-6 text-base font-medium"
                        onClick={() => handleRequest("proforma_invoice")}
                        disabled={isDisabled}
                    >
                        {loadingStep === "proforma_invoice" ? "Processing..." : "Request Proforma Invoice"}
                    </Button>
                </div>

                <div className="w-full relative">
                    <button
                        type="button"
                        className="absolute rounded-full h-6 w-6 bg-yellow-300 text-black -right-1 cursor-pointer"
                        onClick={() => setActiveModal("WHY_LICENSE_REQUIRED")}
                        aria-label="More info"
                    >
                        ?
                    </button>

                    <Button
                        className="w-full mt-5 py-6 text-base font-medium"
                        onClick={() => handleRequest("import_license")}
                        disabled={isDisabled}
                    >
                        {loadingStep === "import_license" ? "Processing..." : "Request Import License"}
                    </Button>
                </div>

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
