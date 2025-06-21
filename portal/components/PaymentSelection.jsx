"use client";
import React from "react";
import { useState, useEffect } from "react";
import {
  User,
  Users,
  ChevronRight,
  ArrowLeft,
  CreditCard,
  Copy,
  Check,
  Building2,
} from "lucide-react";
import SplashScreen from "./SplashScreen";
import Link from "next/link";

const PaymentSelection = () => {
  const [loading, setLoading] = useState(true); // Splash screen state
  const [copiedAccount, setCopiedAccount] = useState(false);
  const [copiedName, setCopiedName] = useState(false);

  // Bank information
  const bankInfo = {
    accountName: "Ceylon Pharma College Pvt Ltd",
    bankName: "Bank Of Ceylon (BOC)",
    accountNumber: "89090906",
    branch: "Pelmadulla Branch",
  };

  // Simulate splash screen for 1 second
  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 1000);
    return () => clearTimeout(timer);
  }, []);

  // Copy account number to clipboard
  const copyAccountNumber = async () => {
    try {
      await navigator.clipboard.writeText(bankInfo.accountNumber);
      setCopiedAccount(true);
      setTimeout(() => setCopiedAccount(false), 2000);
    } catch (err) {
      console.error("Failed to copy: ", err);
    }
  };

  // Copy account name to clipboard
  const copyAccountName = async () => {
    try {
      await navigator.clipboard.writeText(bankInfo.accountName);
      setCopiedName(true);
      setTimeout(() => setCopiedName(false), 2000);
    } catch (err) {
      console.error("Failed to copy: ", err);
    }
  };

  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <SplashScreen
        loading={loading}
        splashTitle={`Payment Portal`}
        icon={<CreditCard className="w-16 h-16" />}
      />

      {/* ✅ Main Payment Portal (Visible after splash) */}
      {!loading && (
        <div className="flex justify-center flex-col items-center h-screen">
          <div className="min-h-screen bg-gray-50">
            {/* App Bar */}
            <div className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50 gap-2">
              <button
                onClick={() => window.history.back()}
                className="p-2 hover:bg-gray-100 rounded-full transition-colors"
              >
                <ArrowLeft className="w-6 h-6" />
              </button>
              <h1 className="text-lg font-semibold text-gray-800">
                Select Student Type
              </h1>
            </div>

            {/* Main Content */}
            <div className="p-4 space-y-4">
              {/* Bank Information Card */}
              <div className="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                <div className="flex items-center space-x-3 mb-3">
                  <div className="bg-blue-100 p-2 rounded-full">
                    <Building2 className="h-5 w-5 text-blue-600" />
                  </div>
                  <h2 className="text-base font-bold text-blue-800 bg-blue-50 px-3 py-1 rounded-lg border border-blue-200">
                    Bank Transfer Details
                  </h2>
                </div>

                <div className="space-y-2 text-sm">
                  <div className="flex justify-between items-center">
                    <span className="text-gray-600">Account Name:</span>
                    <div className="flex items-center space-x-2">
                      <span className="font-medium text-gray-800">
                        {bankInfo.accountName}
                      </span>
                      <button
                        onClick={copyAccountName}
                        className="p-1 hover:bg-gray-100 rounded transition-colors"
                        title="Copy account name"
                      >
                        {copiedName ? (
                          <Check className="h-4 w-4 text-green-600" />
                        ) : (
                          <Copy className="h-4 w-4 text-gray-500" />
                        )}
                      </button>
                    </div>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Bank Name:</span>
                    <span className="font-medium text-gray-800">
                      {bankInfo.bankName}
                    </span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-gray-600">Account Number:</span>
                    <div className="flex items-center space-x-2">
                      <span className="font-medium text-gray-800">
                        {bankInfo.accountNumber}
                      </span>
                      <button
                        onClick={copyAccountNumber}
                        className="p-1 hover:bg-gray-100 rounded transition-colors"
                        title="Copy account number"
                      >
                        {copiedAccount ? (
                          <Check className="h-4 w-4 text-green-600" />
                        ) : (
                          <Copy className="h-4 w-4 text-gray-500" />
                        )}
                      </button>
                    </div>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Branch:</span>
                    <span className="font-medium text-gray-800">
                      {bankInfo.branch}
                    </span>
                  </div>
                </div>
              </div>

              {/* Internal Student Card */}
              <Link
                href="./payment/internal-payment"
                className="block"
                rel="noopener noreferrer"
              >
                <div className="bg-white rounded-xl p-4 shadow-sm active:bg-gray-50 transition-colors">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                      <div className="bg-green-100 p-3 rounded-full">
                        <User className="h-6 w-6 text-brand" />
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
              <Link
                href="./payment/external-payment"
                className="block"
                rel="noopener noreferrer"
              >
                <div className="bg-white rounded-xl p-4 shadow-sm active:bg-gray-50 transition-colors">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                      <div className="bg-green-100 p-3 rounded-full">
                        <Users className="h-6 w-6 text-brand" />
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

              {/* Non-Refundable Warning */}
              <div className="bg-red-50 border border-red-200 rounded-xl p-4 mt-6">
                <div className="flex items-start space-x-3">
                  <div className="flex-shrink-0 bg-red-100 p-2 rounded-full mt-1">
                    <svg
                      className="h-4 w-4 text-red-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h3 className="text-sm font-semibold text-red-800 mb-1">
                      Important Notice
                    </h3>
                    <p className="text-sm text-red-800">
                      <span className="font-bold bg-red-100 px-2 py-1 rounded">
                        ALL PAYMENTS ARE NON-REFUNDABLE
                      </span>
                      <br />
                      Please verify all details carefully before making any
                      payment.
                    </p>
                  </div>
                </div>
              </div>

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
                    Please use the bank details above for payments, then select
                    your student type to proceed with the payment confirmation
                    process.
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
