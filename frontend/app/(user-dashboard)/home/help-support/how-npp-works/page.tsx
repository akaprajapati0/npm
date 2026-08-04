import GoBackBtn from '@/components/GoBackBtn';
import ReusablePage from '@/components/ReusablePage';
import { howOurNppWork } from '@/utils/pagesContent';

export default function Page() {
    return (
        <div className="w-full">
            <GoBackBtn href='/home/help-support' ariaLabel='go back home' />
            <ReusablePage heroImage='/aboutUsImage-1.svg' heroTitle="Driven by purpose, powered by innovation—together, we make access to life-saving medicines possible"
                sections={howOurNppWork}
                heading='How Our NPP Works?'
            />
        </div >
    )
}