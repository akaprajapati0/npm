import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { AxiosError } from "axios";

import api from "../lib/axios";
import useAuth from '@/store/useAuth';
import { ApiErrorResponse, AuthResponse, LoginPayload, ReactQueryResponse, SendOtpPayload, SignUpPayload, UpdatePasswordValues } from '@/types/schema';
import { useRouter } from 'next/navigation';
import { errorToast, successToast } from '@/utils/toast';
import { useGetPrescription } from './usePrescriptionMutation';
import { useEffect } from 'react';


const isEmail = (value: string) =>
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
        value
    );

const isPhone = (value: string) =>
    /^\+\d{10,15}$/.test(value);

export const useSendOtpRequest = () => {
    return useMutation<
        AuthResponse,
        AxiosError<ApiErrorResponse>,
        SendOtpPayload
    >({
        mutationFn: async ({
            email,
            phone,
        }) => {
            let payload: {
                email?: string;
                phone?: string;
            };

            // ---------- EMAIL ----------
            if (
                typeof email ===
                "string" &&
                email.trim()
            ) {
                const normalizedEmail =
                    email
                        .trim()
                        .toLowerCase();

                if (
                    !isEmail(
                        normalizedEmail
                    )
                ) {
                    throw new Error(
                        "Please enter a valid email address"
                    );
                }

                payload = {
                    email:
                        normalizedEmail,
                };
            }

            // ---------- PHONE ----------
            else if (
                typeof phone ===
                "string" &&
                phone.trim()
            ) {
                const normalizedPhone =
                    phone.trim();

                if (
                    !isPhone(
                        normalizedPhone
                    )
                ) {
                    throw new Error(
                        "Please enter a valid phone number"
                    );
                }

                payload = {
                    phone:
                        normalizedPhone,
                };
            }

            // ---------- NONE ----------
            else {
                throw new Error(
                    "Email or phone is required"
                );
            }

            const { data } =
                await api.post<AuthResponse>(
                    "/auth/send-otp",
                    payload
                );

            return data;
        },

        onSuccess: (data) => {
            successToast(
                data.message ||
                "OTP sent successfully"
            );
        },

        onError: (error) => {
            const message =
                error.response?.data
                    ?.message ||
                error.message ||
                "OTP failed. Please try again.";

            errorToast(message);
        },
    });
};

export const useVerifyOtp = () => {
    return useMutation<ReactQueryResponse, AxiosError<ApiErrorResponse>, { phone?: string, email?: string; otp: string }>({
        mutationFn: async (payload) => {
            const { data } = await api.post<ReactQueryResponse>("/auth/verify-otp", payload);
            return data;
        },
        onSuccess: (resp) => {
            successToast("OTP verified successfully");
        },

        onError: (error) => {
            const message =
                error.response?.data?.message ||
                error.message ||
                "OTP verification failed! Please try again.";
            errorToast(message);
        },
    });
};


// export const useUserSignUp = () => {
//     const setAccessToken = useAuth(
//         (s) => s.setAccessToken
//     );

//     const setUser = useAuth(
//         (s) => s.setUser
//     );

//     return useMutation<
//         AuthResponse,
//         AxiosError<ApiErrorResponse>,
//         SignUpPayload
//     >({
//         mutationFn: async ({
//             country,
//             email,
//             phone,
//             otp,
//         }) => {
//             if (!otp?.trim()) {
//                 throw new Error(
//                     "OTP is required"
//                 );
//             }

//             const payload: {
//                 country: string;
//                 email?: string;
//                 phone?: string;
//                 otp: string;
//             } = {
//                 country,
//                 otp: otp.trim(),
//             };

//             // ---------- EMAIL ----------
//             if (typeof email === "string" && email.trim()) {
//                 const normalizedEmail =
//                     email.trim().toLowerCase();

//                 if (!isEmail(normalizedEmail)) {
//                     throw new Error(
//                         "Invalid email address"
//                     );
//                 }

//                 payload.email = normalizedEmail;
//             }

//             // ---------- PHONE ----------
//             else if (
//                 typeof phone === "string" &&
//                 phone.trim()
//             ) {
//                 const normalizedPhone =
//                     phone.trim();

//                 if (!isPhone(normalizedPhone)) {
//                     throw new Error(
//                         "Invalid phone number"
//                     );
//                 }

//                 payload.phone = normalizedPhone;
//             }

//             // ---------- NONE ----------
//             else {
//                 throw new Error(
//                     "Email or phone is required"
//                 );
//             }

//             const { data } =
//                 await api.post<AuthResponse>(
//                     "/auth/verify-otp-signup",
//                     payload
//                 );

//             return data;
//         },

//         onSuccess: (resp) => {
//             const accessToken =
//                 resp?.data?.accessToken;

//             const user =
//                 resp?.data?.user;

//             if (
//                 !resp?.success ||
//                 !accessToken ||
//                 !user
//             ) {
//                 errorToast(
//                     resp?.message ||
//                     "Signup failed"
//                 );

//                 return;
//             }

//             // ---------- SAVE AUTH ----------
//             setAccessToken(
//                 accessToken,
//                 true
//             );

//             setUser(user);

//             successToast(
//                 resp.message ||
//                 "Signup successful"
//             );
//         },

//         onError: (error) => {
//             const message =
//                 error.response?.data
//                     ?.message ||
//                 error.message ||
//                 "Signup failed. Please try again.";

//             errorToast(message);
//         },
//     });
// };


export const useUserSignUp = () => {
    const setAccessToken = useAuth((s) => s.setAccessToken);
    const setUser = useAuth((s) => s.setUser);

    return useMutation<AuthResponse, AxiosError<ApiErrorResponse>, SignUpPayload>({
        mutationFn: async ({
            country,
            email,
            phone,
            otp,
        }) => {
            if (!otp?.trim()) {
                throw new Error(
                    "OTP is required"
                );
            }

            const payload: {
                country: string;
                email?: string;
                phone?: string;
                otp: string;
            } = {
                country,
                otp: otp.trim(),
            };

            // ---------- EMAIL ----------
            if (typeof email === "string" && email.trim()) {
                const normalizedEmail =
                    email.trim().toLowerCase();

                if (!isEmail(normalizedEmail)) {
                    throw new Error(
                        "Invalid email address"
                    );
                }

                payload.email = normalizedEmail;
            }

            // ---------- PHONE ----------
            else if (
                typeof phone === "string" &&
                phone.trim()
            ) {
                const normalizedPhone =
                    phone.trim();

                if (!isPhone(normalizedPhone)) {
                    throw new Error(
                        "Invalid phone number"
                    );
                }

                payload.phone = normalizedPhone;
            }

            // ---------- NONE ----------
            else {
                throw new Error(
                    "Email or phone is required"
                );
            }

            const { data } =
                await api.post<AuthResponse>(
                    "/auth/verify-otp-signup",
                    payload
                );

            return data;
        },

        onSuccess: (resp) => {
            const accessToken = resp.data?.accessToken;
            const user = resp.data?.user;

            if (!resp.success || !accessToken || !user) {
                errorToast("Signup failed");
                return;
            }

            // Save auth state only
            setAccessToken(accessToken);
            setUser(user);

            successToast(resp.message || "Signup successful");
        },

        onError: (error) => {
            const message =
                error.response?.data?.message ||
                error.message ||
                "Signup failed. Please try again.";

            errorToast(message);
        },
    });
};

export const useLogin = () => {
    const setAccessToken = useAuth((s) => s.setAccessToken);
    const setUser = useAuth((s) => s.setUser);
    const setRole = useAuth((s) => s.setRole);

    return useMutation<AuthResponse, Error, LoginPayload>({
        mutationFn: async (payload) => {
            const { identifier, ...rest } = payload;
            const isEmail = identifier?.includes("@") ?? false;

            const formattedPayload = {
                ...rest,
                ...(isEmail ? { email: identifier } : { phone: identifier }),
            };

            const { data } = await api.post<AuthResponse>("/auth/user-login", formattedPayload);
            return data;
        },

        onSuccess: (resp) => {
            try {
                const accessToken = resp?.data?.accessToken ?? resp?.accessToken;
                const user = resp?.data?.user ?? resp?.user;
                const isSuccess = resp?.success ?? resp?.data?.success ?? false;

                if (!isSuccess || !accessToken || !user) {
                    errorToast("Login failed");
                    return;
                }

                setAccessToken(accessToken);
                setUser(user);
                setRole(user?.role ?? "user")
                successToast("Login successful!");

                // setProgress(progress as any)
                // const nextRoute = PROGRESS_ROUTES[progress!] || "/home";
                // router.replace(nextRoute);
            } catch (error) {
                console.error("Error in onSuccess:", error);
                errorToast("An error occurred");
            }
        },

        onError: (error) => {
            const message = (error as any)?.response?.data?.message ||
                error.message ||
                "Login failed! Please try again.";
            errorToast(message);
        },

    });
};

export const useLogout = () => {
    const router = useRouter();
    const queryClient = useQueryClient();

    // Accessing the same store as useLogin
    const setAccessToken = useAuth((s) => s.setAccessToken);
    const setUser = useAuth((s) => s.setUser);
    const clearAuth = useAuth((s) => s.clearAuth);

    return useMutation({
        mutationFn: async () => {
            // Call the backend to invalidate the session/refresh token
            await api.post("/auth/logout");
        },

        onMutate: async () => {
            setAccessToken(null);
            setUser(null);
            clearAuth();
        },

        onSuccess: () => {
            queryClient.clear();

            successToast("Logged out successfully");

            router.push("/caretaker");
        },

        onError: (error) => {
            console.error("Logout error:", error);
            // Even if the API call fails, we usually want to force-clear local data
            setAccessToken(null);
            setUser(null);
            queryClient.clear();
            router.push("/");
        },
    });
};

// startup refresh hook - call on app mount to obtain access token if refresh cookie exists
// export const tryRefreshOnStartup = async () => {
//     try {
//         const resp = await api.post("/caretaker/refresh-token");

//         // Normalize token location from response
//         const token = resp?.data?.data?.accessToken ?? resp?.data?.accessToken;
//         const user = resp?.data?.data?.user ?? resp?.data?.user ?? null;

//         if (!token) throw new Error("No token returned");

//         setAccessToken(token);
//         if (user) useAuth.getState().setUser(user);

//         return true;

//     } catch (err: any) {
//         const status = err?.response?.status;

//         // Only clear auth + show toast on actual auth failures
//         if (status === 401 || status === 403) {
//             useAuth.getState().clearAuth();
//             errorToast("Session expired. Please log in again.");
//             return false;
//         }

//         // Network/server down — don't clear auth, let user retry
//         if (!status) {
//             console.warn("Network error during startup refresh:", err.message);
//             return false; // Silent fail — user stays "logged in" optimistically
//         }

//         // Any unexpected error (500 etc) — clear auth silently
//         useAuth.getState().clearAuth();
//         return false;
//     }
// };

// update user password
export const useUpdatePassword = (onSuccessCb?: () => void) => {
    return useMutation({
        mutationFn: async (payload: Omit<UpdatePasswordValues, "confirmPassword">) => {
            const { identifier, ...rest } = payload;
            const isEmail = identifier?.includes("@") ?? false;

            const formattedPayload = {
                ...rest,
                ...(isEmail ? { email: identifier } : { phone: identifier }),
            };
            const { data } = await api.post("/auth/update-password", formattedPayload);
            return data;
        },
        onSuccess: (res) => {
            if (res.success) {
                successToast("Password updated successfully!");
                if (onSuccessCb) onSuccessCb();
            } else {
                errorToast(res.message || "Failed to update password");
            }
        },
        onError: (err: any) => {
            console.log(err)
            errorToast(err?.response?.data?.message || "Something went wrong");
        },
    });
};

// export const useUpdateProfile = () => {
//     return useMutation({
//         mutationFn: async (formData: FormData) => {
//             const { data } = await api.put("/auth/update-profile", formData, {
//                 headers: { "Content-Type": "multipart/form-data" },
//             });
//             return data;
//         },
//         onSuccess: (res) => {
//             if (res.success) {
//                 successToast("Profile updated successfully!");
//             } else {
//                 errorToast(res.message || "Failed to update profile");
//             }
//         },
//         onError: (err: any) => {
//             console.log(err)
//             errorToast(err?.response?.data?.message || "Something went wrong");
//         },
//     });
// };


// Keep it simple with auto-refetch on focus and manual invalidation
export const useGetProfile = () => {
    const queryClient = useQueryClient();

    // Invalidate profile when prescription status changes
    const { data: prescriptionData } = useGetPrescription();

    useEffect(() => {
        if (prescriptionData) {
            queryClient.invalidateQueries({ queryKey: ['profile'] });
        }
    }, [prescriptionData, queryClient]);

    return useQuery({
        queryKey: ['profile'],
        queryFn: async () => {
            const { data } = await api.get("/auth/get-user");
            return data?.data;
        },
        staleTime: 30000, // 30 seconds - balance between freshness and performance
        refetchOnWindowFocus: true,
        retry: 1,
    });
};

export const useDeactivateAccount = () => {
    return useMutation({
        mutationFn: async () => {
            const response = await api.put(
                "/auth/deactivate-account"
            );

            return response.data;
        },
    });
};

export const useReactivateAccount = () => {
    const queryClient =
        useQueryClient();

    return useMutation({
        mutationFn: async (
            userId: string
        ) => {
            const response =
                await api.put(
                    `/auth/admin/reactivate-account/${userId}`
                );

            return response.data;
        },

        onSuccess: () => {
            queryClient.invalidateQueries(
                {
                    queryKey: [
                        "users",
                    ],
                }
            );
        },
    });
};

// export const useGetProfile = () => {
//     return useQuery({
//         queryKey: ['profile'],
//         queryFn: async () => {
//             const { data } = await api.get("/auth/get-user");
//             return data?.data;
//         },
//         staleTime: 1000 * 60 * 5,

//         gcTime: 1000 * 60 * 10,

//         refetchOnWindowFocus: false,

//         retry: 1,
//     });
// };