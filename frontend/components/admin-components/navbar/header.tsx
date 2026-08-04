"use client";

import { Bell, Moon, Sun, Search } from "lucide-react";
import { useTheme } from "next-themes";
import { Button } from "@/components/ui/button";

import { UserDropdown } from './user-dropdown';
import { CreateAdminDialog } from '../create-admin-dialog';
// import { CreateAdminDialog } from '../create-admin-dialog';

interface HeaderProps {
  title: string;
  description?: string;
  action?: React.ReactNode;
}

export function Header() {
  const { setTheme } = useTheme();

  return (
    <header className="sticky top-0 z-10 flex h-16 items-center justify-end gap-4 border-b bg-background/95 backdrop-blur px-6">
      {/* <div className="flex-1">
        <h1 className="text-base font-semibold text-foreground">{title}</h1>
        {description && (
          <p className="text-xs text-muted-foreground">{description}</p>
        )}
      </div> */}

      <div className="flex items-center gap-2">
        {/* Search */}
        {/* <div className="relative hidden md:block">
          <Search className="absolute left-2.5 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-muted-foreground" />
          <Input
            placeholder="Search..."
            className="h-8 w-48 pl-8 text-xs bg-muted/50 border-muted focus-visible:ring-1"
          />
        </div> */}

        {/* Theme toggle */}
        {/* <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <Button variant="ghost" size="icon" className="h-8 w-8">
              <Sun className="h-3.5 w-3.5 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
              <Moon className="absolute h-3.5 w-3.5 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
              <span className="sr-only">Toggle theme</span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuItem onClick={() => setTheme("light")}>Light</DropdownMenuItem>
            <DropdownMenuItem onClick={() => setTheme("dark")}>Dark</DropdownMenuItem>
            <DropdownMenuItem onClick={() => setTheme("system")}>System</DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu> */}

        {/* Notifications */}
        <Button variant="ghost" size="icon" className="h-8 w-8 relative">
          <Bell className="h-3.5 w-3.5" />
          <span className="absolute top-1.5 right-1.5 h-1.5 w-1.5 rounded-full bg-destructive" />
        </Button>

        <CreateAdminDialog />
        {/* {action} */}
        <UserDropdown />
      </div>
    </header>
  );
}

