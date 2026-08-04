import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import useAuth from "@/store/useAuth";
import {
  AdminRegisterFormValues,
  AdminLoginValues,
  AuthResponse,
  Admin,
  GetAllAdminsResponse,
  UpdateAdminPayload,
} from "@/types/adminSchema";
import { useRouter } from "next/navigation";
import { errorToast, successToast } from "@/utils/toast";
import api from '@/lib/axios';
import adminApi from '@/lib/adminApi';
import useAdminAuth, { clearAdminAuth, setAdminAccessToken } from '@/store/useAdminAuth';

interface PaymentPayload {
  user: string;
  paymentReceived?: string;
  paymentLeft?: string;
  accountNumber?: string;
  ifsc?: string;
  branch?: string;
}

interface ReactQueryResponse {
  success: boolean;
  message: string;
  data?: any;
}

// interface AdminRole {
//   role: "SUPER_ADMIN" | "ADMIN" | "TEMP_ADMIN";
// }

export const useAdminLogin = () => {
  const router = useRouter();

  const setAdmin =
    useAdminAuth(
      (s) => s.setAdmin
    );

  const setRole =
    useAdminAuth(
      (s) => s.setRole
    );

  return useMutation<
    AuthResponse,
    Error,
    AdminLoginValues
  >({
    mutationFn: async (
      payload
    ) => {
      const res =
        await adminApi.post(
          "/admin/login",
          payload,
        );

      return res.data;
    },

    onSuccess: (resp) => {
      const accessToken =
        resp?.data?.accessToken;

      const admin: Admin | null =
        resp?.data?.admin ||
        (resp?.data?.admin?._id
          ? {
            id:
              resp.data.admin._id,
            fullname:
              resp.data
                ?.admin
                ?.fullname ||
              "Admin",
            email:
              resp.data
                ?.admin.email,
            role:
              resp.data
                ?.admin
                ?.role,
          }
          : null);

      if (!accessToken || !admin) {
        errorToast(
          "Invalid login response from server"
        );

        return;
      }

      setAdminAccessToken(
        accessToken
      );

      setAdmin(admin);
      if (!admin.role) {
        errorToast("Invalid login response from server");
        return;
      }
      setRole(admin.role);

      // setRole(admin.role || "SUPER_ADMIN");

      successToast(
        "Login successful!"
      );

      router.replace(
        "/admin/dashboard"
      );
    },

    onError: (
      error
    ) => {
      errorToast(
        error.message ||
        "Login failed"
      );
    },
  });
};

export const useAdminRegister = () => {
  const router = useRouter();

  return useMutation<AuthResponse, Error, AdminRegisterFormValues>({
    mutationFn: async (payload) => {
      const res = await adminApi.post("/admin/create", payload);

      return res.data
    },

    onSuccess: () => {
      successToast("Admin registered successfully");
      router.push("/admin/dashboard");
    },

    onError: (error) => {
      errorToast(error.message || "Registration failed");
    },
  });
};

export const useGetAllAdmins = () => {
  return useQuery<GetAllAdminsResponse["data"]>({
    queryKey: ["admins"],

    queryFn: async () => {
      const res = await adminApi.get("/admin");
      const json = await res.data;

      if (!res) {
        throw new Error("Failed to fetch admins");
      }

      return json.data;
    },

    // make data always fresh
    staleTime: 0,

    // auto refresh when user comes back to tab
    refetchOnWindowFocus: true,

    // retry on reconnect
    refetchOnReconnect: true,

    // optional: background refresh every 15 sec (dashboard)
    // refetchInterval: 15000,
    refetchIntervalInBackground: true,
  });
};

interface GetAdminByIdResponse {
  admin: any;
}

export const useGetAdminById = (id?: string, enabled = true) => {
  return useQuery<GetAdminByIdResponse>({
    queryKey: ["admin", id],

    queryFn: async () => {
      const res = await adminApi.get(`/admin/${id}`);
      const json = res;

      if (!res) {
        throw new Error(res || "Failed to fetch admin");
      }

      return json.data;
    },

    enabled: !!id && enabled,
    staleTime: 1000 * 60 * 5,
  });
};

export const useUpdateAdmin = () => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (payload: UpdateAdminPayload) => {
      const { id, ...rest } = payload;

      const body = {
        ...rest,
        // convert Date → ISO string for backend
        expiresAt: rest.expiresAt
          ? rest.expiresAt.toISOString()
          : undefined,
      };

      const res = await adminApi.put(`/admin/update/${id}`, {
        method: "PUT",
        body: JSON.stringify(body),
      });

      const json = await res;

      if (!res) {
        throw new Error(res || "Failed to update admin");
      }

      return json;
    },

    onSuccess: () => {
      successToast("Admin updated successfully");

      // refresh admin list
      queryClient.invalidateQueries({ queryKey: ["admins"] });
    },

    onError: (error: any) => {
      errorToast(error.message || "Update failed");
    },
  });
};

export const useDeleteAdmin = () => {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: async (adminId: string) => {
      const res = await adminApi.delete(`/admin/delete/${adminId}`, {
        method: "DELETE",
      });

      if (!res) {
        throw new Error(res || "Failed to delete admin");
      }

      return res;
    },

    onSuccess: (resp) => {
      successToast("Admin deleted successfully");

      // refresh admin list instantly
      queryClient.invalidateQueries({ queryKey: ["admins"] });
    },

    onError: (error: any) => {
      errorToast(error.message || "Delete failed");
    },
  });
};

export const useAdminLogout = () => {
  const router = useRouter();

  return useMutation({
    mutationFn: async () => {
      const res = await adminApi.post("/admin/logout");

      return res.data
    },

    onSuccess: () => {
      clearAdminAuth();
      successToast("Logged out");
      router.push("/admin/login");
    },

    onError: () => {
      clearAdminAuth(); // still clear locally
      router.push("/admin/login");
    },
  });
};

export const useRefreshToken = () => {
  const setAccessToken = useAuth((s) => s.setAccessToken);

  return async () => {
    try {
      const res = await adminApi.post("/admin/refresh");

      const data = await res.data

      const accessToken = data?.data?.accessToken;

      if (accessToken) {
        setAccessToken(accessToken);
        return accessToken;
      }
    } catch (err) {
      console.error("Refresh failed");
    }

    return null;
  };
};

// Payment hooks
export const useCreatePayment = (
  onSuccessCallback?: () => void
) => {
  return useMutation<
    ReactQueryResponse,
    unknown,
    PaymentPayload
  >({
    mutationFn: async (payload) => {
      const { data } =
        await api.post<ReactQueryResponse>(
          "/payment/create",
          payload
        );

      return data;
    },

    onSuccess: (res) => {
      if (!res.success) {
        errorToast(res.message);
        return;
      }

      successToast(res.message);

      onSuccessCallback?.();
    },

    onError: (error: any) => {
      const msg =
        error?.response?.data?.message ||
        error?.message ||
        "Something went wrong";

      errorToast(msg);
    },
  });
};