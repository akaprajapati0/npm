"use client"
import ProfileSidebar from '@/components/ProfileSidebar';

export default function HomeLayout({
    children,
}: Readonly<{
    children: React.ReactNode;
}>) {
    return (
        <div className="min-h-screen bg-gray-50">
            <div className="hidden md:block">
                <ProfileSidebar
                    open={true}
                    onClose={() => true}
                />
            </div>
            <div className="min-h-screen bg-gray-50 md:pl-72">
                {children}
            </div>
        </div>
    )
}