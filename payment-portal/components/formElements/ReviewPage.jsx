import React from "react";
import { FileText } from "lucide-react";

function ReviewPage({ formData, updateFormData }) {
  return (
    <div className="space-y-4">
      <div className="bg-green-50 p-4 rounded-lg flex items-start space-x-3">
        <FileText className="w-5 h-5 text-green-500 mt-0.5" />
        <div>
          <h3 className="font-medium text-green-800">Review Payment</h3>
          <p className="text-sm text-green-600">Verify your payment details</p>
        </div>
      </div>

      <div className="bg-gray-50 rounded-lg p-4 space-y-3">
        <div className="flex justify-between items-center p-2 hover:bg-gray-100 rounded-lg transition-colors">
          <span className="text-gray-600">Student Number</span>
          <span className="font-medium">{formData.studentNumber}</span>
        </div>
        <div className="flex justify-between items-center p-2 hover:bg-gray-100 rounded-lg transition-colors">
          <span className="text-gray-600">Payment Reason</span>
          <span className="font-medium">{formData.paymentReason}</span>
        </div>
        <div className="flex justify-between items-center p-2 hover:bg-gray-100 rounded-lg transition-colors">
          <span className="text-gray-600">Amount</span>
          <span className="font-medium text-green-600">
            LKR {formData.amount}
          </span>
        </div>
        <div className="flex justify-between items-center p-2 hover:bg-gray-100 rounded-lg transition-colors">
          <span className="text-gray-600">Reference</span>
          <span className="font-medium">{formData.reference}</span>
        </div>
        <div className="flex justify-between items-center p-2 hover:bg-gray-100 rounded-lg transition-colors">
          <span className="text-gray-600">Bank</span>
          <span className="font-medium">{formData.bank}</span>
        </div>
        <div className="flex justify-between items-center p-2 hover:bg-gray-100 rounded-lg transition-colors">
          <span className="text-gray-600">Branch</span>
          <span className="font-medium">{formData.branch}</span>
        </div>
      </div>
    </div>
  );
}

export default ReviewPage;
