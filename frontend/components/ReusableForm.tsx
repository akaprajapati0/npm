import { ReusableFormProps } from '@/types/schema';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "./ui/card";
import { Form } from "./ui/form";


export const ReusableForm = ({
    heading,
    subHeading,
    form,
    onSubmit,
    onSkip,
    children
}: ReusableFormProps) => {
    return (
        <Card className="w-full max-w-md mx-auto border-none shadow-none">
            <CardHeader>
                <CardTitle className="text-center text-2xl font-medium relative">{heading}
                    {onSkip && (
                        <button
                            type="button"
                            onClick={onSkip}
                            className="absolute text-primary -top-5 -right-3 text-sm"
                        >
                            Skip
                        </button>
                    )}

                </CardTitle>
                {subHeading && <CardDescription className='text-center max-w-xs mx-auto mb-4'>{subHeading}</CardDescription>}
            </CardHeader>

            <CardContent>
                <Form {...form}>
                    <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4 md:space-y-6">
                        {children}
                    </form>
                </Form>
            </CardContent>
        </Card>
    );
};
