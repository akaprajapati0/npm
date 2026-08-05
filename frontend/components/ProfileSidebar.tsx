"use client";

import {
    LogOut,
    LucideArrowLeft,
    LucideChevronDown,
    LucideChevronRight,
    User,
} from "lucide-react";
import { Button } from "@/components/ui/button";
import { useGetProfile, useLogout } from "@/hooks/useAuthMutations";
import { useEffect, useCallback, useState } from "react";
import Link from "next/link";
import { getImageUrl } from '@/lib/getImage';
import { sidebarItems } from '@/utils/pagesContent';
import { Avatar, AvatarFallback, AvatarImage } from './ui/avatar';

interface ProfileSidebarProps {
    open: boolean;
    onClose: () => void;
}

export default function ProfileSidebar({
    open,
    onClose,
}: ProfileSidebarProps) {
    const logoutMutation = useLogout();
    const { data, isPending } = useGetProfile();
    const [openDropdown, setOpenDropdown] = useState<string | null>(null);

    // console.log(data)
    const handleLogout = useCallback(() => {
        logoutMutation.mutate();
        onClose();
    }, [logoutMutation, onClose]);

    // Close only on ESC
    useEffect(() => {
        if (!open) return;

        const handleEsc = (e: KeyboardEvent) => {
            if (e.key === "Escape") onClose();
        };

        window.addEventListener("keydown", handleEsc);
        return () => window.removeEventListener("keydown", handleEsc);
    }, [open, onClose]);

    if (isPending) {
        return
        // (
        //     <div className="flex items-center justify-center min-h-screen">
        //         Loading profile...
        //     </div>
        // );
    };

    const profileImg = data?.user?.image?.url;

    return (
        <>
            {/* Overlay (visual only, no click close) */}
            <div className={`fixed inset-0 z-40 bg-black/50 transition-opacity ${open ? "opacity-100" : "opacity-0 pointer-events-none"} md:hidden`}
            />

            {/* Sidebar */}
            <aside className={`fixed top-0 left-0 z-50 h-full w-72 bg-white shadow-xl transition-transform duration-300 ${open ? "translate-x-0" : "-translate-x-full"}    md:translate-x-0`}
            >
                {/* Header */}
                <div className="border-b p-4 space-y-4">
                    <LucideArrowLeft
                        className="cursor-pointer md:hidden"
                        onClick={(e) => {
                            e.stopPropagation();
                            onClose();
                        }}
                    />

                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="font-black">Hey there!</h1>
                            <span className="text-sm text-gray-600">
                                {data?.user?.name || "User"}
                            </span>
                        </div>

                        <div className="relative overflow-hidden">
                            <Avatar
                                id="profile-guide"
                                className="h-8 w-8 border overflow-hidden cursor-pointer relative"
                            >
                                <AvatarImage
                                    src={getImageUrl(profileImg)}
                                    alt="Profile"
                                    className='object-cover'
                                />

                                <AvatarFallback>
                                    <User />
                                </AvatarFallback>
                            </Avatar>
                        </div>
                    </div>
                </div>

                {/* Menu */}
                <nav className="p-4 space-y-4 text-sm">
                    {sidebarItems.map((item) => (
                        <div key={item.label}>
                            {item.children ? (
                                <>
                                    {/* Dropdown trigger */}
                                    <button
                                        type="button"
                                        onClick={() =>
                                            setOpenDropdown(
                                                openDropdown === item.label ? null : item.label
                                            )
                                        }
                                        className="w-full flex items-center justify-between hover:text-primary transition cursor-pointer"
                                    >
                                        <span>{item.label}</span>
                                        {openDropdown === item.label ? (
                                            <LucideChevronDown className="h-4 w-4" />
                                        ) : (
                                            <LucideChevronRight className="h-4 w-4" />
                                        )}
                                    </button>

                                    {/* Dropdown links */}
                                    {openDropdown === item.label && (
                                        <div className="mt-2 ml-4 space-y-3 border-l pl-3">
                                            {item.children.map((child) => (
                                                <Link
                                                    key={child.label}
                                                    href={child.href}
                                                    className="flex items-center justify-between hover:text-primary transition "
                                                >
                                                    <span>{child.label}</span>
                                                    <LucideChevronRight className="h-4 w-4" />
                                                </Link>
                                            ))}
                                        </div>
                                    )}
                                </>
                            ) : (
                                <Link
                                    href={item.href!}
                                    className="flex items-center justify-between hover:text-primary transition"
                                >
                                    <span>{item.label}</span>
                                    <LucideChevronRight className="h-4 w-4" />
                                </Link>
                            )}
                        </div>
                    ))}
                </nav>

                {/* Footer */}
                <div className="absolute bottom-0 w-full border-t p-4 space-y-4">
                    <Button
                        variant="destructive"
                        className="w-full py-6 gap-2 text-xl font-medium"
                        onClick={handleLogout}
                    >
                        <LogOut className="h-4 w-4" />
                        Sign out
                    </Button>
                    {/* <DeactivateAccount /> */}

                    <div className="text-sm">
                        <p className='font-semibold leading-tight tracking-wider bg-linear-to-b from-[#0040C6] to-[#00FF99] bg-clip-text text-transparent mb-1 text-base'>India&apos;s Leading Partner in Named Patient Medicine Access</p>

                        <p className="text-xs text-gray-500">Made with NPM</p>
                    </div>
                </div>
            </aside>
        </>
    );
}
// 
