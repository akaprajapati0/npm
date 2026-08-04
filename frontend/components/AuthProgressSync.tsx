"use client";

import { useSyncProgress } from "@/hooks/useSyncProgress";

export default function AuthProgressSync() {
    useSyncProgress();
    return null;
}
