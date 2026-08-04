"use client";

import { X, Bell } from "lucide-react";
import { useEffect, useState } from "react";

interface Notification {
    id: string;
    title: string;
    message: string;
    createdAt: string;
    isRead: boolean;
}

interface NotificationPopupProps {
    open: boolean;
    onClose: () => void;
}

export default function NotificationPopup({
    open,
    onClose,
}: NotificationPopupProps) {
    const [notifications, setNotifications] = useState<Notification[]>([]);
    const [loading, setLoading] = useState(false);

    // Fetch notifications when popup opens
    useEffect(() => {
        if (!open) return;

        // const fetchNotifications = async () => {
        //     try {
        //         setLoading(true);

        //         const res = await fetch("/api/notifications", {
        //             credentials: "include",
        //         });

        //         if (!res.ok) throw new Error("Failed to fetch notifications");

        //         const data = await res.json();
        //         setNotifications(data || []);
        //     } catch (err) {
        //         console.error("Notification fetch error:", err);
        //     } finally {
        //         setLoading(false);
        //     }
        // };

        // fetchNotifications();
    }, [open]);

    // Close on ESC
    useEffect(() => {
        if (!open) return;

        const handleEsc = (e: KeyboardEvent) => {
            if (e.key === "Escape") onClose();
        };

        window.addEventListener("keydown", handleEsc);
        return () => window.removeEventListener("keydown", handleEsc);
    }, [open, onClose]);

    if (!open) return null;

    return (
        <>
            {/* Overlay (visual + block clicks, no close) */}
            <div className="fixed inset-0 z-40 bg-black/30" />

            {/* Popup */}
            <div className="fixed top-20 right-4 md:right-8 z-50 w-[90vw] max-w-sm bg-white shadow-xl rounded-xl overflow-hidden">
                {/* Header */}
                <div className="flex items-center justify-between p-4 border-b">
                    <div className="flex items-center gap-2">
                        <Bell className="h-5 w-5" />
                        <h2 className="font-semibold">Your Notifications</h2>
                    </div>

                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            onClose();
                        }}
                    >
                        <X className="h-5 w-5 cursor-pointer" />
                    </button>
                </div>

                {/* Content */}
                <div className="max-h-[60vh] overflow-y-auto">
                    {loading && (
                        <div className="p-4 text-sm text-gray-500">Loading...</div>
                    )}

                    {!loading && notifications.length === 0 && (
                        <div className="p-6 text-center text-sm text-gray-500">
                            No notifications yet
                        </div>
                    )}

                    {!loading &&
                        notifications.map((item) => (
                            <div
                                key={item.id}
                                className={`p-4 border-b text-sm ${item.isRead ? "bg-white" : "bg-gray-50"
                                    }`}
                            >
                                <p className="font-medium">{item.title}</p>
                                <p className="text-gray-600">{item.message}</p>
                                <p className="text-xs text-gray-400 mt-1">
                                    {new Date(item.createdAt).toLocaleString()}
                                </p>
                            </div>
                        ))}
                </div>
            </div>
        </>
    );
}
