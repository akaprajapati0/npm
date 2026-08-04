"use client";

import { ReusableDataTable } from '@/components/admin-components/table/data-table';
import { UpdateAdminDialog } from '@/components/admin-components/updateAdmin';
import { Button } from '@/components/ui/button';
import { TableCell, TableHead } from '@/components/ui/table';
import { useDeleteAdmin, useGetAllAdmins } from '@/hooks/useAdmin';
import DateDisplay from '@/lib/readableDate';
import { AdminRow } from '@/types/adminSchema';
import { useState } from 'react';

export default function Admins() {
    const [open, setOpen] = useState(false);
    const { data, isPending } = useGetAllAdmins();
    const deleteAdmin = useDeleteAdmin();
    const [adminId, setAdminId] = useState<string>("");

    const handleDelete = (id: string) => {
        deleteAdmin.mutate(id);
    };

    const admins = data?.admins || [];


    return (
        <>
            <ReusableDataTable<AdminRow>
                heading="Users"
                subHeading="All registered users"
                data={admins}
                loading={isPending}
                head={
                    <>
                        <TableHead>Full Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Role</TableHead>
                        <TableHead>Expiry Date</TableHead>
                        <TableHead className='textcen'>Action</TableHead>
                    </>
                }
            >
                {(row) => (
                    <>
                        <TableCell>{row.fullname}</TableCell>
                        <TableCell>{row.email}</TableCell>
                        <TableCell>{row.role}</TableCell>
                        <TableCell>{DateDisplay({ isoString: row.expiresAt! })}</TableCell>
                        <TableCell className="flex gap-2 mx-auto">
                            <Button
                                variant="destructive"
                                onClick={() => handleDelete(row._id)}
                                disabled={deleteAdmin.isPending}
                            >
                                Delete
                            </Button>

                            <Button disabled={deleteAdmin.isPending} onClick={() => { setOpen(true); setAdminId(row._id) }}>
                                Update
                            </Button>
                        </TableCell>
                    </>
                )}
            </ReusableDataTable>
            <UpdateAdminDialog
                adminId={adminId}
                open={open}
                setOpen={setOpen}
            />
        </>
    );
}