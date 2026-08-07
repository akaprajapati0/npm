"use client";
import FilePreviewDialog from "@/components/admin-components/FilePreviewDialog";
import { QuoteComponent } from "@/components/QuoteComponent";
import ReusablePopup from "@/components/ui/ReusablePopup";
import { useGetdocs, useUpdateReviseStatus } from "@/hooks/useDocRequest";
import { getImageUrl } from "@/lib/getImage";
import { isImage } from "@/types/adminSchema";
import { useRouter } from "next/navigation";
import { useState } from "react";

export default function MedicineQuotation() {
  const router = useRouter();
  const { data, isPending } = useGetdocs("medicine_quotation");
  const updateMutation = useUpdateReviseStatus();

  const [openPopup, setOpenPopup] = useState(false);
  const [preview, setPreview] = useState<{
    url: string;
    type: "image" | "pdf";
  } | null>(null);

  // Safe sorting
  const documents = data?.documents || [];
  const latestDoc = documents[documents.length - 1] || null;

  const imageUrl = latestDoc?.url ? getImageUrl(latestDoc.url) : null;

  const hasDocument = !!imageUrl;

  // Normalize status
  const status = data?.status;

  const id = data?._id;

  const isApproved = status === "Approved";
  const isContinueDisabled = !(hasDocument && isApproved);

  // Status change handler
  const reviseRequest = () => {
    if (!id) return;

    updateMutation.mutate({
      id,
      type: "medicine_quotation",
      status: "Revise_Request",
    });
  };

  const handlePopupClose = (open: boolean) => {
    setOpenPopup(open);
    router.push("/caretaker/request-docs");
  };

  if (isPending) {
    return (
      <div className="w-full min-h-screen flex items-center justify-center">
        <p>Loading...</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
      {/* <GoBackBtn href='/caretaker/request-docs' ariaLabel='back requst page' />

            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}

      <QuoteComponent
        title="Your Medicine Quotation"
        description="Here you can review and download the quotation for your requested medicine."
        status={status || "Requested"}
        downloadText="Download Quote"
        continueLabel="Proceed for proforma"
        reviseLabel="Revise Quote Request"
        footerNote={data?.remarks}
        onDownload={() => {
          if (!imageUrl) return;

          isImage(imageUrl)
            ? setPreview({ url: imageUrl, type: "image" })
            : setPreview({ url: imageUrl, type: "pdf" });
        }}
        isContinueDisabled={isContinueDisabled}
        onRevise={reviseRequest}
        onContinue={() => setOpenPopup(true)}
      />

      {/* Preview Dialog */}
      <FilePreviewDialog preview={preview} onClose={() => setPreview(null)} />

      {/* Success Popup */}
      <ReusablePopup
        open={openPopup}
        onOpenChange={handlePopupClose}
        image="/successfull-popup.svg"
        title="Accepted Successfully"
        description="Thank you for accepting the quote. You may now proceed to request the proforma invoice for further processing."
      />
      {/* </div> */}
    </div>
  );
}
