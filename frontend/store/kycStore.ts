import { create } from "zustand";

interface KycFilesState {
    front: File | null;
    back: File | null;
    setFront: (file: File) => void;
    setBack: (file: File) => void;
    clear: () => void;
}

export const kycStore = create<KycFilesState>((set) => ({
    front: null,
    back: null,

    setFront: (file) => set({ front: file }),
    setBack: (file) => set({ back: file }),

    clear: () => set({ front: null, back: null }),
}));
