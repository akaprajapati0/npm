import GoBackBtn from '@/components/GoBackBtn';
import { Card } from '@/components/ui/card';
import { helpPagelinks } from '@/utils/pagesContent';
import { ChevronRight } from 'lucide-react';
import Link from 'next/link';


export default function Page() {
    return (
        <div className="min-h-screen bg-white md:bg-gray-100">
            <GoBackBtn href="/home" ariaLabel="go back home" />

            <div className="flex flex-col min-h-[calc(100vh-80px)] md:items-center md:justify-center">
                <Card className="w-full max-w-md mx-auto border-none shadow-none flex flex-col justify-between grow p-4">
                    {/* Top Section */}
                    <ul className="space-y-6">
                        {helpPagelinks.map((item) => (
                            <li key={item.title}>
                                <Link
                                    href={item.href}
                                    className="flex items-center justify-between w-full font-medium text-slate-700 hover:text-primary transition-colors"
                                >
                                    {item.title}
                                    <ChevronRight className="text-slate-400" size={20} />
                                </Link>
                            </li>
                        ))}
                    </ul>

                    {/* Bottom Section */}
                    <div className="text-sm max-w-xs">
                        <p className='font-semibold leading-tight tracking-wider bg-linear-to-b from-[#0040C6] to-[#00FF99] bg-clip-text text-transparent mb-1 text-base'>India's Leading Partner in Named Patient Medicine Access</p>

                        <p className="text-xs text-gray-500">Made with NPM</p>
                    </div>
                </Card>
            </div>
        </div>
    )
}