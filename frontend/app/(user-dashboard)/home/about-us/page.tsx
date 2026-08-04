import GoBackBtn from '@/components/GoBackBtn'
import ReusablePage from '@/components/ReusablePage'
import { aboutSection } from '@/utils/pagesContent'

export default function Page() {
    return (
        <div className="w-full">
            <GoBackBtn href='/home' ariaLabel='go back home' />
            <ReusablePage heroImage='/aboutUsImage-1.svg' heroTitle="Connecting Patients to Life-Saving Treatments, Everywhere Delivering Hope Through Access to Life Saving Medicines"
                sections={aboutSection}
                bottomImage={"/aboutUsImage-2.svg"}
            />
        </div >
    )
}