// store/useAdminAuth.ts
"use client";

import { create } from "zustand";

export type Admin = {
    id?: string;
    fullname?: string;
    email?: string;
    role?: "SUPER_ADMIN" | "ADMIN" | "TEMP_ADMIN";
} | null;

type AdminRole = "SUPER_ADMIN" | "ADMIN" | "TEMP_ADMIN" | null;

type AdminAuthState = {
    accessToken: string | null;
    admin: Admin;
    role: AdminRole;
    lastActivity: number;

    setAccessToken: (token: string | null) => void;
    setAdmin: (admin: Admin) => void;
    setRole: (role: AdminRole) => void;
    updateActivity: () => void;
    clearAuth: () => void;
};

export const useAdminAuth = create<AdminAuthState>((set) => ({
    accessToken: null,
    admin: null,
    role: null,
    lastActivity: Date.now(),

    setAccessToken: (token) => set({ accessToken: token }),
    setAdmin: (admin) => set({ admin }),
    setRole: (role) => set({ role }),

    updateActivity: () => set({ lastActivity: Date.now() }),

    clearAuth: () =>
        set({
            accessToken: null,
            admin: null,
            role: null,
            lastActivity: Date.now(),
        }),
}));

// Helpers
export const getAdminAccessToken = () => useAdminAuth.getState().accessToken;
export const setAdminAccessToken = (token: string | null) =>
    useAdminAuth.getState().setAccessToken(token);
export const updateAdminActivity = () => useAdminAuth.getState().updateActivity();
export const clearAdminAuth = () => useAdminAuth.getState().clearAuth();
export const getAdminRole = () => useAdminAuth.getState().role;

export default useAdminAuth;

// "use client";

// import { create } from "zustand";

// export type Admin = {
//     id?: string;
//     fullname?: string;
//     email?: string;
//     role?: "SUPER_ADMIN" | "ADMIN" | "TEMP_ADMIN";
// } | null;

// type AdminRole =
//     | "SUPER_ADMIN"
//     | "ADMIN"
//     | "TEMP_ADMIN"
//     | null;

// type AdminAuthState = {
//     accessToken: string | null;
//     admin: Admin;
//     role: AdminRole;

//     setAccessToken: (
//         token: string | null
//     ) => void;

//     setAdmin: (
//         admin: Admin
//     ) => void;

//     setRole: (
//         role: AdminRole
//     ) => void;

//     clearAuth: () => void;
// };

// export const useAdminAuth =
//     create<AdminAuthState>((set) => ({
//         accessToken: null,

//         admin: null,

//         role: null,

//         setAccessToken: (token) =>
//             set({
//                 accessToken: token,
//             }),

//         setAdmin: (admin) =>
//             set({
//                 admin,
//             }),

//         setRole: (role) =>
//             set({
//                 role,
//             }),

//         clearAuth: () =>
//             set({
//                 accessToken: null,
//                 admin: null,
//                 role: null,
//             }),
//     }));

// // Helpers

// export const getAdminAccessToken =
//     () =>
//         useAdminAuth.getState()
//             .accessToken;

// export const setAdminAccessToken =
//     (token: string | null) =>
//         useAdminAuth
//             .getState()
//             .setAccessToken(token);

// export const clearAdminAuth =
//     () =>
//         useAdminAuth
//             .getState()
//             .clearAuth();

// export default useAdminAuth;