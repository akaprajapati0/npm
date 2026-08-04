import { ReusableCardProps } from '@/types/componentTypes';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';


export const ReusableCard = ({ title, description, children }: ReusableCardProps) => {
    return (
        <div className="flex items-center justify-center flex-col md:py-2 space-y-4">
            <Card className="w-full max-w-md mx-auto border-none shadow-none">

                <CardHeader>
                    <CardTitle className="text-center text-2xl font-bold">
                        {title}
                    </CardTitle>
                    <CardDescription className="text-center max-w-xs mx-auto mb-4 text-black text-sm">
                        {description}
                    </CardDescription>
                </CardHeader>

                <CardContent>

                    {children}

                </CardContent>
            </Card>
        </div >
    );
}