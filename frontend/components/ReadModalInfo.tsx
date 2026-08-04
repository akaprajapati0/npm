"use client";

import Image from "next/image";
import { Button } from "@/components/ui/button";
import { useEffect, useState } from "react";
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { ReadModalInfoProps } from "@/types/componentTypes";

export default function ReadModalInfo({
    open,
    onOpenChange,
    heading,
    items,
    showControls = true,
    children,
}: ReadModalInfoProps) {
    const [activeIndex, setActiveIndex] = useState(0);

    /* AUTO ROTATE */
    useEffect(() => {
        if (!items.length) return;

        const interval = setInterval(() => {
            setActiveIndex((prev) => (prev + 1) % items.length);
        }, 5000);

        return () => clearInterval(interval);
    }, [items.length]);

    const activeItem = items[activeIndex];

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="max-w-sm p-0 [&>button]:hidden">
                {heading && (
                    <DialogHeader className="border-b px-4 py-2">
                        <DialogTitle className="font-black text-start py-2">
                            {heading}
                        </DialogTitle>
                    </DialogHeader>
                )}

                {/* CONTENT */}
                <div className="px-4 py-6 flex flex-col items-center text-center space-y-3">
                    {activeItem.image && (
                        <div className="relative w-full h-44">
                            <Image
                                src={activeItem.image}
                                alt={activeItem.title || ""}
                                fill
                                className="object-contain"
                            />
                        </div>
                    )}

                    {activeItem.title && (
                        <h2 className="font-black text-lg">
                            {activeItem.title}
                        </h2>
                    )}

                    {activeItem.description && (
                        <p className="text-sm text-gray-600 px-2">
                            {activeItem.description}
                        </p>
                    )}
                </div>

                {/* DOTS */}
                <div className="flex justify-center gap-2 pb-3">
                    {items.map((_, index) => (
                        <button
                            key={index}
                            onClick={() => setActiveIndex(index)}
                            className={`h-2 w-2 rounded-full transition-all ${activeIndex === index
                                ? "bg-primary w-4"
                                : "bg-gray-300"
                                }`}
                        />
                    ))}
                </div>

                {/* CONTROLS */}
                {showControls && (
                    <div className="px-4 pb-4">
                        <Button
                            variant="outline"
                            className="w-full text-red-500"
                            onClick={() => onOpenChange(false)}
                        >
                            Okay, I understand
                        </Button>
                    </div>
                )}

                {children}
            </DialogContent>
        </Dialog>
    );
}
