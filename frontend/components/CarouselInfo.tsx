"use client";

import { useEffect, useRef, useState, useCallback } from "react";
import Image from "next/image";
import { CarouselInfoProps } from "@/types/componentTypes";
import { ReusableCard } from './ReusableCard';
import { Button } from './ui/button';
import Link from 'next/link';

export default function CarouselInfo({
    items,
    interval = 7000,
    heading,
    subHeading,
    showControls = false,
    onGetStarted,
    children,
    dotClassName
}: CarouselInfoProps) {
    const [index, setIndex] = useState(0);
    const [isPaused, setIsPaused] = useState(false);

    const intervalRef = useRef<NodeJS.Timeout | null>(null);

    const isLastSlide = index === items.length - 1;

    /** ---------------- Auto Slide ---------------- */
    const clearAutoSlide = useCallback(() => {
        if (intervalRef.current) {
            clearInterval(intervalRef.current);
            intervalRef.current = null;
        }
    }, []);

    const startAutoSlide = useCallback(() => {
        clearAutoSlide();
        intervalRef.current = setInterval(() => {
            setIndex((prev) => (prev + 1) % items.length);
        }, interval);
    }, [interval, items.length, clearAutoSlide]);

    useEffect(() => {
        if (!showControls && !isPaused) {
            startAutoSlide();
        } else {
            clearAutoSlide();
        }

        return clearAutoSlide;
    }, [isPaused, showControls, startAutoSlide, clearAutoSlide]);

    /** ---------------- Navigation ---------------- */
    const goToSlide = (i: number) => setIndex(i);

    const handleNext = () => {
        if (!isLastSlide) {
            setIndex((prev) => prev + 1);
        }
    };

    /** ---------------- Guards ---------------- */
    if (!items || items.length === 0) {
        return (
            <ReusableCard title={heading || ""} description={subHeading || ""}>
                <div className="py-4 text-center text-gray-500">
                    No items to display
                </div>
            </ReusableCard>
        );
    }

    const slide = items[index];

    return (
        <ReusableCard title={heading || ""} description={subHeading || ""}>
            <div className="flex flex-col items-center gap-3 text-center">
                {/* Slide */}
                <div
                    className="relative flex h-72 w-full flex-col items-center mb-8"
                    onMouseEnter={() => setIsPaused(true)}
                    onMouseLeave={() => setIsPaused(false)}
                >
                    <div className="relative flex justify-center mb-3 h-full w-full">
                        <Image
                            src={slide.image}
                            alt={slide.title}
                            width={200}
                            height={100}
                            className="object-contain w-fit h-fit"
                            priority={index === 0}
                        />
                    </div>

                    <div className="max-w-sm flex justify-center flex-col items-center">
                        <h2 className="mb-1 text-xl font-semibold">
                            {slide.title}
                        </h2>
                        <p className="text-sm text-gray-600">
                            {slide.description}
                        </p>
                    </div>
                </div>

                {/* Dots */}
                <div className={`flex gap-2 ${dotClassName}`}>
                    {items.map((_, i) => (
                        <button
                            key={i}
                            onClick={() => goToSlide(i)}
                            aria-label={`Go to slide ${i + 1}`}
                            className={`h-2 w-2 rounded-full transition-all ${i === index
                                ? "bg-primary scale-110"
                                : "bg-gray-300 hover:bg-gray-400"
                                }`}
                        />
                    ))}
                </div>

                {/* Controls */}
                {showControls && (
                    <div className="w-full mt-6">
                        {!isLastSlide ? (
                            <Button
                                onClick={handleNext}
                                className=""
                            >
                                Next
                            </Button>
                        ) : (
                            <Link
                                href="/caretaker"
                                className="block w-full bg-primary text-white text-xl font-medium text-center py-3 px-6 rounded-md"
                            >
                                GET STARTED
                            </Link>
                        )}
                    </div>
                )}

                {children}
            </div>
        </ReusableCard>
    );
}