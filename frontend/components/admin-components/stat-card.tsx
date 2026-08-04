import { Card, CardContent } from "@/components/ui/card";
import { cn } from "@/lib/utils";
import { LucideIcon } from "lucide-react";

interface StatCardProps {
  label: string;
  value: string | number;
  sub?: string;
  icon: LucideIcon;
  trend?: "up" | "down" | "neutral";
  iconColor?: string;
  delay?: number;
}

export function StatCard({ label, value, sub, icon: Icon, trend, iconColor, delay = 0 }: StatCardProps) {
  return (
    <Card
      className="animate-fade-in"
      style={{ animationDelay: `${delay}ms` }}
    >
      <CardContent className="p-5">
        <div className="flex items-start justify-between">
          <div className="space-y-1">
            <p className="text-xs text-muted-foreground font-medium">{label}</p>
            <p className="text-2xl font-semibold tracking-tight">{value}</p>
            {sub && (
              <p className={cn(
                "text-xs",
                trend === "up" ? "text-emerald-600 dark:text-emerald-400" :
                  trend === "down" ? "text-red-500 dark:text-red-400" :
                    "text-muted-foreground"
              )}>
                {sub}
              </p>
            )}
          </div>
          <div className={cn("flex h-9 w-9 items-center justify-center rounded-lg", iconColor || "bg-primary/10")}>
            <Icon className={cn("h-4 w-4", iconColor ? "text-inherit" : "text-primary")} />
          </div>
        </div>
      </CardContent>
    </Card>
  );
}
