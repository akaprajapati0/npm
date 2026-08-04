import { toast } from 'sonner';

export const successToast = (msg: string) => {
    toast.success(msg, {
        style: {
            background: "#059669", // emerald-600
            color: "white",
        },
    });
};

export const errorToast = (msg: string) => {
    toast.error(msg, {
        style: {
            background: "#dc2626", // red-600
            color: "white",
        },
    });
};

export const infoToast = (msg: string) => {
    toast(msg, {
        style: {
            background: "#2563eb", // blue-600
            color: "white",
        },
    });
};
