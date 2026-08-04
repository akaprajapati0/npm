"use client";
import FilePreviewDialog from "@/components/admin-components/FilePreviewDialog";
import { QuoteComponent } from "@/components/QuoteComponent";
import ReusablePopup from "@/components/ui/ReusablePopup";
import { useGetdocs } from "@/hooks/useDocRequest";
import { getImageUrl } from "@/lib/getImage";
import { isImage } from "@/types/adminSchema";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { useState } from "react";

export default function ImportLicense() {
  const router = useRouter();
  const { data, isPending } = useGetdocs("import_license");
  // const updateMutation = useUpdateReviseStatus();
  // console.log(data)

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

  const remarks = data?.remarks;

  const isApproved = status === "Approved";
  const isContinueDisabled = !((hasDocument && isApproved) || isPending);

  const handlePopupClose = (open: boolean) => {
    setOpenPopup(open);
    router.replace("/caretaker/bank-receipt");
  };

  // if (isPending) {
  //     return (
  //         <div className="w-full min-h-screen flex items-center justify-center">
  //             <p>Loading...</p>
  //         </div>
  //     );
  // }

  return (
    <div className="min-h-screen flex items-center justify-center bg-white md:bg-gray-100">
      {/* <GoBackBtn href='/caretaker/request-docs' ariaLabel='back requst page' />

            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]"> */}

      {isPending && (
        <div className="w-full min-h-screen flex items-center justify-center">
          <p>Loading...</p>
        </div>
      )}
      <QuoteComponent
        title="Access Your Import Permit"
        description="View and download your import permit, or track its 
status if it is not yet issued."
        // reviseLabel="Modify Proforma Request"
        // footerNote='You are solely responsible for how you use and share this quote. Any misuse is your responsibility.'
        downloadText="Download Import Lic."
        status={status || "Requested"}
        onDownload={() => {
          if (!imageUrl) return;

          isImage(imageUrl)
            ? setPreview({ url: imageUrl, type: "image" })
            : setPreview({ url: imageUrl, type: "pdf" });
        }}
        isContinueDisabled={isContinueDisabled}
        // onRevise={reviseRequest}
        onContinue={() => setOpenPopup(true)}
      >
        {/* <div className="">
                    <p className="">Your import license application has been rejected due to an unclear prescription upload. Please upload a clear and valid prescription to proceed. </p>
                </div> */}
        {/* {status === "Approved" && (
          <div className="my-5 space-y-2 w-full">
            <div className="border border-primary rounded-2xl p-3 text-gray-500">
              {!remarks ? "" : remarks}
            </div>
            <Link href="#" className="text-purple-500 underline">
              Upload Prescription / Any Reason
            </Link>
          </div>
        )} */}
        {status === "Approved" && (
          <div className="my-5 space-y-2 w-full">
            {remarks?.trim() && (
              <div className="border border-primary rounded-2xl p-3 text-gray-500">
                {remarks}
              </div>
            )}

            {/* <Link href="#" className="text-purple-500 underline">
              Upload Prescription / Any Reason
            </Link> */}
          </div>
        )}
      </QuoteComponent>

      {/* Preview Dialog */}
      <FilePreviewDialog preview={preview} onClose={() => setPreview(null)} />

      <ReusablePopup
        open={openPopup}
        onOpenChange={handlePopupClose}
        image="/successfull-popup.svg"
        title="Import Permit Approved"
        description="Thank you for accepting the import license. Please procced to complete the payment to continue your request process."
      />
      {/* </div> */}
      {/* </div > */}
    </div>
  );
}
