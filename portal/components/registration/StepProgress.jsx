import React from "react";

export default function StepProgress({ step }) {
  const steps = ["Personal Info", "Address", "Identity", "Contact", "Course"];

  return (
    <div className="flex justify-between items-center mb-6 px-4">
      {steps.map((label, index) => {
        const current = index + 1;
        const isActive = step === current;
        const isCompleted = step > current;

        return (
          <div
            key={index}
            className="flex-1 flex flex-col items-center relative"
          >
            <div
              className={`w-8 h-8 flex items-center justify-center rounded-full border-2 text-sm font-bold 
              ${
                isCompleted
                  ? "bg-green-500 text-white border-green-500"
                  : isActive
                  ? "bg-blue-600 text-white border-blue-600"
                  : "bg-white text-gray-500 border-gray-300"
              }`}
            >
              {isCompleted ? "✔" : current}
            </div>
            <span className="text-xs mt-2 text-center text-gray-700">
              {label}
            </span>
            {index !== steps.length - 1 && (
              <div className="absolute top-4 left-full w-full h-0.5 bg-gray-300 -z-10" />
            )}
          </div>
        );
      })}
    </div>
  );
}
