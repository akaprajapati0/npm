"use client";

import { ReusableDataTable } from "@/components/admin-components/table/data-table";
import { Button } from "@/components/ui/button";
import { TableHead, TableCell } from "@/components/ui/table";
import Link from "next/link";
import { UserRow } from "@/types/adminHooksTypes";
import { useInfiniteUsers } from '@/hooks/useCaretakerMutation';
import { useReactivateAccount } from '@/hooks/useAuthMutations';
import { errorToast, successToast } from '@/utils/toast';

// ─── Page ───
export default function Users() {
    const {
        data,
        fetchNextPage,
        hasNextPage,
        isFetchingNextPage,
        isPending,
    } = useInfiniteUsers(10);

    const { mutate, isPending: isReactivate } = useReactivateAccount();


    const users = data?.pages.flatMap((page) => page.users) || [];

    const handleReactivate = (userId: string) => {
        mutate(userId, {
            onSuccess: () => { successToast("Account reactivated successfully") },

            onError: (
                error: any
            ) => {
                errorToast(error?.response
                    ?.data
                    ?.message ||
                    "Failed to reactivate account")
            },
        });
    }

    return (
        <ReusableDataTable<UserRow>
            heading="Users"
            subHeading="All registered users"
            data={users}
            loading={isPending}
            searchKeys={["email", "phone"]}

            // Infinite scroll props
            hasNextPage={hasNextPage}
            isFetchingNextPage={isFetchingNextPage}
            onLoadMore={fetchNextPage}

            head={
                <>
                    <TableHead>Phone</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Provider</TableHead>
                    <TableHead>Progress</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Action</TableHead>
                    <TableHead>View</TableHead>
                </>
            }
        >
            {(row) => (
                <>
                    <TableCell>{row.phone}</TableCell>
                    <TableCell>{row.email}</TableCell>
                    <TableCell>{row.authProvider}</TableCell>
                    <TableCell>{row.progress}</TableCell>
                    <TableCell className={`font-semibold ${row.isDeactivated ? 'text-red-500' : 'text-green-500'}`}>{row.isDeactivated ? 'Deactivate' : 'Activate'}</TableCell>
                    <TableCell>
                        {
                            row.isDeactivated ? <Button onClick={() => handleReactivate(row._id)}>Reactivate</Button> : ""
                        }
                    </TableCell>
                    <TableCell>
                        <Button variant="outline" size="sm" asChild>
                            <Link href={`/admin/dashboard/caretaker/${row._id}`}>
                                View
                            </Link>
                        </Button>
                    </TableCell>
                </>
            )}
        </ReusableDataTable>
    );
}

// "use client";

// import {
//     AlertDialog,
//     AlertDialogAction,
//     AlertDialogCancel,
//     AlertDialogContent,
//     AlertDialogDescription,
//     AlertDialogFooter,
//     AlertDialogHeader,
//     AlertDialogTitle,
//     AlertDialogTrigger,
// } from "@/components/ui/alert-dialog";

// import { Button } from "@/components/ui/button";

// import { Loader2 } from "lucide-react";

// import { toast } from "sonner";

// import {
//     useReactivateAccount,
// } from "@/hooks/useAuthMutations";

// type Props = {
//     userId: string;
// };

// export default function ReactivateButton({
//     userId,
// }: Props) {
//     const {
//         mutate,
//         isPending,
//     } = useReactivateAccount();

//     const handleReactivate =
//         () => {
//             mutate(userId, {
//                 onSuccess: () => {
//                     toast.success(
//                         "Account reactivated successfully"
//                     );
//                 },

//                 onError: (
//                     error: any
//                 ) => {
//                     toast.error(
//                         error?.response
//                             ?.data
//                             ?.message ||
//                             "Failed to reactivate account"
//                     );
//                 },
//             });
//         };

//     return (
//         <AlertDialog>
//             <AlertDialogTrigger
//                 asChild
//             >
//                 <Button size="sm">
//                     Reactivate
//                 </Button>
//             </AlertDialogTrigger>

//             <AlertDialogContent>
//                 <AlertDialogHeader>
//                     <AlertDialogTitle>
//                         Reactivate
//                         account?
//                     </AlertDialogTitle>

//                     <AlertDialogDescription>
//                         This user will
//                         regain access
//                         to their account
//                         immediately.
//                     </AlertDialogDescription>
//                 </AlertDialogHeader>

//                 <AlertDialogFooter>
//                     <AlertDialogCancel>
//                         Cancel
//                     </AlertDialogCancel>

//                     <AlertDialogAction
//                         onClick={
//                             handleReactivate
//                         }
//                         disabled={
//                             isPending
//                         }
//                     >
//                         {isPending ? (
//                             <span className="flex items-center gap-2">
//                                 <Loader2 className="h-4 w-4 animate-spin" />
//                                 Processing...
//                             </span>
//                         ) : (
//                             "Reactivate"
//                         )}
//                     </AlertDialogAction>
//                 </AlertDialogFooter>
//             </AlertDialogContent>
//         </AlertDialog>
//     );
// }