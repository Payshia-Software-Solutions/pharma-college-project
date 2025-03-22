import Link from "next/link";
import React from "react";

import { ArrowLeft } from "lucide-react";

export default function Header({ currentStep, prevStep, steps }) {
  const StepIcon = steps[currentStep - 1].icon;

  return (
    <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
      {currentStep === 1 ? (
        <Link href={`/`}>
          <button className="p-2 hover:bg-gray-100 rounded-full transition-colors">
            <ArrowLeft className="w-6 h-6" />
          </button>
        </Link>
      ) : (
        <button
          onClick={prevStep}
          className="p-2 hover:bg-gray-100 rounded-full transition-colors"
        >
          <ArrowLeft className="w-6 h-6" />
        </button>
      )}
      <div className="flex items-center ml-2">
        <StepIcon className="w-6 h-6 text-brand mr-2" />
        <h1 className="text-lg font-semibold">
          {steps[currentStep - 1].title}
        </h1>
      </div>
    </header>
  );
}
