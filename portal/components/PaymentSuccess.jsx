import React from "react";
import { CheckCircle, Download, Share2 } from "lucide-react";

function PaymentSuccess({ paymentReference, amount, date, method }) {
  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("en-US", {
      year: "numeric",
      month: "long",
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    });
  };

  return (
    <div className="flex items-center justify-center">
      <div className="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <div className="bg-green-100 py-6 text-center">
          <div className="flex flex-col items-center space-y-4">
            <CheckCircle
              className="text-green-600 w-16 h-16 animate-bounce"
              strokeWidth={1.5}
            />
            <h2 className="text-2xl font-bold text-green-900">
              Payment Successful
            </h2>
          </div>
        </div>
        <div className="p-6 space-y-6">
          <div className="space-y-4">
            <div className="grid grid-cols-2 gap-4">
              <div>
                <p className="text-sm text-gray-600">Amount Paid</p>
                <p className="text-xl font-semibold text-green-800">
                  LKR {parseFloat(amount || 0).toFixed(2)}
                </p>
              </div>
              <div>
                <p className="text-sm text-gray-600">Payment Method</p>
                <p className="text-xl font-semibold text-green-800">{method}</p>
              </div>
            </div>

            <div className="border-t border-gray-200 my-4"></div>

            <div className="space-y-2">
              <p className="text-sm text-gray-600">Transaction Details</p>
              <div className="bg-green-50 p-3 rounded-lg">
                <div className="flex justify-between">
                  <span className="text-gray-700">Reference Number</span>
                  <span className="font-medium text-green-900">
                    {paymentReference}
                  </span>
                </div>
                <div className="flex justify-between mt-2">
                  <span className="text-gray-700">Date</span>
                  <span className="font-medium text-green-900">
                    {formatDate(date)}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default PaymentSuccess;
