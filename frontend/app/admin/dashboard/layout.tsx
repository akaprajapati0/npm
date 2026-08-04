"use client";

import { ReactNode } from "react";
import { SidebarProvider } from "@/components/admin-components/sidebar/sidebar-context";
import { SidebarWrapper as Sidebar } from "@/components/admin-components/sidebar/sidebar";
import { Header } from '@/components/admin-components/navbar/header';

interface AdminUILayoutProps {
  children: ReactNode;
}

export default function AdminUILayout({ children }: AdminUILayoutProps) {
  return (
    <SidebarProvider>
      <div className="min-h-screen bg-background">
        <Sidebar />

        <div className="flex min-h-screen flex-col pl-[260px]">
          <Header />

          <main className="flex-1 overflow-y-auto p-6">
            {children}
          </main>
        </div>
      </div>
    </SidebarProvider>
  );
}
