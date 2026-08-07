"use client";

import { ReusableDataTable } from "@/components/admin-components/table/data-table";
import { Button } from "@/components/ui/button";
import { TableHead, TableCell } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { InputGroup, InputGroupAddon, InputGroupInput } from "@/components/ui/input-group";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import Link from "next/link";
import { UserRow } from "@/types/adminHooksTypes";
import { UserFilters, useInfiniteUsers } from '@/hooks/useCaretakerMutation';
import { useReactivateAccount } from '@/hooks/useAuthMutations';
import { errorToast, successToast } from '@/utils/toast';
import { useDebounce } from '@/hooks/useDebounce';
import { CheckCircle2, Eye, RotateCcw, Search, UserCheck, UsersRound, UserX } from "lucide-react";
import { useMemo, useState } from "react";
import { isAxiosError } from "axios";

// ─── Page ───
const PROGRESS_OPTIONS = [
    ["none", "Not started"],
    ["caretaker_uploaded", "Recipient details"],
    ["prescribed_uploaded", "Medicine details"],
    ["doctor_uploaded", "Doctor details"],
    ["prescription_uploaded", "Prescription uploaded"],
    ["kyc_uploaded", "KYC uploaded"],
    ["request_quotation", "Quotation requested"],
    ["request_invoice", "Proforma requested"],
    ["request_license", "Import permit requested"],
    ["bank_receipt_uploaded", "Bank receipt uploaded"],
    ["cdec_uploaded", "CDEC uploaded"],
    ["address_added", "Address added"],
    ["address_skipped", "Address skipped"],
    ["completed", "Completed"],
] as const;

const progressLabels = Object.fromEntries(PROGRESS_OPTIONS) as Record<string, string>;

const formatDate = (value?: string) => {
    if (!value) return "-";

    return new Intl.DateTimeFormat("en-IN", {
        day: "2-digit",
        month: "short",
        year: "numeric",
    }).format(new Date(value));
};

export default function Users() {
    const [search, setSearch] = useState("");
    const [provider, setProvider] = useState<UserFilters["provider"]>("all");
    const [status, setStatus] = useState<UserFilters["status"]>("all");
    const [progress, setProgress] = useState("all");
    const [dateFrom, setDateFrom] = useState("");
    const [dateTo, setDateTo] = useState("");
    const [sort, setSort] = useState("createdAt-desc");
    const [pageSize, setPageSize] = useState(25);
    const debouncedSearch = useDebounce(search, 350);
    const [sortBy, sortOrder] = sort.split("-") as [UserFilters["sortBy"], UserFilters["sortOrder"]];

    const filters = useMemo<UserFilters>(() => ({
        search: debouncedSearch.trim() || undefined,
        provider,
        status,
        progress,
        dateFrom: dateFrom || undefined,
        dateTo: dateTo || undefined,
        sortBy,
        sortOrder,
    }), [debouncedSearch, provider, status, progress, dateFrom, dateTo, sortBy, sortOrder]);

    const {
        data,
        fetchNextPage,
        hasNextPage,
        isFetchingNextPage,
        isPending,
    } = useInfiniteUsers(pageSize, filters);

    const { mutate, isPending: isReactivate } = useReactivateAccount();


    const users = data?.pages.flatMap((page) => page.users) || [];
    const firstPage = data?.pages[0];
    const summary = firstPage?.summary;
    const filteredTotal = firstPage?.pagination.total ?? 0;
    const hasFilters = Boolean(
        search || provider !== "all" || status !== "all" || progress !== "all" || dateFrom || dateTo
    );

    const resetFilters = () => {
        setSearch("");
        setProvider("all");
        setStatus("all");
        setProgress("all");
        setDateFrom("");
        setDateTo("");
        setSort("createdAt-desc");
        setPageSize(25);
    };

    const handleReactivate = (userId: string) => {
        mutate(userId, {
            onSuccess: () => { successToast("Account reactivated successfully") },

            onError: (error: Error) => {
                const message = isAxiosError<{ message?: string }>(error)
                    ? error.response?.data?.message
                    : error.message;

                errorToast(message || "Failed to reactivate account");
            },
        });
    };

    const toolbar = (
        <div className="mb-4 space-y-4">
            <div className="grid overflow-hidden rounded-md border bg-muted/20 sm:grid-cols-2 xl:grid-cols-4 xl:divide-x">
                {[
                    { label: "Total users", value: summary?.total ?? 0, icon: UsersRound },
                    { label: "Active", value: summary?.active ?? 0, icon: UserCheck },
                    { label: "Deactivated", value: summary?.deactivated ?? 0, icon: UserX },
                    { label: "Completed", value: summary?.completed ?? 0, icon: CheckCircle2 },
                ].map(({ label, value, icon: Icon }) => (
                    <div key={label} className="flex min-h-16 items-center gap-3 border-b px-4 py-3 last:border-b-0 sm:[&:nth-last-child(-n+2)]:border-b-0 xl:border-b-0">
                        <Icon className="size-5 text-muted-foreground" />
                        <div>
                            <div className="text-xl font-semibold tabular-nums">{value}</div>
                            <div className="text-xs text-muted-foreground">{label}</div>
                        </div>
                    </div>
                ))}
            </div>

            <div className="flex flex-wrap items-center gap-2">
                <InputGroup className="min-w-60 flex-1 lg:max-w-sm">
                    <InputGroupAddon><Search /></InputGroupAddon>
                    <InputGroupInput
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                        placeholder="Search phone or email"
                        aria-label="Search users by phone or email"
                    />
                </InputGroup>

                <Select value={provider} onValueChange={(value) => setProvider(value as UserFilters["provider"])}>
                    <SelectTrigger className="w-36"><SelectValue placeholder="Provider" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="all">All providers</SelectItem>
                        <SelectItem value="local">Local</SelectItem>
                        <SelectItem value="google">Google</SelectItem>
                    </SelectContent>
                </Select>

                <Select value={status} onValueChange={(value) => setStatus(value as UserFilters["status"])}>
                    <SelectTrigger className="w-36"><SelectValue placeholder="Status" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="all">All statuses</SelectItem>
                        <SelectItem value="active">Active</SelectItem>
                        <SelectItem value="deactivated">Deactivated</SelectItem>
                    </SelectContent>
                </Select>

                <Select value={progress} onValueChange={setProgress}>
                    <SelectTrigger className="w-48"><SelectValue placeholder="Progress" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="all">All progress stages</SelectItem>
                        {PROGRESS_OPTIONS.map(([value, label]) => (
                            <SelectItem key={value} value={value}>{label}</SelectItem>
                        ))}
                    </SelectContent>
                </Select>

                <Select value={sort} onValueChange={setSort}>
                    <SelectTrigger className="w-40"><SelectValue placeholder="Sort" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="createdAt-desc">Newest first</SelectItem>
                        <SelectItem value="createdAt-asc">Oldest first</SelectItem>
                        <SelectItem value="email-asc">Email A-Z</SelectItem>
                        <SelectItem value="email-desc">Email Z-A</SelectItem>
                        <SelectItem value="phone-asc">Phone ascending</SelectItem>
                        <SelectItem value="progress-asc">Progress stage</SelectItem>
                    </SelectContent>
                </Select>

                <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    onClick={resetFilters}
                    disabled={!hasFilters && sort === "createdAt-desc" && pageSize === 25}
                >
                    <RotateCcw />
                    Clear
                </Button>
            </div>

            <div className="flex flex-wrap items-end gap-3 border-t pt-3">
                <label className="space-y-1 text-xs font-medium text-muted-foreground">
                    Registered from
                    <input
                        type="date"
                        value={dateFrom}
                        max={dateTo || undefined}
                        onChange={(event) => setDateFrom(event.target.value)}
                        className="block h-9 rounded-md border border-input bg-transparent px-3 text-sm text-foreground shadow-xs outline-none focus-visible:ring-2 focus-visible:ring-ring/50"
                    />
                </label>
                <label className="space-y-1 text-xs font-medium text-muted-foreground">
                    Registered to
                    <input
                        type="date"
                        value={dateTo}
                        min={dateFrom || undefined}
                        onChange={(event) => setDateTo(event.target.value)}
                        className="block h-9 rounded-md border border-input bg-transparent px-3 text-sm text-foreground shadow-xs outline-none focus-visible:ring-2 focus-visible:ring-ring/50"
                    />
                </label>
                <div className="ml-auto flex items-center gap-2 text-xs text-muted-foreground">
                    Rows per load
                    <Select value={String(pageSize)} onValueChange={(value) => setPageSize(Number(value))}>
                        <SelectTrigger size="sm" className="w-20"><SelectValue /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="10">10</SelectItem>
                            <SelectItem value="25">25</SelectItem>
                            <SelectItem value="50">50</SelectItem>
                            <SelectItem value="100">100</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>
        </div>
    );

    return (
        <ReusableDataTable<UserRow>
            heading="Users"
            subHeading="All registered users"
            data={users}
            loading={isPending}
            toolbar={toolbar}
            rowKey={(row) => row._id}
            resultSummary={
                <>Showing <span className="font-medium text-foreground">{users.length}</span> of <span className="font-medium text-foreground">{filteredTotal}</span> matching users</>
            }

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
                    <TableHead>Joined</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                </>
            }
        >
            {(row) => (
                <>
                    <TableCell>{row.phone || "-"}</TableCell>
                    <TableCell className="max-w-72 truncate">{row.email || "-"}</TableCell>
                    <TableCell className="capitalize">{row.authProvider || "local"}</TableCell>
                    <TableCell>
                        <Badge variant="outline" className="font-normal">
                            {progressLabels[row.progress] || row.progress}
                        </Badge>
                    </TableCell>
                    <TableCell>{formatDate(row.createdAt)}</TableCell>
                    <TableCell>
                        <Badge className={row.isDeactivated ? "border-red-200 bg-red-50 text-red-700" : "border-green-200 bg-green-50 text-green-700"} variant="outline">
                            {row.isDeactivated ? "Deactivated" : "Active"}
                        </Badge>
                    </TableCell>
                    <TableCell className="text-right">
                        <div className="flex justify-end gap-2">
                            {row.isDeactivated && (
                                <Button size="sm" onClick={() => handleReactivate(row._id)} disabled={isReactivate}>
                                    Reactivate
                                </Button>
                            )}
                            <Button variant="outline" size="icon-sm" asChild title="View user">
                                <Link href={`/admin/dashboard/caretaker/${row._id}`} aria-label="View user">
                                    <Eye />
                                </Link>
                            </Button>
                        </div>
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
