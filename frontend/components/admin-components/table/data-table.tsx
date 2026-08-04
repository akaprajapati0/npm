"use client";

import React, { useState, useMemo, useRef, useEffect } from "react";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/components/ui/card";
import {
  Table,
  TableHeader,
  TableBody,
  TableRow,
  TableCell,
} from "@/components/ui/table";
import { Loader2 } from "lucide-react";
import { Input } from "@/components/ui/input";

// ─── Types ──

interface ReusableDataTableProps<T extends object> {
  heading: string;
  subHeading?: string;
  data: T[];
  loading?: boolean;
  head: React.ReactNode;
  children: (row: T, index: number) => React.ReactNode;

  // 🔥 NEW
  hasNextPage?: boolean;
  isFetchingNextPage?: boolean;
  onLoadMore?: () => void;

  searchKeys?: (keyof T)[];
}

// ─── Component ───

export function ReusableDataTable<T extends object>({
  heading,
  subHeading,
  data,
  loading = false,
  head,
  children,
  hasNextPage,
  isFetchingNextPage,
  onLoadMore,
  searchKeys = [],
}: ReusableDataTableProps<T>) {
  const [search, setSearch] = useState("");
  const loadMoreRef = useRef<HTMLDivElement | null>(null);

  // ── Filter ──
  const filteredData = useMemo(() => {
    const trimmed = search.trim().toLowerCase();
    if (!trimmed || searchKeys.length === 0) return data;

    return data.filter((row) =>
      searchKeys.some((key) =>
        String(row[key] ?? "").toLowerCase().includes(trimmed)
      )
    );
  }, [search, data, searchKeys]);

  // ── Infinite Scroll Trigger ──
  useEffect(() => {
    if (!loadMoreRef.current || !onLoadMore) return;

    const observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && hasNextPage) {
        onLoadMore();
      }
    });

    observer.observe(loadMoreRef.current);

    return () => observer.disconnect();
  }, [hasNextPage, onLoadMore]);

  const columnCount = React.Children.count(head) || 1;

  // ── Loading ──
  if (loading) {
    return (
      <div className="flex items-center justify-center py-16">
        <Loader2 className="h-6 w-6 animate-spin" />
      </div>
    );
  }

  return (
    <Card className="border-none shadow-none">
      <CardHeader>
        <CardTitle className="text-2xl font-medium">{heading}</CardTitle>
        {subHeading && <CardDescription>{subHeading}</CardDescription>}
      </CardHeader>

      <CardContent>
        {/* Search */}
        {searchKeys.length > 0 && (
          <div className="mb-4">
            <Input
              placeholder="Search…"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="max-w-xs"
            />
          </div>
        )}

        {/* Table */}
        <div className="overflow-hidden rounded-lg border">
          <Table>
            <TableHeader>
              <TableRow>{head}</TableRow>
            </TableHeader>

            <TableBody>
              {filteredData.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={columnCount} className="text-center py-10">
                    No records found
                  </TableCell>
                </TableRow>
              ) : (
                filteredData.map((row, index) => (
                  <TableRow key={index}>
                    {children(row, index)}
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </div>

        {/* Load More Trigger */}
        <div ref={loadMoreRef} className="h-10 flex justify-center items-center">
          {isFetchingNextPage && (
            <Loader2 className="h-5 w-5 animate-spin mt-4" />
          )}
        </div>
      </CardContent>
    </Card>
  );
}