import { InfoPageProps, SectionItem } from '@/types/componentTypes'

const InfoSection = ({ title, description, points, otherText }: SectionItem) => {
    return (
        <div className="space-y-2 px-4">
            <h2 className="text-lg font-black">{title}</h2>

            {description && (
                <p className="text-gray-700 leading-relaxed">{description}</p>
            )}

            {points && (
                <ul className="list-disc list-inside space-y-1 text-gray-700">
                    {points.map((point, index) => (
                        <li key={index}>{point}</li>
                    ))}
                </ul>
            )}
            {
                otherText && (
                    <p className="text-gray-700 leading-relaxed">{otherText}</p>
                )
            }
        </div>
    )
}

export const InfoPage = ({ sections, title, description }: InfoPageProps) => {
    const stats = [
        { value: '10+', label: 'Years of Experience' },
        { value: '150000+', label: 'Patients Served' },
        { value: '1.5 Million+', label: 'Product Line' },
        { value: '24/7', label: 'Temperature Monitoring' }
    ]

    return (
        <div className="max-w-7xl">

            <div className="space-y-4 mb-5 text-center">
                <h1 className="text-3xl font-bold">{title}</h1>
                <p className="max-w-4xl mx-auto text-gray-700">{description}</p>
            </div>

            <div className="space-y-6">
                {sections.map((section, index) => (
                    <InfoSection key={index} {...section} />
                ))}
            </div>

            <div className="sm:flex items-stretch justify-center mt-10">

                <div className="w-full max-w-lg md:max-w-sm bg-[#C2D6FF] p-6 flex justify-center items-center">
                    <h1 className="text-center font-medium md:w-xs">
                        Transforming Patient’s Lives Through Networking
                    </h1>
                </div>

                <div className="w-full bg-[#0040C6] text-white p-6 space-y-6">
                    <h2 className="text-center font-medium">
                        Leading Company in the field of Named Patient Import
                    </h2>

                    <div className="grid grid-cols-2 gap-6">
                        {stats.map((item, index) => (
                            <div
                                key={index}
                                className="flex flex-col items-center justify-center text-center"
                            >
                                <p className="text-xl font-bold">{item.value}</p>
                                <p className="text-sm">{item.label}</p>
                            </div>
                        ))}
                    </div>
                </div>

            </div>

            <div className="bg-black w-full h-20 flex items-center justify-center text-white text-sm">
                Copyright © {new Date().getFullYear()}
            </div>

        </div>
    )
}