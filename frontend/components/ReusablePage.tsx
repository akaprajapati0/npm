import { ContentSectionProps, ReusablePageProps } from '@/types/componentTypes';
import Image from "next/image";


// ------- Content Section (Reusable) --------
function ContentSection({
    number = "01",
    title,
    description,
    bg = "gray",
}: ContentSectionProps) {
    const bgColor = bg === "white" ? "bg-white" : "bg-gray-50";

    return (
        <section className={`${bgColor} py-10 px-4`}>
            <div className="max-w-6xl mx-auto space-y-4">
                <div className="h-20 w-20 rounded-full border bg-primary mx-auto font-bold text-2xl text-center text-white flex justify-center items-center">
                    {number}
                </div>

                <h2 className="text-2xl md:text-3xl font-bold text-center">{title}</h2>

                {Array.isArray(description) ? (
                    description.map((para, index) => (
                        <p
                            key={index}
                            className="text-gray-700 text-center max-w-3xl mx-auto leading-relaxed"
                        >
                            {para}
                        </p>
                    ))
                ) : (
                    <p className="text-gray-700 text-center max-w-3xl mx-auto leading-relaxed">
                        {description}
                    </p>
                )}
            </div>
        </section>
    );
}

// ------- Main Reusable Page Layout ---------
export default function ReusablePage({
    sections,
    heroTitle,
    heroImage,
    overlay,
    bottomImage,
    heading
}: ReusablePageProps) {
    return (
        <div className="w-full">
            <section className="relative w-full h-[420px] flex items-center justify-center">
                <Image
                    src={heroImage || "/aboutImage2.svg"}
                    alt="back image"
                    fill
                    className="object-cover"
                    priority
                />

                {overlay && <div className="absolute inset-0 bg-black/40" />}

                <div className="relative text-center text-white px-4 max-w-3xl">
                    <h1 className="text-3xl md:text-5xl font-bold">{heroTitle}</h1>
                </div>
            </section>
            <h1 className="text-center font-bold text-2xl mt-5">{heading}</h1>
            {sections.map((section, index) => (
                <ContentSection key={index} {...section} />
            ))}

            {bottomImage && (
                <div className="w-full relative overflow-hidden aspect-video">
                    <Image
                        src={bottomImage}
                        alt="popup-image"
                        fill
                        priority
                        className="object-cover"
                    />
                </div>
            )}

            <footer className="text-white text-sm">
                <div className="bg-[#0040C6] py-8 px-4">
                    <div className="max-w-6xl mx-auto text-center space-y-3">
                        <h1 className="text-lg font-semibold">Contact Us</h1>

                        <h2 className="font-medium">Ikris Pharma Network</h2>

                        <p className="max-w-2xl mx-auto">
                            <span className="font-medium">Address:</span> 905, ITHUM Tower, Business Park 40, Block A,
                            Sector 62, Noida, Uttar Pradesh – 201301, India
                        </p>

                        <p>
                            <span className="font-medium">Email:</span> info@ikrispharmanetwork.com
                        </p>

                        <p>
                            <span className="font-medium">Phone:</span> +91-9810469557
                        </p>
                    </div>
                </div>

                <div className="bg-black w-full h-20 flex items-center justify-center text-white text-sm">
                    Copyright © {new Date().getFullYear()}
                </div>
            </footer>
        </div>
    );
}