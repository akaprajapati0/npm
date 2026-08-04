import GoBackBtn from '@/components/GoBackBtn';
import UpdatePasswordForm from '@/components/UpdatePasswordForm';

export default function Reset() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href='/home/reset-password' ariaLabel='back to reset password' />
            <UpdatePasswordForm redirectPath="/home" />
        </div>
    )
}