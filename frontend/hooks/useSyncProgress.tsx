"use client";

import { useEffect } from "react";
import { useRouter, usePathname } from "next/navigation";
import { useProgressStore } from "@/store/progressStore";
import { redirectByProgress } from '@/lib/redirectByProgress';
import { useGetProfile } from './useAuthMutations';

const PUBLIC_ROUTES = ["/login", "/"];

export const useSyncProgress = () => {
    const setProgress = useProgressStore((s) => s.setProgress);
    const reset = useProgressStore((s) => s.reset);

    const router = useRouter();
    const pathname = usePathname();

    const { data, isLoading } = useGetProfile();

    useEffect(() => {
        // wait until API finishes
        if (isLoading) return;

        const token = localStorage.getItem("ik_access_token");

        // NO TOKEN → force login
        if (!token) {
            reset();

            if (!PUBLIC_ROUTES.includes(pathname)) {
                router.replace("/caretaker");
            }
            return;
        }

        // only run when data exists
        if (!data?.user) return;

        const progress = data.user.progress;

        if (!progress) return;

        setProgress(progress);

        // redirect to last step
        redirectByProgress(progress, router, pathname);

    }, [data, isLoading, pathname, router, setProgress, reset]);
};