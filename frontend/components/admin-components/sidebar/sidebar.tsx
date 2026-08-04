"use client";

import { usePathname } from "next/navigation";
import { Separator } from "@/components/ui/separator";
import {
  LayoutDashboard,
  User,
  Star,
} from "lucide-react";

import { SidebarItem } from "./sidebar-item";
import { useSidebar } from "./sidebar-context";

export const SidebarWrapper = () => {
  const pathname = usePathname();
  const { collapsed } = useSidebar();

  return (
    <>
      {/* Overlay (mobile) */}
      {collapsed && (
        <div className="fixed inset-0 z-40 bg-black/50 lg:hidden" />
      )}

      <aside className="fixed left-0 top-0 z-50 h-screen w-64 border-r bg-background">
        <div className="flex h-full flex-col">

          {/* Header */}
          <div className="p-4 font-semibold text-lg">
            NPP AdminPanel
          </div>

          <Separator />

          {/* Body */}
          <div className="flex-1 space-y-6 overflow-y-auto p-3">

            <SidebarItem
              title="Overview"
              icon={<LayoutDashboard size={18} />}
              href="/admin/dashboard"
              active={pathname === "/admin/dashboard"}
            />
            <SidebarItem
              title="Users"
              icon={<User size={18} />}
              href="/admin/dashboard/users"
              active={pathname === "/admin/dashboard/users"}
            />

            <SidebarItem
              title="Admins"
              icon={<Star size={18} />}
              href="/admin/dashboard/admins"
              active={pathname === "/admin/dashboard/admins"}
            />
          </div>
          {/* Footer */}
          <div className="flex items-center justify-start gap-4 border-t border-border/50 bg-card/30 p-4 hover:bg-muted/20 transition-colors duration-200">
            <div className="w-10 h-10 rounded-full bg-linear-to-br from-primary/80 to-primary flex items-center justify-center shadow-sm">
              <span className="text-primary-foreground font-semibold text-sm">SA</span>
            </div>
            <div className="flex flex-col">
              <h2 className="font-semibold text-foreground leading-tight">Super Admin</h2>
              <span className="text-xs text-muted-foreground flex items-center gap-1">
                <span className="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Full Access
              </span>
            </div>


            {/* <Tooltip>
              <TooltipTrigger>
                <Settings size={18} />
              </TooltipTrigger>
              <TooltipContent>Settings</TooltipContent>
            </Tooltip>

            <Tooltip>
              <TooltipTrigger>
                <Filter size={18} />
              </TooltipTrigger>
              <TooltipContent>Adjustments</TooltipContent>
            </Tooltip>

            <Tooltip>
              <TooltipTrigger>
                <Avatar>
                  <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" />
                </Avatar>
              </TooltipTrigger>
              <TooltipContent>Profile</TooltipContent>
            </Tooltip> */}
          </div>
        </div>
      </aside >
    </>
  );
};
