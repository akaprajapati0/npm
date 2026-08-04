import axios, {
    AxiosError,
    AxiosInstance,
    InternalAxiosRequestConfig,
} from "axios";

import {
    clearAdminAuth,
    getAdminAccessToken,
    setAdminAccessToken,
} from "@/store/useAdminAuth";

const API_BASE = process.env.NEXT_PUBLIC_API_URL!;

const adminApi: AxiosInstance = axios.create({
    baseURL: API_BASE,
    withCredentials: true,
    headers: {
        "Content-Type": "application/json"
    },
});

let isRefreshing = false;

let failedQueue: {
    resolve: (value?: any) => void;
    reject: (err?: any) => void;
    config: InternalAxiosRequestConfig;
}[] = [];

const processQueue = (
    error: any,
    token: string | null = null
) => {
    failedQueue.forEach(
        ({ resolve, reject, config }) => {
            if (error) {
                reject(error);
            } else {
                if (token) {
                    config.headers = config.headers ?? {};
                    config.headers.Authorization = `Bearer ${token}`;
                }

                resolve(adminApi(config));
            }
        }
    );

    failedQueue = [];
};

// ================= REQUEST =================

adminApi.interceptors.request.use((config) => {
    const token =
        getAdminAccessToken();

    if (token) {
        config.headers =
            config.headers ?? {};

        config.headers.Authorization =
            `Bearer ${token}`;
    }

    // if sending FormData (file uploads), let the browser set
    // multipart/form-data with the correct boundary automatically
    if (config.data instanceof FormData) {
        delete config.headers["Content-Type"];
    }

    return config;
});

// ================= RESPONSE =================

adminApi.interceptors.response.use(
    (response) => response,

    async (
        error: AxiosError & {
            config?: InternalAxiosRequestConfig;
        }
    ) => {
        const originalConfig = error.config;

        if (!originalConfig) {
            return Promise.reject(error);
        }

        const is401 =
            error.response?.status === 401;

        const adminAuthRoutes = [
            "/admin/login",
            "/admin/refresh",
        ];

        const isAdminAuthRoute =
            adminAuthRoutes.some((route) =>
                originalConfig.url?.includes(route)
            );

        if (is401 && !isAdminAuthRoute) {
            if (isRefreshing) {
                return new Promise(
                    (resolve, reject) => {
                        failedQueue.push({
                            resolve,
                            reject,
                            config: originalConfig,
                        });
                    }
                );
            }

            isRefreshing = true;

            try {
                const resp = await axios.post(
                    `${API_BASE}/admin/refresh`,
                    {},
                    {
                        withCredentials: true,
                    }
                );

                const newAccessToken =
                    resp.data?.data?.accessToken ||
                    resp.data?.accessToken;

                if (!newAccessToken) {
                    throw new Error(
                        "No access token received"
                    );
                }

                setAdminAccessToken(
                    newAccessToken
                );

                processQueue(
                    null,
                    newAccessToken
                );

                originalConfig.headers =
                    originalConfig.headers ?? {};

                originalConfig.headers.Authorization =
                    `Bearer ${newAccessToken}`;

                return adminApi(
                    originalConfig
                );
            } catch (refreshError) {
                processQueue(
                    refreshError,
                    null
                );

                clearAdminAuth();

                if (
                    typeof window !==
                    "undefined"
                ) {
                    window.location.replace(
                        "/admin/login"
                    );
                }

                return Promise.reject(
                    refreshError
                );
            }
        }

        return Promise.reject(error);
    }
);

export default adminApi;