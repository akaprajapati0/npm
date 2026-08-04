"use client";

import Link from "next/link";
import { cn } from "@/lib/utils";

type Props = {
  title: string;
  icon: React.ReactNode;
  href?: string;
  active?: boolean;
};

export const SidebarItem = ({ title, icon, href, active }: Props) => {
  const Comp = href ? Link : "div";

  return (
    <Comp
      href={href ?? ""}
      className={cn(
        "flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition",
        active
          ? "bg-muted text-primary"
          : "text-muted-foreground hover:bg-muted hover:text-primary"
      )}
    >
      {icon}
      <span>{title}</span>
    </Comp>
  );
};
