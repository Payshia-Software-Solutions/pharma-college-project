import React from "react";
import { User } from "lucide-react";

export default function StepHeader() {
  return (
    <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
      <div className="flex items-center ml-2">
        <User className="w-6 h-6 text-brand mr-2" />
        <h1 className="text-lg font-semibold">Student Portal</h1>
      </div>
    </header>
  );
}
