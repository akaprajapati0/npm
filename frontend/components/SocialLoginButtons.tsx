"use client";

import Image from "next/image";
import { Button } from './ui/button';

const API_URL = process.env.NEXT_PUBLIC_API_URL;

export const handleSocialLogin = (provider: "google") => {
    window.location.href = `${API_URL}/auth/${provider}`;
};

export default function SocialLoginButtons() {

    return (
        <Button
            type="button"
            variant="ghost"
            className="w-full border border-primary transition hover:bg-primary/10 py-6 gap-4"
            aria-label="Continue with Google"
            onClick={() => handleSocialLogin("google")}
        >
            <Image
                src="/google-icon.svg"
                width={20}
                height={20}
                alt="Google logo"
            />
            <span className="text-gray-500 text-lg">
                Continue with Google
            </span>
        </Button>
    );
}

{/* <Image src="/apple-icon.png" width={24} height={24} alt="apple" className="cursor-pointer" onClick={() => handleSocialLogin("apple")} /> */ }
{/* <Image src="/facebook-icon.png" width={24} height={24} alt="facebook" className="cursor-pointer" onClick={() => handleSocialLogin("facebook")} /> */ }