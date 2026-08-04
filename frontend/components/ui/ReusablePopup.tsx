import Image from "next/image";
import { useEffect } from "react";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from "@/components/ui/dialog";

interface PopupProps {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    image: string;
    title: string;
    description: string;
}

export default function ReusablePopup({
    open,
    onOpenChange,
    image,
    title,
    description,
}: PopupProps) {

    useEffect(() => {
        if (!open) return;

        const timer = setTimeout(() => {
            onOpenChange(false);
        }, 10000);

        return () => clearTimeout(timer);
    }, [open, onOpenChange]);

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="max-w-xs mx-auto p-0 overflow-hidden rounded-xl [&>button]:cursor-pointer">

                <div className="w-full relative overflow-hidden aspect-video">
                    <Image
                        src={image}
                        alt="popup-image"
                        fill
                        priority
                        className="object-cover border-b rounded-b-[45%] "
                    />
                </div>

                <DialogHeader className="flex flex-col items-center gap-5 p-8 h-max">
                    <DialogTitle>{title}</DialogTitle>

                    <DialogDescription className="text-center sm:px-5">
                        {description}
                    </DialogDescription>
                </DialogHeader>

            </DialogContent>
        </Dialog>
    );
}