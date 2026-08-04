"use client";

import { create } from "zustand";

type User = {
  id?: string;
  email?: string;
  name?: string;
  device?: string;
} | null;

type Role = "user" | "SUPER_ADMIN" | "TEMP_ADMIN" | "ADMIN" | null;

type AuthState = {
  accessToken: string | null;
  user: User;
  role: Role;
  isHydrated: boolean;

  lastActivity: number;

  setHydrated: (value: boolean) => void;

  setRole: (role: Role) => void;

  setAccessToken: (token: string | null) => void;
  setUser: (user: User) => void;

  updateActivity: () => void;

  clearAuth: () => void;
};

export const useAuth = create<AuthState>((set) => ({
  accessToken: null,

  user: null,
  role: null,
  isHydrated: false,

  lastActivity: Date.now(),

  setHydrated: (value) =>
    set({
      isHydrated: value,
    }),

  setRole: (role) => set({ role }),

  setAccessToken: (token) => {
    set({ accessToken: token });
  },

  setUser: (user) => {
    set({ user });
  },

  updateActivity: () => {
    set({
      lastActivity: Date.now(),
    });
  },

  clearAuth: () => {
    set({
      accessToken: null,
      user: null,
      role: null,
      lastActivity: Date.now(),
    });
  },
}));

// helpers

export const getAccessToken = () =>
  useAuth.getState().accessToken;

export const setAccessToken = (
  token: string | null
) => useAuth.getState().setAccessToken(token);

export const updateActivity = () =>
  useAuth.getState().updateActivity();

export const clearAuth = () =>
  useAuth.getState().clearAuth();

export const getRole = () =>
  useAuth.getState().role;

export default useAuth;

// import { create } from "zustand";

// type User = {
//   id?: string;
//   email?: string;
//   name?: string;
//   device?: string;
// } | null;

// type AuthState = {
//   accessToken: string | null;
//   user: User;
//   setAccessToken: (token: string | null, persist?: boolean) => void;
//   setUser: (user: User) => void;
//   clearAuth: () => void;
// };

// const ACCESS_TOKEN_KEY = "ik_access_token";

// export const useAuth = create<AuthState>((set) => ({
//   accessToken: typeof window !== "undefined" ? (localStorage.getItem(ACCESS_TOKEN_KEY) ?? null) : null,
//   user: null,
//   setAccessToken: (token, persist = false) => {
//     set({ accessToken: token });
//     if (typeof window !== "undefined") {
//       if (persist && token) localStorage.setItem(ACCESS_TOKEN_KEY, token);
//       if (!token) localStorage.removeItem(ACCESS_TOKEN_KEY);
//     }
//   },
//   setUser: (user) => set({ user }),
//   clearAuth: () => {
//     set({ accessToken: null, user: null });
//     if (typeof window !== "undefined") localStorage.removeItem(ACCESS_TOKEN_KEY);
//   },
// }));

// // helpers for use in non-react modules (axios)
// export const getAccessToken = () => useAuth.getState().accessToken;
// export const setAccessToken = (token: string | null, persist = false) => useAuth.getState().setAccessToken(token, persist);
// export const clearAuth = () => useAuth.getState().clearAuth();

// export default useAuth;

// for admin use
// /store/useAuth.ts
// import { create } from "zustand";

// interface AuthState {
//   accessToken: string | null;
//   user: any | null;
//   setAccessToken: (token: string, persist?: boolean) => void;
//   setUser: (user: any) => void;
//   clearAuth: () => void;
// }

// const useAuth = create<AuthState>((set) => ({
//   accessToken: null,
//   user: null,

//   setAccessToken: (token) => set({ accessToken: token }),
//   setUser: (user) => set({ user }),

//   clearAuth: () => set({ accessToken: null, user: null }),
// }));

// export default useAuth;