"use client";

import { StatCard } from "@/components/admin-components/stat-card";
import { Clock, ShieldCheck, UserCheck, Users } from "lucide-react";
import { useGetAllAdmins } from "@/hooks/useAdmin";

// ─── Page ───
export default function CaretakersPage() {
  const { data, isLoading } = useGetAllAdmins();


  const totalAdmins = data?.stats?.totalAdmins || 0;
  const activeAdmins = data?.stats?.activeAdmins || 0;
  const inActive = data?.stats?.inActiveAdmins || 0;
  const tempAdmins = data?.stats?.totalTempAdmins || 0;
  const expiringSoon = data?.stats?.expiringSoon || 0;
  const totalUsers = data?.stats?.totalUsers || 0;
  const lastWeekUsers = data?.stats?.lastWeekUsers || 0;

  // optional (if you track inactive later)
  // const inactive = admins.length - totalAdmins;

  if (isLoading) {
    return <p className="p-4">Loading dashboard...</p>;
  }

  return (
    <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
      <StatCard
        label="Total Admins"
        value={totalAdmins}
        sub="All roles combined"
        icon={ShieldCheck}
        iconColor="bg-violet-100 text-violet-600 dark:bg-violet-900/30 dark:text-violet-400"
        delay={0}
      />

      <StatCard
        label="Active Accounts"
        value={activeAdmins}
        sub={`${inActive} inactive`}
        icon={UserCheck}
        trend="neutral"
        iconColor="bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400"
        delay={50}
      />

      <StatCard
        label="Temp Admins"
        value={tempAdmins}
        sub={
          expiringSoon > 0
            ? `${expiringSoon} expiring soon`
            : "None expiring soon"
        }
        icon={Clock}
        trend={expiringSoon > 0 ? "down" : "neutral"}
        iconColor="bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400"
        delay={100}
      />

      <StatCard
        label="Total Users"
        value={totalUsers}
        sub={lastWeekUsers > 0 ? `${lastWeekUsers} new last week` : "No new users last week"}
        icon={Users}
        trend="up"
        iconColor="bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"
        delay={150}
      />
    </div>
  );
}


// in _app or layout
// useEffect(() => {
//   const tryRefresh = async () => {
//     try {
//       await apiFetch("/admin/auth/refresh", { method: "POST" });
//     } catch { }
//   };

//   tryRefresh();
// }, []);
// Flatten all pages
