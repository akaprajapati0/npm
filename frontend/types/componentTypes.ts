import { ReactNode } from 'react';

export interface CarouselInfoProps {
    items: {
        image: string;
        title: string;
        description: string;
    }[];
    interval?: number;
    heading?: string;
    subHeading?: string;
    showControls?: boolean;
    onGetStarted?: () => void;
    children?: React.ReactNode;
    dotClassName?: string
}

export interface ReadModalInfoProps {
    open: boolean;
    onOpenChange: (open: boolean) => void;

    items: {
        title?: string;
        image?: string;
        description?: string;
    }[];

    heading?: string;
    showControls?: boolean;
    children?: React.ReactNode;
}


export interface UploadDocumentBtnState {
    kycType: "aadhaar" | "passport" | "";
    setKycType: (type: "aadhaar" | "passport" | "") => void;

    isPrescriptionUploaded: boolean;
    setIsPrescriptionUploaded: (value: boolean) => void;
}

export type PopupType = "" | "document" | "kyc";

export interface ImagePickerProps {
    open: PopupType;
    onOpenChange: (type: PopupType) => void;
    heading?: string;
    purpose?: "document" | "kyc";
    docsType?: string;
    onImagesSelect?: (data: { images: File[] }) => void;
}

export interface ReusableCardProps {
    title: string;
    description: string;
    children: ReactNode;
}

// ShowListText Component types
export type SectionItem = {
    title: string
    description?: string
    points?: string[]
    otherText?: string
}

export type InfoPageProps = {
    title: string
    description: string
    sections: SectionItem[]
}

// Reusable Page components types
export type ContentSectionProps = {
    id?: string;
    number?: string;
    title: string;
    description: string | string[];
    bg?: "white" | "gray" | string;
};

export type ReusablePageProps = {
    sections: ContentSectionProps[];
    heroTitle: string,
    heroImage?: string,
    bottomImage?: string,
    heading?: string,
    overlay?: boolean,
};

// GoBack Button types
export interface GoBackButtonProps {
    href?: string;
    ariaLabel?: string;
    className?: string;
    containerClassName?: string;
}
