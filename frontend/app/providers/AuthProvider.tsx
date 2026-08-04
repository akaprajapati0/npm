"use client";

import { useEffect } from "react";

import api from "@/lib/axios";

import {
    setAccessToken,
    useAuth,
} from "@/store/useAuth";

export default function AuthProvider({
    children,
}: {
    children: React.ReactNode;
}) {
    const setHydrated = useAuth(
        (s) => s.setHydrated
    );

    useEffect(() => {
        const restoreSession = async () => {
            try {
                const response = await api.post(
                    "/auth/refresh-token"
                );

                const accessToken =
                    response.data?.data
                        ?.accessToken ||
                    response.data?.accessToken;

                if (accessToken) {
                    setAccessToken(accessToken);
                }
            } catch (error) {
                console.log(
                    "No active session"
                );
            } finally {
                setHydrated(true);
            }
        };

        restoreSession();
    }, []);

    return <>{children}</>;
}