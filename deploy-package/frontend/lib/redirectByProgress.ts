
import { AppRouterInstance } from "next/dist/shared/lib/app-router-context.shared-runtime";

export const redirectByProgress = (
    progress: string,
    router: AppRouterInstance,
    pathname?: string,
) => {
    const go = (path: string) => {
        if (pathname !== path) router.replace(path);
    };

    switch (progress) {
        case "none":
            go("/caretaker/register");
            break;
        case "caretaker_uploaded":
            go("/caretaker/prescribed-medicine");
            break;
        case "prescribed_uploaded":
            go("/caretaker/doctor-details");
            break;
        case "doctor_uploaded":
            go("/caretaker/upload-document");
            break;
        case "prescription_uploaded":
            go("/caretaker/kyc");
            break;
        case "kyc_uploaded":
            go("/caretaker/request-docs");
            break;
        case "request_quotation":
        case "request_invoice":
        case "request_license":
            go("/caretaker/request-docs");
            break;
        case "bank_receipt_uploaded":
            go("/caretaker/cdec");
            break;
        // address completed OR skipped
        case "address_added":
        case "completed":
        case "address_skipped":
            go("/home");
            break;

        default:
            // DO NOTHING
            break;
        // case "cdec_uploaded":
        //     go("/caretaker/address");
        //     break;
        // case "address_added":
        //     go("/home");
        //     break;
        // default:
        //     go("/");
    }
};
