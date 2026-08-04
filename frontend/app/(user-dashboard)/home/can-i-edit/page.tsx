import GoBackBtn from '@/components/GoBackBtn';
import Link from 'next/link';

export default function CanIEdit() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href='/home' ariaLabel='back to home' />
            <div className="px-4 space-y-6">
                <h1 className="text-base sm:text-xl font-semibold">Can I edit my profile?</h1>
                <p className="text-xs sm:text-sm leading-6">
                    Edit your profile anytime to keep your information accurate, updated, and relevant. You can change personal details, contact information, and preferences easily, ensuring a smoother and more personalized experience across the application with improved functionality and better user engagement based on your latest updates.
                    <Link href="/home/edit-profile" className='text-primary'> Edit Profile</Link>
                </p>
            </div>
        </div>
    )
}