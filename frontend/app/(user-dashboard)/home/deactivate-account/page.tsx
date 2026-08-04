import GoBackBtn from '@/components/GoBackBtn';
import Link from 'next/link';

export default function DeactivateAccount() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href='/home' ariaLabel='back to home' />
            <div className="px-4 space-y-6">
                <h1 className="text-base sm:text-xl font-semibold">Deactivate my account</h1>
                <p className="text-xs sm:text-sm leading-6">
                    Deactivate your account anytime from settings if you decide to stop using the application. This option helps you pause or permanently close your account while keeping your data secure, and you can reactivate it later whenever you return to the platform easily and safely.
                    <Link href="/home/deactivate-account/deactivate" className='text-primary'> Deactivate Account</Link>
                </p>
            </div>
        </div>
    )
}