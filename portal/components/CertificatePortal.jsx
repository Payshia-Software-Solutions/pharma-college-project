"use client";

import { useState, useEffect } from "react";
import SplashScreen from "./SplashScreen";
import {
  ArrowRight,
  ArrowLeft,
  CheckCircle,
  User,
  GraduationCap,
  ShieldCheck,
} from "lucide-react"; // Import icons from lucide-react

function CertificatePortal() {
  const [loading, setLoading] = useState(true); // Splash screen state

  // Simulate splash screen for 2.5 seconds
  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 1500);
    return () => clearTimeout(timer);
  }, []);

  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <SplashScreen
        loading={loading}
        splashTitle={`Certification Portal`}
        icon={<ShieldCheck className="w-16 h-16" />}
      />

      {/* ✅ Main Payment Portal (Visible after splash) */}
      {!loading && (
        <div className="h-screen lg:min-h-40 bg-gradient-to-br from-green-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto  pb-20">
          {/* Header */}
          <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
            <div className="flex items-center ml-2">
              <User className="w-6 h-6 text-green-500 mr-2" />
              <h1 className="text-lg font-semibold">Student Portal</h1>
            </div>
          </header>

          {/* Logo Section */}
          <div className="bg-white flex justify-center items-center flex-col w-full pt-4">
            <div className="w-[30%]  flex items-center justify-center">
              {/* Replace with actual Image component when you have the logo */}
              <img
                src="/logo.png"
                alt="College Logo"
                className="w-full h-full object-contain"
              />
            </div>
            <p className="text-3xl font-bold my-4">Certificate Order</p>
          </div>
        </div>
      )}
    </div>
  );
}

export default CertificatePortal;
