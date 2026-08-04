import GoBackBtn from '@/components/GoBackBtn';
import Link from 'next/link';

export default function ResetPassword() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href='/home' ariaLabel='back to home' />
            <div className="px-4 space-y-6">
                <h1 className="text-base sm:text-xl font-semibold">I forgot my password. How do I reset it?</h1>
                <p className="text-xs sm:text-sm leading-6">
                    Forgot your password? You can securely reset it anytime using the link below. Just verify your identity, follow the steps, and create a new strong password to regain access to your account quickly and safely without any interruption in your service or workflow.
                    <Link href="/home/reset-password/reset" className='text-primary'> Reset Password</Link>
                </p>
            </div>
        </div>
    )
}