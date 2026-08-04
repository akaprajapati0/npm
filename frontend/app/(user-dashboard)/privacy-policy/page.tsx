import GoBackBtn from '@/components/GoBackBtn';
import { InfoPage } from '@/components/ShowPageText';
import { policySections } from '@/utils/pagesContent';

export default function PrivacyPolicy() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/" ariaLabel="back to home" />

            <div className="min-h-[calc(100vh-100px)] w-full">
                <InfoPage
                    title="Terms and Policy"
                    description="Please read these policies carefully before using the platform. By using our services, you agree to the points mentioned below."
                    sections={policySections}
                />
            </div>
        </div>
    )
}