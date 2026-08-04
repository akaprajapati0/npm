import { create } from "zustand";
import { UploadDocumentBtnState } from '@/types/componentTypes';


export const useComponentStore = create<UploadDocumentBtnState>((set) => ({
    kycType: "",
    setKycType: (type) => set({ kycType: type }),

    isPrescriptionUploaded: false,
    setIsPrescriptionUploaded: (value) => set({ isPrescriptionUploaded: value }),
}))
