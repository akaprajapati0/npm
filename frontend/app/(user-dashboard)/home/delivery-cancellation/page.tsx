import GoBackBtn from '@/components/GoBackBtn';
import { ReusableCard } from '@/components/ReusableCard';
import Link from 'next/link';

export default function Page() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home" ariaLabel="back to home" />
            <div className="flex items-center justify-center min-h-[calc(100vh-100px)]">
                <ReusableCard title="Custom Duty Certificate" description="">
                    <div className="space-y-5">
                        <h3 className="font-semibold text-base">
                            What is Custom Duty Exemption Certificate (CDEC):
                        </h3>

                        <ul className="list-disc pl-5 space-y-2 text-sm text-gray-800">
                            <li>
                                The Custom Duty Exemption Certificate (CDEC) is a mandatory regulatory
                                document required for the import of life-saving medicines. This
                                certificate enables exemption from customs duty.
                            </li>
                            <li>
                                The CDEC must be completed and signed by both the patient and the
                                prescribing doctor. On the first page, the patient’s details and
                                signature are required. The second page must include the prescribing
                                doctor’s details along with their signature and official stamp.
                            </li>
                        </ul>

                        <p className="text-sm text-gray-800">
                            <span className="font-semibold">Please note </span>
                            Approval of the CDEC is essential to proceed with the import process.
                            Without this document, customs clearance of the medicine cannot be
                            completed.
                        </p>

                        <Link href="#" className="text-primary">
                            View Product List
                        </Link>
                    </div>

                </ReusableCard>
            </div>
        </div >
    )
}