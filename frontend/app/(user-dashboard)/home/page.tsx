"use client";

import {
  Bell,
  Search,
  User,
} from "lucide-react";
import { Card, CardContent } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import Link from "next/link";
import { useGetProfile } from "@/hooks/useAuthMutations";
import { useEffect, useState } from "react";
import { driver, DriveStep, Side } from "driver.js";
import ProfileSidebar from "@/components/ProfileSidebar";
import NotificationPopup from "@/components/NotificationPopup";
import { getImageUrl } from '@/lib/getImage';
import { homeActions } from '@/utils/pagesContent';
import Image from 'next/image';
import HomeCarousel from '@/components/HomeCarousel';

const features = [
  { icon: "/med-bottel.svg", label: "100% genuine product" },
  { icon: "/material-icon.svg", label: "Safe & secure product" },
  { icon: "/delivery-truck.svg", label: "No contact delivery" },
  { icon: "/flat-color.svg", label: "Fully sanitized workflow" },
];

function PromoBanner({ className = "" }: { className?: string }) {
  return (
    <div className={`w-full ${className}`}>
      <Image
        src="/weight-loss.svg"
        alt="Weight loss promotion"
        width={100}
        height={100}
        className="w-full h-auto"
      />
    </div>
  );
}

export default function DashboardPage() {
  const { data, isPending } = useGetProfile();
  const [profileOpen, setProfileOpen] = useState(false);
  const [notificationOpen, setNotificationOpen] = useState(false);

  useEffect(() => {
    const hasSeenTour = localStorage.getItem("home-tour-done");
    if (hasSeenTour) return;

    const isMobile = window.innerWidth < 768;
    const actionSide: Side = isMobile ? "bottom" : "top";

    const steps: DriveStep[] = [
      {
        element: "#profile-guide",
        popover: {
          title: "Access Your Profile:",
          description:
            "Tap on the Profile icon to manage your account settings. From here, you can update your profile details, manage notifications, place quick orders, access help and support, or sign out of the application.",
          side: "right",
          align: "center",
          showButtons: ["next", "close"],
        },
      },
      {
        element: "#notification-guide",
        popover: {
          title: "Notification",
          description:
            "Tap on the Notifications button to manage your update preferences. From here, you can allow or disable notifications for important updates.",
          side: "left",
          align: "center",
          showButtons: ["next", "close"],
        },
      },
      ...homeActions.map<DriveStep>((action) => ({
        element: `#${action.id}`,
        popover: {
          title: action.label,
          description: action.desc,
          side: actionSide,
          align: "center",
          showButtons: ["next", "close"],
        },
      })),
    ];

    const tour = driver({
      showProgress: false,
      allowClose: true,
      disableActiveInteraction: true,
      overlayOpacity: 0.65,
      stagePadding: 12,
      stageRadius: 14,
      nextBtnText: "Next",
      doneBtnText: "Done",
      steps,
      onDestroyed: () => {
        localStorage.setItem("home-tour-done", "true");
      },
    });

    const timeoutId = setTimeout(() => tour.drive(), 300);
    return () => clearTimeout(timeoutId);
  }, []);

  const profileImg = data?.user?.image?.url;

  if (isPending) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        Loading profile...
      </div>
    );
  }

  return (
    <div className="min-h-screen">
      <div className="min-h-screen">
        {/* Top bar */}
        <div className="flex items-baseline justify-between p-6 bg-linear-to-b from-[#407CE2]/50 to-white/10">
          <div className="block space-y-4">
            <Avatar
              id="profile-guide"
              role="button"
              tabIndex={0}
              aria-label="Open profile menu"
              className="h-16 w-16 overflow-hidden cursor-pointer relative"
              onClick={() => setProfileOpen(true)}
              onKeyDown={(e) => {
                if (e.key === "Enter" || e.key === " ") setProfileOpen(true);
              }}
            >
              {profileImg ? (
                <AvatarImage
                  src={getImageUrl(profileImg)}
                  alt="Profile"
                  className="object-cover"
                />
              ) : null}
              <AvatarFallback>
                <User />
              </AvatarFallback>
            </Avatar>

            <div className="pl-2">
              <p className="text-xs">Welcome!</p>
              <h1 className="text-xl md:text-2xl font-semibold capitalize">
                {data?.user?.name || "User"}
              </h1>
            </div>
          </div>

          <button
            id="notification-guide"
            type="button"
            aria-label="Open notifications"
            className="relative"
            onClick={() => setNotificationOpen(true)}
          >
            <Bell className="h-8 w-8 cursor-pointer" />
            <span className="absolute -top-1 -right-1 h-2 w-2 rounded-full bg-red-500" />
          </button>
        </div>

        <div className="px-4 md:px-6 pb-4 space-y-8">
          {/* Search */}
          <div className="pt-8 flex justify-end">
            <div className="relative w-full md:max-w-lg">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
              <Input
                aria-label="Search doctor, drugs, articles"
                placeholder="Search doctor, drugs, articles..."
                className="pl-10 h-11 rounded-full"
              />
            </div>
          </div>

          {/* Actions */}
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {homeActions.map((action) => (
              <Link href={action.href} key={action.id}>
                <Card
                  id={action.id}
                  className="shadow-none border-none transition scroll-mt-24"
                >
                  <CardContent className="flex flex-col items-center justify-center py-3 gap-3">
                    <div className="h-14 w-14 rounded-full bg-primary/90 flex items-center justify-center">
                      <action.icon className="h-6 w-6 text-white" />
                    </div>
                    <p className="text-sm text-center">{action.label}</p>
                  </CardContent>
                </Card>
              </Link>
            ))}
          </div>

          {/* Quick Order */}
          <div className="w-full md:max-w-lg mx-auto flex items-center justify-between p-4 bg-white rounded-md">
            <h2 className="text-xs font-normal">
              Order quickly with Prescription
            </h2>
            <Link
              href="/caretaker/upload-document"
              className="px-3 py-1 bg-primary text-white rounded-md text-xs"
            >
              Order Now
            </Link>
          </div>

          <h2 className="text-xl font-semibold my-3">Payment Pending</h2>

          <PromoBanner />

          <div className="flex justify-between items-center mt-16">
            <h2 className="text-xl font-semibold">Ordered Medicine</h2>
            <Link href="/home" className="text-primary text-sm">
              See all
            </Link>
          </div>

          <HomeCarousel id="medicines">
            {[1, 2, 3, 4, 5].map((item) => (
              <div
                key={item}
                className="min-w-[200px] bg-white rounded-xl overflow-hidden shrink-0"
              >
                <div className="flex justify-center w-full h-[120px]">
                  <Image
                    src="/lysine.svg"
                    alt="Medicine product"
                    width={100}
                    height={100}
                  />
                </div>

                <div className="p-3 space-y-1">
                  <h3 className="text-sm font-medium">Medicine {item}</h3>
                  <span className="text-xs text-gray-500">20pcs</span>

                  <div className="flex items-center justify-between pt-1">
                    <p className="text-sm font-semibold">$15.99</p>
                    <button
                      type="button"
                      aria-label={`Add Medicine ${item} to cart`}
                      className="bg-primary/80 py-0.5 px-2 text-white rounded-sm text-lg leading-none"
                    >
                      +
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </HomeCarousel>

          <PromoBanner className="my-16" />

          {/* Offers & Updates */}
          <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-5">
            {features.map(({ icon, label }) => (
              <div
                key={label}
                className="bg-primary/10 p-3 sm:p-4 rounded-2xl relative aspect-square sm:aspect-auto sm:min-h-40 flex flex-col justify-end"
              >
                <Image
                  src={icon}
                  alt=""
                  width={50}
                  height={50}
                  className="absolute top-2 right-2 w-9 h-9 sm:w-12 sm:h-12"
                />
                <h3 className="text-base sm:text-xl font-normal leading-snug max-w-[75%] sm:max-w-24">
                  {label}
                </h3>
              </div>
            ))}
          </div>

          <p className="font-semibold leading-tight tracking-wider bg-linear-to-b from-primary to-[#00FF99] bg-clip-text text-transparent py-8 text-4xl">
            India&apos;s Leading Partner <br /> in Named Patient <br /> Medicine Access
          </p>
        </div>
      </div>

      <ProfileSidebar open={profileOpen} onClose={() => setProfileOpen(false)} />
      <NotificationPopup
        open={notificationOpen}
        onClose={() => setNotificationOpen(false)}
      />
    </div>
  );
}