"use client";
import FilePreviewDialog from "@/components/admin-components/FilePreviewDialog";
import { QuoteComponent } from "@/components/QuoteComponent";
import ReusablePopup from "@/components/ui/ReusablePopup";
import {
  useGetdocs,
  useUpdateDocumentStatus,
  useUpdateReviseStatus,
} from "@/hooks/useDocRequest";
import { getImageUrl } from "@/lib/getImage";
import { isImage } from "@/types/adminSchema";
import { Document } from "@/types/quotationtypes";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { useState } from "react";

export default function ProformaInvoice() {
  const router = useRouter();
  const { data, isPending } = useGetdocs("proforma_invoice");
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
      type: "proforma_invoice",
      status: "Revise_Request",
    });
  };

  const remarks = data?.remarks;

  const handlePopupClose = (open: boolean) => {
    setOpenPopup(open);
    router.replace("/caretaker/request-docs");
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100 ">
      {/* <GoBackBtn href='/caretaker/request-docs' ariaLabel='back requst page' />

            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}
      {isPending && (
        <div className="w-full min-h-screen flex items-center justify-center">
          <p>Loading...</p>
        </div>
      )}

      <QuoteComponent
        title="Download Your Proforma"
        description="View and download your proforma invoice for 
the requested medicine."
        reviseLabel="Revise Proforma Request"
        footerNote={remarks}
        status={status || "Requested"}
        downloadText="Download Proforma"
        onDownload={() => {
          if (!imageUrl) return;

          isImage(imageUrl)
            ? setPreview({ url: imageUrl, type: "image" })
            : setPreview({ url: imageUrl, type: "pdf" });
        }}
        isContinueDisabled={isContinueDisabled}
        onRevise={reviseRequest}
        onContinue={() => setOpenPopup(true)}
      >
        <div className="mb-10">
          <Link href="#" className="text-purple-500 underline">
            Need Any Help
          </Link>
        </div>
      </QuoteComponent>

      {/* Preview Dialog */}
      <FilePreviewDialog preview={preview} onClose={() => setPreview(null)} />

      <ReusablePopup
        open={openPopup}
        onOpenChange={handlePopupClose}
        image="/successfull-popup.svg"
        title="Acceptance Confirmed"
        description="Thank you for accepting the proforma invoice. You may now proceed
to request the import license 
for further processing"
      />
      {/* </div > */}
    </div>
  );
}
