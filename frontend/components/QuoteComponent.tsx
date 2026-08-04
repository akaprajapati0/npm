"use client";
import Image from "next/image";
import { ReactNode } from "react";
import { Button } from "@/components/ui/button";
import { ReusableCard } from "@/components/ReusableCard";

export type QuoteStatus =
  | "Pending"
  | "Requested"
  | "Approved"
  | "Rejected"
  | "Revise_Request";

const STATUS_LABEL: Record<QuoteStatus, string> = {
  Pending: "Pending",
  Requested: "Requested",
  Approved: "Approved",
  Rejected: "Rejected",
  Revise_Request: "Revise Requested",
};

const STATUS_COLOR: Record<QuoteStatus, string> = {
  Pending: "text-muted-foreground",
  Requested: "text-primary",
  Approved: "text-green-500",
  Rejected: "text-destructive",
  Revise_Request: "text-red-500",
};

interface QuoteCardProps {
  title: string;
  description: string;

  imageSrc?: string;

  status?: QuoteStatus;

  onDownload?: () => void;
  onRevise?: () => void;
  onContinue?: () => void;

  reviseLabel?: string;
  continueLabel?: string;
  isContinueDisabled?: boolean;
  downloadText?: string;

  footerNote?: string;

  children?: ReactNode;
}
export function QuoteComponent({
  title,
  description,
  imageSrc = "/upload-prescription.svg",
  status,
  onDownload,
  onRevise,
  onContinue,
  reviseLabel = "Revise",
  continueLabel = "Continue to Next",
  isContinueDisabled,
  downloadText = "Download",
  footerNote = "",
  children,
}: QuoteCardProps) {
  return (
    <div className="w-full">
      <ReusableCard title={title} description={description}>
        {/* Image Preview */}
        <div className="w-full h-48 flex items-center justify-center mb-4">
          <Image src={imageSrc} alt="preview" width={200} height={200} />
        </div>

        {/* Status + Download */}
        <div className="w-full flex justify-between items-center py-4">
          {status && (
            <div className="w-fit">
              <span className="text-gray-400 text-sm pr-1">Status:</span>
              <span
                className={`${STATUS_COLOR[status] ?? "text-primary"} text-xs`}
              >
                {STATUS_LABEL[status] ?? status}
              </span>
            </div>
          )}

          {onDownload && (
            <button onClick={onDownload} className="text-red-500 font-medium">
              {downloadText}
            </button>
          )}
        </div>

        {/* Revise button */}
        {onRevise && (
          <Button
            onClick={onRevise}
            className="w-full mb-4 py-6 text-base font-medium bg-green-500"
            disabled={
              status !== "Approved" && status !== "Rejected"
              //   ||   isContinueDisabled
            }
          >
            {reviseLabel}
          </Button>
        )}

        {/* Footer note */}
        {footerNote && <p className="my-1 text-gray-500">{footerNote}</p>}

        {/* Optional custom content */}
        {children}

        {/* Continue button */}
        {onContinue && (
          <Button
            onClick={onContinue}
            disabled={isContinueDisabled}
            className="mt-5 w-full py-6 text-base font-medium disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {continueLabel}
          </Button>
        )}
      </ReusableCard>
    </div>
  );
}

// "use client";
// import Image from "next/image";
// import { ReactNode } from "react";
// import { Button } from "@/components/ui/button";
// import { ReusableCard } from "@/components/ReusableCard";

// interface QuoteCardProps {
//     title: string;
//     description: string;

//     imageSrc?: string;

//     status?: "Approved" | "Rejected";

//     onDownload?: () => void;
//     onRevise?: () => void;
//     onContinue?: () => void;

//     reviseLabel?: string;
//     continueLabel?: string;
//     isContinueDisabled?: boolean;
//     downloadText?: string;

//     footerNote?: string;

//     children?: ReactNode;
// }

// // const statusOptions = [
// //     // { label: "Pending", value: "pending" },
// //     { label: "Approved", value: "Approved" },
// //     { label: "Rejected", value: "Rejected" },
// // ];
// export function QuoteComponent({
//     title,
//     description,
//     imageSrc = "/upload-prescription.svg",
//     status,
//     onDownload,
//     onRevise,
//     onContinue,
//     reviseLabel = "",
//     continueLabel = "Continue to Next",
//     isContinueDisabled,
//     downloadText = "Download",
//     footerNote = "",
//     children,
// }: QuoteCardProps) {
//     return (
//         <div className="w-full">
//             <ReusableCard title={title} description={description}>
//                 {/* Image Preview */}
//                 <div className="w-full h-48 flex items-center justify-center mb-4">
//                     <Image src={imageSrc} alt="preview" width={200} height={200} />
//                 </div>

//                 {/* Status + Download */}
//                 <div className="w-full flex justify-between items-center py-4">
//                     <div className="w-fit">
//                         <div>
//                             <span className="text-gray-400 text-sm pr-1">Status:</span>
//                             <span className={` ${status === "Approved"
//                                 ? "text-green-500"
//                                 : "text-primary"} text-xs`}>{status}</span>
//                         </div>
//                     </div>

//                     {onDownload && (
//                         <button
//                             onClick={onDownload}
//                             className="text-red-500 font-medium"
//                         >
//                             {downloadText}
//                         </button>
//                     )}
//                 </div>

//                 {/* Revise button */}
//                 {onRevise && (
//                     <Button
//                         onClick={onRevise}
//                         className="w-full mb-4 py-6 text-base font-medium bg-green-500"

//                     >
//                         {reviseLabel}
//                     </Button>
//                 )}

//                 {/* Footer note */}
//                 <p className="my-1 text-gray-500">{footerNote}</p>

//                 {/* Optional custom content */}
//                 {children}

//                 {/* Continue button */}
//                 {onContinue && (
//                     <Button
//                         onClick={onContinue}
//                         disabled={isContinueDisabled}
//                         className="mt-5 w-full py-6 text-base font-medium  disabled:opacity-50 disabled:cursor-not-allowed"
//                     >
//                         {continueLabel}
//                     </Button>
//                 )}
//             </ReusableCard>
//         </div>
//     );
// }
