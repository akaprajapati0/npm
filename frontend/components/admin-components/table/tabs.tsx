"use client";

import React from "react";
import {
  Tabs,
  TabsList,
  TabsTrigger,
  TabsContent,
} from "@/components/ui/tabs";

interface TabProps {
  label: string;
  children: React.ReactNode;
}

interface ReusableTabsProps {
  children: React.ReactNode;
}

export function ReusableTabs({ children }: ReusableTabsProps) {
  const tabs = React.Children.toArray(children) as React.ReactElement<TabProps>[];

  const defaultValue = tabs[0]?.props.label || "";

  return (
    <Tabs defaultValue={defaultValue} className="w-full">
      
      <TabsList className="mb-5">
        {tabs.map((tab, index) => (
          <TabsTrigger key={index} value={tab.props.label}>
            {tab.props.label}
          </TabsTrigger>
        ))}
      </TabsList>

      {tabs.map((tab, index) => (
        <TabsContent key={index} value={tab.props.label}>
          {tab.props.children}
        </TabsContent>
      ))}
    </Tabs>
  );
}

ReusableTabs.Tab = function Tab({ children }: TabProps) {
  return <>{children}</>;
};
