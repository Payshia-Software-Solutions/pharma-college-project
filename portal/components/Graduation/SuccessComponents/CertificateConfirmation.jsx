import React, { useState, useEffect } from "react";
import { CheckCircle, Truck, Copy, Calendar } from "lucide-react";

export default function CertificateConfirmation({ referenceNumber }) {
  const [copied, setCopied] = useState(false);

  const copyToClipboard = () => {
    navigator.clipboard.writeText(referenceNumber);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <div className="max-w-lg mx-auto p-6 bg-white rounded-lg ">
      <div className="flex items-center justify-center mb-6">
        <div className="bg-green-100 p-3 rounded-full">
          <CheckCircle className="text-green-500 h-8 w-8" />
        </div>
      </div>

      <h2 className="text-2xl font-bold text-center text-gray-800 mb-4">
        Certificate Confirmation
      </h2>

      <p className="text-center text-gray-600 mb-6">
        Your certificate has been processed successfully and will be delivered
        to the address provided.
      </p>

      <div className="bg-gray-50 p-4 rounded-lg mb-6">
        <div className="flex justify-between items-center">
          <span className="text-gray-500 font-medium">Reference Number:</span>
          <div className="flex items-center">
            <span className="font-bold text-gray-800 mr-2">
              {referenceNumber}
            </span>
            <button
              onClick={copyToClipboard}
              className="p-1 hover:bg-gray-200 rounded-full transition-colors"
              aria-label="Copy reference number"
            >
              <Copy className="h-4 w-4 text-gray-500" />
            </button>
            {copied && (
              <span className="text-green-500 text-xs ml-1">Copied!</span>
            )}
          </div>
        </div>
      </div>

      <div className="border-t border-gray-200 pt-4 mb-6">
        <div className="flex items-center mb-3">
          <Truck className="h-5 w-5 text-blue-500 mr-2" />
          <span className="font-medium">Delivery Status</span>
        </div>
        <div className="ml-7 text-gray-600">
          <p>
            Your certificate is being processed and will be shipped within 3-5
            business days.
          </p>
        </div>
      </div>

      <div className="text-xs text-center text-gray-500 mt-8">
        Please keep your reference number safe for tracking your delivery. If
        you have any questions, contact support@pharmacollege.lk
      </div>
    </div>
  );
}
