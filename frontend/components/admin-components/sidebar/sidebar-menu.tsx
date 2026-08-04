export const SidebarMenu = ({
  title,
  children,
}: {
  title: string;
  children: React.ReactNode;
}) => {
  return (
    <div className="space-y-1">
      <p className="px-3 text-xs font-semibold text-muted-foreground uppercase">
        {title}
      </p>
      {children}
    </div>
  );
};
