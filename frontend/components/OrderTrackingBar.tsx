"use client";

type TrackingBarProps = {
    currentStatus: string;
};

const steps = [

    { key: "pending", label: "Pending" },
    { key: "order_created", label: "Order Created" },
    { key: "packed", label: "Packed" },
    { key: "shipped", label: "Shipped" },
    { key: "in_transit", label: "In Transit" },
    { key: "delivered", label: "Delivered" },
    { key: "cancelled", label: "Cancelled" },
];

export default function OrderTrackingBar({ currentStatus }: TrackingBarProps) {
    const currentIndex = steps.findIndex(step => step.key === currentStatus);

    return (
        <div className="w-full py-8 px-1">
            <div className="relative flex items-center justify-between">
                {steps.map((step, index) => {
                    const isCompleted = index < currentIndex;
                    const isCurrent = index === currentIndex;

                    return (
                        <div key={step.key} className="flex-1 flex flex-col items-center relative">

                            {/* Line */}
                            {index !== 0 && (
                                <div
                                    className={`absolute left-[-50%] top-4 w-full h-1 
                    ${isCompleted ? "bg-blue-600" : "bg-gray-300"}`}
                                />
                            )}

                            {/* Dot */}
                            <div
                                className={`z-10 w-8 h-8 rounded-full flex items-center justify-center 
                text-white font-semibold
                ${isCompleted
                                        ? "bg-blue-600"
                                        : isCurrent
                                            ? "bg-blue-500 animate-pulse"
                                            : "bg-gray-300"
                                    }`}
                            >
                                {isCompleted ? "✓" : ""}
                            </div>

                            {/* Label */}
                            <p
                                className={`mt-2 text-xs text-center
                ${isCompleted || isCurrent
                                        ? "text-blue-600"
                                        : "text-gray-400"
                                    }`}
                            >
                                {step.label}
                            </p>
                        </div>
                    );
                })}
            </div>
        </div>
    );
}