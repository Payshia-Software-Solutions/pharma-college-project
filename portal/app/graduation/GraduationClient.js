"use client";

import React, { useEffect, useState } from "react";
import { useSearchParams } from "next/navigation";
import GraduationPortal from "@/components/GraduationPortal";

export default function GraduationClient() {
  const searchParams = useSearchParams();
  const [isActive, setIsActive] = useState(true);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const forceActive = searchParams.get("forceActive");
    setIsActive(!!forceActive);
    setIsLoading(false);
  }, [searchParams]);

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
          <p className="text-gray-600">Loading...</p>
        </div>
      </div>
    );
  }

  if (!isActive) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-100 p-4">
        <div className="max-w-md w-full">
          {/* Registration Closed Card */}
          <div className="bg-white rounded-2xl shadow-2xl p-8 text-center border-t-4 border-red-500">
            {/* Icon */}
            <div className="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg
                className="w-10 h-10 text-red-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"
                />
              </svg>
            </div>

            {/* Title */}
            <h1 className="text-2xl font-bold text-gray-800 mb-4">
              Registration Closed
            </h1>

            {/* Description */}
            <p className="text-gray-600 mb-6 leading-relaxed">
              The graduation portal registration period has ended. New
              applications are no longer being accepted at this time.
            </p>

            {/* Contact Info */}
            <div className="bg-gray-50 rounded-lg p-4 mb-6">
              <p className="text-sm text-gray-700 font-medium mb-2">
                Need assistance?
              </p>
              <p className="text-sm text-gray-600">
                Please contact the administration office for inquiries.
              </p>
            </div>

            {/* Status Badge */}
            <div className="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-medium">
              <svg
                className="w-4 h-4 mr-2"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fillRule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clipRule="evenodd"
                />
              </svg>
              Registrations Unavailable
            </div>
          </div>

          {/* Footer */}
          <div className="text-center mt-6">
            <p className="text-sm text-gray-500">
              Graduation Portal • Pharma Archivers
            </p>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="">
      <GraduationPortal />
    </div>
  );
}
