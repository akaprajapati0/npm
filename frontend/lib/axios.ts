// import axios, {
//     AxiosError,
//     AxiosInstance,
//     InternalAxiosRequestConfig,
// } from "axios";

// import {
//     clearAuth,
//     getAccessToken,
//     setAccessToken,
//     // updateActivity,
// } from "@/store/useAuth";

// const API_BASE = process.env.NEXT_PUBLIC_API_URL!;

// // ================= API INSTANCE =================

// const api: AxiosInstance = axios.create({
//     baseURL: API_BASE,
//     withCredentials: true,
//     headers: {
//         "Content-Type": "application/json",
//     },
// });

// // ================= REFRESH QUEUE =================

// let isRefreshing = false;

// let failedQueue: {
//     resolve: (value?: any) => void;
//     reject: (err?: any) => void;
//     config: InternalAxiosRequestConfig;
// }[] = [];

// const processQueue = (
//     error: any,
//     token: string | null = null
// ) => {
//     failedQueue.forEach(
//         ({ resolve, reject, config }) => {
//             if (error) {
//                 reject(error);
//             } else {
//                 if (token) {
//                     config.headers =
//                         config.headers ?? {};

//                     config.headers[
//                         "Authorization"
//                     ] = `Bearer ${token}`;
//                 }

//                 resolve(api(config));
//             }
//         }
//     );

//     failedQueue = [];
// };

// // ================= REQUEST =================

// api.interceptors.request.use(
//     (config) => {
//         const token = getAccessToken();

//         // attach token
//         if (token) {
//             config.headers = config.headers ?? {};

//             config.headers[
//                 "Authorization"
//             ] = `Bearer ${token}`;
//         }

//         // update activity on every request
//         // useful for mobile + desktop
//         // updateActivity();

//         return config;
//     },
//     (error) => Promise.reject(error)
// );

// // ================= RESPONSE =================

// api.interceptors.response.use(
//     (response) => {
//         // successful response = active session
//         // updateActivity();

//         return response;
//     },

//     async (
//         error: AxiosError & {
//             config?: InternalAxiosRequestConfig & {
//                 _retry?: boolean;
//             };
//         }
//     ) => {
//         const originalConfig = error.config;

//         if (!originalConfig) {
//             return Promise.reject(error);
//         }

//         const is401 =
//             error.response?.status === 401;

//         // prevent infinite retry loop
//         if (originalConfig._retry) {
//             return Promise.reject(error);
//         }

//         // auth endpoints
//         const authRoutes = [
//             "/auth/user-login",
//             "/auth/refresh-token",
//             "/auth/send-otp",
//             "/auth/verify-otp",
//             "/auth/verify-otp-signup",
//         ];

//         const isAuthRoute =
//             authRoutes.some((route) =>
//                 originalConfig.url?.includes(route)
//             );

//         // only refresh for protected APIs
//         if (is401 && !isAuthRoute) {
//             // ================= ALREADY REFRESHING =================

//             if (isRefreshing) {
//                 return new Promise(
//                     (resolve, reject) => {
//                         failedQueue.push({
//                             resolve,
//                             reject,
//                             config: originalConfig,
//                         });
//                     }
//                 );
//             }

//             // ================= START REFRESH =================

//             originalConfig._retry = true;

//             isRefreshing = true;

//             try {
//                 const refreshResponse =
//                     await axios.post(
//                         `${API_BASE}/auth/refresh-token`,
//                         {},
//                         {
//                             withCredentials: true,
//                         }
//                     );

//                 const newAccessToken =
//                     refreshResponse.data?.data
//                         ?.accessToken ||
//                     refreshResponse.data
//                         ?.accessToken;

//                 if (!newAccessToken) {
//                     throw new Error(
//                         "No access token received"
//                     );
//                 }

//                 // update zustand store
//                 setAccessToken(newAccessToken);

//                 // process waiting requests
//                 processQueue(
//                     null,
//                     newAccessToken
//                 );

//                 // retry original request
//                 originalConfig.headers =
//                     originalConfig.headers ?? {};

//                 originalConfig.headers[
//                     "Authorization"
//                 ] = `Bearer ${newAccessToken}`;

//                 return api(originalConfig);
//             } catch (refreshError) {
//                 processQueue(refreshError, null);

//                 // clear auth safely
//                 clearAuth();

//                 // redirect only on browser
//                 if (
//                     typeof window !== "undefined"
//                 ) {
//                     window.location.href =
//                         "/caretaker";
//                 }

//                 return Promise.reject(
//                     refreshError
//                 );
//             } finally {
//                 isRefreshing = false;
//             }
//         }

//         return Promise.reject(error);
//     }
// );

// export default api;

//
import axios, {
    AxiosError,
    AxiosInstance,
    InternalAxiosRequestConfig,
} from "axios";
import {
    clearAuth,
    getAccessToken,
    setAccessToken,
} from "@/store/useAuth";

const API_BASE = process.env.NEXT_PUBLIC_API_URL!;

const api: AxiosInstance = axios.create({
    baseURL: API_BASE,
    withCredentials: true,
    headers: {
        "Content-Type": "application/json",
    },
});

// ================= QUEUE =================
let isRefreshing = false;

let failedQueue: {
    resolve: (value?: any) => void;
    reject: (err?: any) => void;
    config: InternalAxiosRequestConfig;
}[] = [];

const processQueue = (error: any, token: string | null = null) => {
    failedQueue.forEach(({ resolve, reject, config }) => {
        if (error) {
            reject(error);
        } else {
            if (token) {
                config.headers = config.headers ?? {};
                config.headers["Authorization"] = `Bearer ${token}`;
            }
            resolve(api(config));
        }
    });

    failedQueue = [];
};

// ================= REQUEST =================
api.interceptors.request.use((config) => {
    const token = getAccessToken();

    if (token) {
        config.headers = config.headers ?? {};
        config.headers["Authorization"] = `Bearer ${token}`;
    }

    return config;
});

// ================= RESPONSE =================
type RetryableConfig = InternalAxiosRequestConfig & { _retry?: boolean };

api.interceptors.response.use(
    (res) => res,
    async (error: AxiosError & { config?: RetryableConfig }) => {
        const originalConfig = error.config;

        if (!originalConfig) return Promise.reject(error);

        const is401 = error.response?.status === 401;
        const authRoutes = [
            "/auth/user-login",
            "/auth/refresh-token",
            "/auth/send-otp",
            "/auth/verify-otp",
            "/auth/verify-otp-signup",
        ];

        const isAuthRoute =
            authRoutes.some((route) =>
                originalConfig.url?.includes(route)
            );

        // ---- Only retry a request ONCE ----
        if (is401 && !isAuthRoute && !originalConfig._retry) {
            originalConfig._retry = true;

            // Already refreshing → queue requests
            if (isRefreshing) {
                return new Promise((resolve, reject) => {
                    failedQueue.push({
                        resolve,
                        reject,
                        config: originalConfig,
                    });
                });
            }

            isRefreshing = true;

            try {
                const resp = await axios.post(
                    `${API_BASE}/auth/refresh-token`,
                    {},
                    { withCredentials: true }
                );

                const newAccessToken =
                    resp.data?.data?.accessToken || resp.data?.accessToken;

                if (!newAccessToken) {
                    throw new Error("No access token received");
                }

                setAccessToken(newAccessToken);

                processQueue(null, newAccessToken);

                originalConfig.headers = originalConfig.headers ?? {};
                originalConfig.headers["Authorization"] = `Bearer ${newAccessToken}`;

                return api(originalConfig);
            } catch (refreshErr) {
                processQueue(refreshErr, null);
                clearAuth();

                return Promise.reject(refreshErr);
            } finally {
                isRefreshing = false;
            }
        }

        return Promise.reject(error);
    }
);

export default api;
//

// import axios, {
//     AxiosError,
//     AxiosInstance,
//     InternalAxiosRequestConfig,
// } from "axios";
// import {
//     clearAuth,
//     getAccessToken,
//     setAccessToken,
// } from "@/store/useAuth";

// const API_BASE = process.env.NEXT_PUBLIC_API_URL!;

// const api: AxiosInstance = axios.create({
//     baseURL: API_BASE,
//     withCredentials: true,
//     headers: {
//         "Content-Type": "application/json",
//     },
// });

// // ================= QUEUE =================
// let isRefreshing = false;

// let failedQueue: {
//     resolve: (value?: any) => void;
//     reject: (err?: any) => void;
//     config: InternalAxiosRequestConfig;
// }[] = [];

// const processQueue = (error: any, token: string | null = null) => {
//     failedQueue.forEach(({ resolve, reject, config }) => {
//         if (error) {
//             reject(error);
//         } else {
//             if (token) {
//                 config.headers = config.headers ?? {};
//                 config.headers["Authorization"] = `Bearer ${token}`;
//             }
//             resolve(api(config));
//         }
//     });

//     failedQueue = [];
// };

// // ================= REQUEST =================
// api.interceptors.request.use((config) => {
//     const token = getAccessToken();

//     if (token) {
//         config.headers = config.headers ?? {};
//         config.headers["Authorization"] = `Bearer ${token}`;
//     }

//     return config;
// });

// // ================= RESPONSE =================
// api.interceptors.response.use(
//     (res) => res,
//     async (error: AxiosError & { config?: InternalAxiosRequestConfig }) => {
//         const originalConfig = error.config;

//         if (!originalConfig) return Promise.reject(error);

//         const is401 = error.response?.status === 401;
//         // const isRefreshCall = originalConfig.url?.includes("/auth/refresh-token");
//         const authRoutes = [
//             "/auth/user-login",
//             "/auth/refresh-token",
//             "/auth/send-otp",
//             "/auth/verify-otp",
//             "/auth/verify-otp-signup",
//         ];

//         const isAuthRoute =
//             authRoutes.some((route) =>
//                 originalConfig.url?.includes(route)
//             );

//         if (is401 && !isAuthRoute) {
//             // Already refreshing → queue requests
//             if (isRefreshing) {
//                 return new Promise((resolve, reject) => {
//                     failedQueue.push({
//                         resolve,
//                         reject,
//                         config: originalConfig,
//                     });
//                 });
//             }

//             isRefreshing = true;

//             try {
//                 const resp = await axios.post(
//                     `${API_BASE}/auth/refresh-token`,
//                     {},
//                     { withCredentials: true }
//                 );

//                 const newAccessToken =
//                     resp.data?.data?.accessToken || resp.data?.accessToken;

//                 if (!newAccessToken) {
//                     throw new Error("No access token received");
//                 }

//                 setAccessToken(newAccessToken);

//                 processQueue(null, newAccessToken);

//                 originalConfig.headers = originalConfig.headers ?? {};
//                 originalConfig.headers["Authorization"] = `Bearer ${newAccessToken}`;

//                 return api(originalConfig);
//             } catch (refreshErr) {
//                 processQueue(refreshErr, null);
//                 clearAuth();

//                 return Promise.reject(refreshErr);
//             } finally {
//                 isRefreshing = false;
//             }
//         }

//         return Promise.reject(error);
//     }
// );

// export default api;
