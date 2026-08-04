"use client";

import { usePathname } from "next/navigation";
import useAuth from "@/store/useAuth";
import useAdminAuth from "@/store/useAdminAuth";
import { useSessionGuard } from "@/hooks/useSessionGuard";

const USER_IDLE_TIMEOUT = 15 * 60 * 1000;
const ADMIN_IDLE_TIMEOUT = 10 * 60 * 1000;

export default function SessionProvider({ children }: { children: React.ReactNode }) {
    const pathname = usePathname();
    const isAdminRoute = pathname?.startsWith("/admin") ?? false;

    const userAccessToken = useAuth((s) => s.accessToken);
    const adminAccessToken = useAdminAuth((s) => s.accessToken);

    // Only one of these is ever actually "live" at a time, gated by isActive,
    // but both hooks must be called unconditionally (rules of hooks).
    useSessionGuard({
        store: useAuth,
        idleTimeout: USER_IDLE_TIMEOUT,
        redirectPath: "/login",
        isActive: !isAdminRoute && !!userAccessToken,
    });

    useSessionGuard({
        store: useAdminAuth,
        idleTimeout: ADMIN_IDLE_TIMEOUT,
        redirectPath: "/admin/login",
        isActive: isAdminRoute && !!adminAccessToken,
    });

    return children;
}