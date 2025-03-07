import React from "react";
import { motion } from "framer-motion";

export default function ProgressBar({ steps, currentStep }) {
  return (
    <div className="bg-white px-4 py-6 md:shadow-none shadow-lg">
      <div className="flex justify-between items-center relative">
        {steps.map((step, idx) => {
          const Icon = step.icon; // Now step.icon is a component type (e.g., User)
          return (
            <div
              key={step.id}
              className="relative flex flex-1 flex-col items-center"
            >
              {idx < steps.length - 1 && (
                <div className="absolute top-5 left-1/2 w-full h-1 -z-10">
                  <div
                    className="h-full bg-gray-200 rounded"
                    style={{
                      background: `linear-gradient(to right, #3B82F6 ${
                        currentStep > step.id ? "100%" : "0%"
                      }, #E5E7EB ${currentStep > step.id ? "0%" : "100%"})`,
                    }}
                  />
                </div>
              )}
              <motion.div
                className={`
                  w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 z-10
                  ${
                    currentStep >= step.id
                      ? "bg-brand text-white scale-110"
                      : "bg-gray-200 text-gray-500"
                  }
                `}
                whileHover={{ scale: 1.1 }}
              >
                <Icon
                  size={20}
                  color={currentStep >= step.id ? "white" : "gray"}
                />
              </motion.div>
              <span
                className={`mt-2 text-xs font-medium transition-colors duration-300 text-center
                  ${currentStep >= step.id ? "text-brand" : "text-gray-500"}
                `}
              >
                {step.title}
              </span>
            </div>
          );
        })}
      </div>
    </div>
  );
}
