"use client";
import React from "react";

import { useState, useEffect } from "react";
import Link from "next/link";
import { User, Users, ChevronRight, ArrowLeft } from "lucide-react";
import SplashScreen from "./SplashScreen";

const PaymentSelection = () => {
  const [loading, setLoading] = useState(true); // Splash screen state

  // Simulate splash screen for 2.5 seconds
  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 1000);
    return () => clearTimeout(timer);
  }, []);
  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <SplashScreen loading={loading} />

      {/* ✅ Main Payment Portal (Visible after splash) */}
      {!loading && (
        <div className="flex justify-center flex-col items-center h-screen">
          <div className="min-h-screen bg-gray-50">
            {/* App Bar */}
            <div className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50 gap-2">
              <Link href={`../`}>
                <button className="p-2 hover:bg-gray-100 rounded-full transition-colors">
                  <ArrowLeft className="w-6 h-6" />
                </button>
              </Link>
              <h1 className="text-lg font-semibold text-gray-800">
                Select Student Type
              </h1>
            </div>

            {/* Main Content */}
            <div className="p-4 space-y-4">
              {/* Internal Student Card */}
              <Link href="./payment/internal-payment" className="block">
                <div className="bg-white rounded-xl p-4 shadow-sm active:bg-gray-50 transition-colors">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                      <div className="bg-green-100 p-3 rounded-full">
                        <User className="h-6 w-6 text-green-600" />
                      </div>
                      <div>
                        <h2 className="text-base font-medium text-gray-800">
                          Internal Student
                        </h2>
                        <p className="text-sm text-gray-500">
                          Currently enrolled students
                        </p>
                      </div>
                    </div>
                    <ChevronRight className="h-5 w-5 text-gray-400" />
                  </div>
                </div>
              </Link>

              {/* External Student Card */}
              <Link href="./payment/external-payment" className="block">
                <div className="bg-white rounded-xl p-4 shadow-sm active:bg-gray-50 transition-colors">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                      <div className="bg-green-100 p-3 rounded-full">
                        <Users className="h-6 w-6 text-green-600" />
                      </div>
                      <div>
                        <h2 className="text-base font-medium text-gray-800">
                          External Student
                        </h2>
                        <p className="text-sm text-gray-500">
                          Non-enrolled students
                        </p>
                      </div>
                    </div>
                    <ChevronRight className="h-5 w-5 text-gray-400" />
                  </div>
                </div>
              </Link>

              {/* Info Card */}
              <div className="bg-green-50 rounded-xl p-4 mt-6">
                <div className="flex items-start space-x-3">
                  <div className="flex-shrink-0 bg-green-100 p-2 rounded-full mt-1">
                    <svg
                      className="h-4 w-4 text-green-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <p className="text-sm text-green-800">
                    Please select your student type to proceed with the payment
                    process. Different payment options may be available based on
                    your status.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default PaymentSelection;
