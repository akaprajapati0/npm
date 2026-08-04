"use client";

import { useGetProfile } from "@/hooks/useAuthMutations";
import { redirectByProgress } from "@/lib/redirectByProgress";
import { useProgressStore } from "@/store/progressStore";
import { setAccessToken } from "@/store/useAuth";
import { useSearchParams, useRouter, usePathname } from "next/navigation";
import { useEffect, Suspense } from "react";

function CallbackContent() {
    const searchParams = useSearchParams();
    const router = useRouter();
    const pathname = usePathname();

    const setProgress = useProgressStore((s) => s.setProgress);

    const token = searchParams.get("token");

    // Fetch profile only after token exists
    const { data, isLoading, isError } = useGetProfile();

    useEffect(() => {
        if (!token) {
            router.replace("/login");
            return;
        }

        setAccessToken(token);
    }, [token, router]);

    useEffect(() => {
        if (!token) return;
        if (isLoading) return;

        if (isError || !data?.user) {
            router.replace("/login");
            return;
        }

        const progress = data.user.progress;

        // Sync Zustand store
        setProgress(progress);

        // Redirect based on progress object
        redirectByProgress(progress, router, pathname);

    }, [token, data, isLoading, isError, router, pathname, setProgress]);

    return (
        <div className="flex flex-col items-center justify-center min-h-screen">
            <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary mb-4"></div>
            <p className="text-lg animate-pulse">Completing login...</p>
        </div>
    );
}

export default function AuthCallbackPage() {
    return (
        <Suspense fallback={<LoadingUI />}>
            <CallbackContent />
        </Suspense>
    );
}

function LoadingUI() {
    return (
        <div className="flex items-center justify-center min-h-screen">
            <p className="text-lg">Loading...</p>
        </div>
    );
}