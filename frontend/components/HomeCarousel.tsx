"use client";
import { useRef } from "react";

export default function HomeCarousel({ id, children }: { id: string; children: React.ReactNode }) {
    const ref = useRef<HTMLDivElement>(null);

    const scroll = (dir: 1 | -1) => {
        if (ref.current) ref.current.scrollLeft += dir * 152;
    };

    return (
        <div className="relative px-5">
            <button
                type="button"
                onClick={() => scroll(-1)}
                className="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 disabled:opacity-30"
            >
                ‹
            </button>

            <div
                ref={ref}
                className="flex gap-3 overflow-hidden scroll-smooth justify-center"
            >
                {children}
            </div>

            <button
                type="button"
                onClick={() => scroll(1)}
                className="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 disabled:opacity-30"
            >
                ›
            </button>
        </div>
    );
}