"use client";
import AuthProgressSync from '@/components/AuthProgressSync';
import SocialLoginButtons from '@/components/SocialLoginButtons';
import Link from 'next/link';

export default function CaretakerPage() {
    return (
        <div className="min-h-screen px-4 bg-white md:bg-gray-100 flex items-center justify-center">
            <AuthProgressSync />

            <div className="w-full max-w-md space-y-8 text-center py-4">
                <div className="block">
                    <h1 className="text-primary font-extrabold text-6xl">NPP</h1>
                    <p className="text-xs">Named Patient Program</p>
                    <h1 className="text-2xl md:text-3xl font-bold mt-3 leading-tight tracking-wider bg-linear-to-b from-[#0040C6] to-[#00FF99] bg-clip-text text-transparent">
                        Transforming Patient Lives <br />
                        <span className="">Through Networking</span>
                    </h1>
                </div>

                <div className="mt-16 flex flex-col gap-6">
                    <Link
                        href="/sign-up"
                        className="w-full rounded-lg bg-primary p-2 py-3 text-xl font-medium text-white transition hover:bg-primary/90"
                    >
                        Create New Account
                    </Link>

                    <Link
                        href="/login"
                        className="w-full rounded-lg border border-primary p-2 py-3 text-xl font-medium text-primary transition hover:bg-primary/10"
                    >
                        Log in
                    </Link>

                    {/* Divider */}
                    <div className="my-5 flex items-center gap-3">
                        <span className="w-full border border-black/30" />
                        <p className="whitespace-nowrap text-sm font-light">
                            Or continue with quick sign-in
                        </p>
                        <span className="w-full border border-black/30" />
                    </div>

                    {/* Google Login */}
                    <SocialLoginButtons />
                </div>

                <p className="px-2 text-xs sm:text-sm">
                    By continuing, you agree to our{" "}
                    <Link href="/privacy-policy" className="text-primary hover:underline">
                        Privacy Policy
                    </Link>{" "}
                    and{" "}
                    <Link href="/privacy-policy" className="text-primary hover:underline">
                        Terms & Conditions
                    </Link>
                    .
                </p>
            </div>
        </div>
    );
}