import { create } from "zustand";

interface UploadDocumentState {
    files: File[];
    addFiles: (newFiles: File[]) => void;
    removeFile: (index: number) => void;
    clearFiles: () => void;
}

export const uploadDocumentStore = create<UploadDocumentState>((set) => ({
    files: [],
    addFiles: (newFiles) =>
        set((state) => ({
            files: [...state.files, ...newFiles].slice(0, 12),
        })),
    removeFile: (index) =>
        set((state) => ({
            files: state.files.filter((_, i) => i !== index),
        })),
    clearFiles: () => set({ files: [] }),
}));
