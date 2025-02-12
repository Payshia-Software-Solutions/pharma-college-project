"use client";
import React from "react";
import Link from "next/link";
import { ArrowRight } from "lucide-react";
import { Card, CardContent } from "@/components/ui/card";

const PortalLanding = () => {
  return (
    <div className="h-screen lg:min-h-40 bg-gradient-to-br from-green-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto">
      {/* Header */}
      <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
        <div className="flex items-center ml-2">
          <h1 className="text-lg font-semibold">Student Portal</h1>
        </div>
      </header>

      {/* Logo Section */}
      <div className="bg-white flex justify-center items-center flex-col w-full pt-4">
        <div className="w-[30%] aspect-square bg-gray-200 flex items-center justify-center">
          {/* Replace with actual Image component when you have the logo */}
          <img
            src="/logo.png"
            alt="College Logo"
            className="w-full h-full object-contain"
          />
        </div>
        <p className="text-3xl font-bold mt-4">Student Portal</p>
      </div>

      {/* Main Content */}
      <main className="flex-1 p-4">
        <Card className="bg-white rounded-xl shadow-lg p-6 space-y-6">
          <CardContent className="space-y-4">
            {/* Register Button */}
            <Link href="/register">
              <button className="w-full bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200 flex items-center justify-between">
                <span className="text-lg font-semibold">Register</span>
                <ArrowRight className="w-5 h-5" />
              </button>
            </Link>

            {/* Payment Button */}
            <Link href="/payment">
              <button className="w-full bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200 flex items-center justify-between">
                <span className="text-lg font-semibold">Make a Payment</span>
                <ArrowRight className="w-5 h-5" />
              </button>
            </Link>
          </CardContent>
        </Card>
      </main>
    </div>
  );
};

export default PortalLanding;
