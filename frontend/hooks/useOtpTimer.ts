import { useEffect, useRef, useState } from "react";

export const useOtpTimer = (initialSeconds = 120) => {
    const [secondsLeft, setSecondsLeft] = useState(0);
    const intervalRef = useRef<NodeJS.Timeout | null>(null);

    const start = () => {
        setSecondsLeft(initialSeconds);
    };

    const reset = () => {
        setSecondsLeft(0);
        if (intervalRef.current) {
            clearInterval(intervalRef.current);
        }
    };

    useEffect(() => {
        if (secondsLeft <= 0) {
            reset();
            return;
        }

        intervalRef.current = setInterval(() => {
            setSecondsLeft((prev) => prev - 1);
        }, 1000);

        return () => {
            if (intervalRef.current) {
                clearInterval(intervalRef.current);
            }
        };
    }, [secondsLeft]);

    return {
        secondsLeft,
        canResend: secondsLeft === 0,
        start,
        reset,
    };
};
