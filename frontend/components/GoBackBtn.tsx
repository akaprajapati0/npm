"use client";
import { GoBackButtonProps } from '@/types/componentTypes';
import { MoveLeft } from 'lucide-react';
import { useRouter } from 'next/navigation';


export default function GoBackBtn({
    href = '/',
    ariaLabel = '',
    className = '',
    containerClassName = '',
}: GoBackButtonProps) {
    const router = useRouter();
    const handleBack = () => {
        if (typeof window !== "undefined" && window.history.length > 1) {
            router.back();
            return;
        }

        router.push(href);
    };

    return (
        <div className={`p-3 ${containerClassName}`}>
            <button type='button' className={`inline-flex p-2 md:p-2 border-2 border-gray-700 rounded-full items-center justify-center w-fit h-fit transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 cursor-pointer ${className}`} aria-label={ariaLabel} onClick={handleBack}>
                <MoveLeft size={16} />
            </button>

        </div>
    );
}
