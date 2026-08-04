// "use client";

// import { useEffect, useRef, useState } from "react";

// type ReadTextPopupProps = {
//     text: string;
//     trigger: React.ReactNode;
//     className?: string;
// };

// export default function ReadTextPopup({
//     text,
//     trigger,
//     className = "",
// }: ReadTextPopupProps) {
//     const [open, setOpen] = useState(false);
//     const [position, setPosition] = useState({ top: 0, left: 0 });

//     const triggerRef = useRef<HTMLButtonElement>(null);
//     const popupRef = useRef<HTMLDivElement>(null);

//     const POPUP_WIDTH = 280;
//     const POPUP_HEIGHT = 120;
//     const MARGIN = 10;

//     const calculatePosition = () => {
//         if (!triggerRef.current) return;

//         const rect = triggerRef.current.getBoundingClientRect();
//         const scrollY = window.scrollY;
//         const viewportWidth = window.innerWidth;
//         const viewportHeight = window.innerHeight;

//         // Center horizontally relative to trigger
//         let left = rect.left + rect.width / 2 - POPUP_WIDTH / 2;

//         // Clamp horizontally within viewport
//         left = Math.max(MARGIN, Math.min(left, viewportWidth - POPUP_WIDTH - MARGIN));

//         // Try above first
//         let top = rect.top + scrollY - POPUP_HEIGHT - 8;

//         // If not enough space above, show below
//         if (rect.top < POPUP_HEIGHT + MARGIN) {
//             top = rect.bottom + scrollY + 8;
//         }

//         // If still off screen bottom, center vertically in viewport
//         if (top + POPUP_HEIGHT > scrollY + viewportHeight - MARGIN) {
//             top = scrollY + viewportHeight / 2 - POPUP_HEIGHT / 2;
//         }

//         setPosition({ top, left });
//     };

//     const togglePopup = () => {
//         calculatePosition();
//         setOpen((v) => !v);
//     };

//     // Recalculate on scroll or resize
//     useEffect(() => {
//         if (!open) return;

//         const handleUpdate = () => calculatePosition();
//         window.addEventListener("scroll", handleUpdate, true);
//         window.addEventListener("resize", handleUpdate);

//         return () => {
//             window.removeEventListener("scroll", handleUpdate, true);
//             window.removeEventListener("resize", handleUpdate);
//         };
//     }, [open]);

//     // Close on outside click or touch
//     useEffect(() => {
//         const handleOutside = (e: MouseEvent | TouchEvent) => {
//             const target = e.target as Node;
//             if (
//                 popupRef.current &&
//                 !popupRef.current.contains(target) &&
//                 triggerRef.current &&
//                 !triggerRef.current.contains(target)
//             ) {
//                 setOpen(false);
//             }
//         };

//         document.addEventListener("mousedown", handleOutside);
//         document.addEventListener("touchstart", handleOutside);

//         return () => {
//             document.removeEventListener("mousedown", handleOutside);
//             document.removeEventListener("touchstart", handleOutside);
//         };
//     }, []);

//     return (
//         <>
//             <button
//                 ref={triggerRef}
//                 type="button"
//                 onClick={togglePopup}
//                 className={className}
//             >
//                 {trigger}
//             </button>

//             {open && (
//                 <div
//                     ref={popupRef}
//                     style={{
//                         position: "absolute",
//                         top: position.top,
//                         left: position.left,
//                         width: POPUP_WIDTH,
//                         zIndex: 9999,
//                     }}
//                     className="rounded-md border bg-white p-3 text-xs text-gray-700 shadow-lg"
//                 >
//                     {text}
//                 </div>
//             )}
//         </>
//     );
// }

"use client";

import { useEffect, useRef, useState } from "react";

type ReadTextPopupProps = {
    text: string;
    trigger: React.ReactNode;
    className?: string;
};

export default function ReadTextPopup({
    text,
    trigger,
    className = "",
}: ReadTextPopupProps) {
    const [open, setOpen] = useState(false);
    const [position, setPosition] = useState({ top: 0, left: 0 });

    const triggerRef = useRef<HTMLButtonElement>(null);
    const popupRef = useRef<HTMLDivElement>(null);

    const togglePopup = () => {
        if (!triggerRef.current) return;

        const rect = triggerRef.current.getBoundingClientRect();

        const popupWidth = 280;
        const popupHeight = 120;

        // Position ABOVE the button
        const top = rect.top - popupHeight - 8;

        // Keep popup inside screen horizontally
        const left = Math.min(
            rect.left,
            window.innerWidth - popupWidth - 10
        );

        setPosition({ top, left });
        setOpen((v) => !v);
    };

    // Close on outside click
    useEffect(() => {
        const handleClickOutside = (e: MouseEvent) => {
            if (
                popupRef.current &&
                !popupRef.current.contains(e.target as Node) &&
                triggerRef.current &&
                !triggerRef.current.contains(e.target as Node)
            ) {
                setOpen(false);
            }
        };

        document.addEventListener("mousedown", handleClickOutside);
        return () =>
            document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    return (
        <>
            <button
                ref={triggerRef}
                type="button"
                onClick={togglePopup}
                className={className}
            >
                {trigger}
            </button>

            {open && (
                <div
                    ref={popupRef}
                    className="fixed z-50 w-72 rounded-md border bg-white p-3 text-xs text-gray-700 shadow-lg"
                    style={{
                        top: position.top,
                        left: position.left,
                    }}
                >
                    {text}
                </div>
            )}
        </>
    );
}