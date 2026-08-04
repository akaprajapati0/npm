import GoBackBtn from '@/components/GoBackBtn';
import { InfoPage } from '@/components/ShowPageText';
import { helpSections } from '@/utils/pagesContent';

export default function Page() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home" ariaLabel="back to home" />
            <div className="min-h-[calc(100vh-100px)] w-full">
                <InfoPage
                    title="Need Help? (Quick Support Guide)"
                    description="Please read these Terms of Use carefully before accessing or using this platform. By accessing or using this website or mobile application, you agree to be legally bound by these terms. If you do not agree, please refrain from using the platform."
                    sections={helpSections}
                />
            </div>
        </div>
    )
}