"use client";

import { useEffect, useRef } from "react";
import { useRouter } from "next/navigation";
import type { StoreApi, UseBoundStore } from "zustand";

const ACTIVITY_THROTTLE = 1000; // don't write to store more than once/sec
const CHECK_INTERVAL = 10000;

interface SessionGuardState {
    lastActivity: number;
    updateActivity: () => void;
    clearAuth: () => void;
}

interface SessionGuardOptions<T extends SessionGuardState> {
    store: UseBoundStore<StoreApi<T>>;
    idleTimeout: number;
    redirectPath: string;
    /** Only run the idle check while this is true (e.g. accessToken !== null) */
    isActive: boolean;
}

export function useSessionGuard<T extends SessionGuardState>({
    store,
    idleTimeout,
    redirectPath,
    isActive,
}: SessionGuardOptions<T>) {
    const router = useRouter();
    const updateActivity = store((s) => s.updateActivity);
    const clearAuth = store((s) => s.clearAuth);

    const lastUpdateRef = useRef(0);

    useEffect(() => {
        if (!isActive) return;

        const events = [
            "mousemove",
            "mousedown",
            "keydown",
            "scroll",
            "touchstart",
            "touchmove",
            "click",
            "focus",
        ];

        const handleActivity = () => {
            const now = Date.now();
            if (now - lastUpdateRef.current < ACTIVITY_THROTTLE) return;
            lastUpdateRef.current = now;
            updateActivity();
        };

        events.forEach((event) => {
            window.addEventListener(event, handleActivity, { passive: true });
        });

        const visibilityHandler = () => {
            if (document.visibilityState === "visible") {
                handleActivity();
            }
        };

        document.addEventListener("visibilitychange", visibilityHandler);

        const interval = setInterval(() => {
            const { lastActivity } = store.getState();
            const isIdle = Date.now() - lastActivity > idleTimeout;

            if (isIdle) {
                clearAuth();
                router.replace(redirectPath);
            }
        }, CHECK_INTERVAL);

        return () => {
            events.forEach((event) => {
                window.removeEventListener(event, handleActivity);
            });
            document.removeEventListener("visibilitychange", visibilityHandler);
            clearInterval(interval);
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [isActive, idleTimeout, redirectPath, store]);
}