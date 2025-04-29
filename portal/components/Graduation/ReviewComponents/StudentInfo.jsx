import React from "react";
import { User, CreditCard, UserCircle } from "lucide-react";

export default function StudentInfoCard({ formData }) {
  return (
    <div className="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
      <div className="bg-blue-50 px-4 py-3 border-b border-gray-200">
        <h3 className="text-lg font-medium text-blue-800 flex items-center">
          <UserCircle className="w-5 h-5 text-blue-600 mr-2" />
          Student Information
        </h3>
      </div>
      <div className="p-4 space-y-3">
        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <CreditCard className="w-5 h-5 text-gray-500 mr-3" />
            <span>Student Number</span>
          </div>
          <span className="font-semibold text-gray-900">
            {formData?.studentNumber || "Not Provided"}
          </span>
        </div>

        <div className="flex items-center justify-between py-2">
          <div className="flex items-center text-gray-700">
            <User className="w-5 h-5 text-gray-500 mr-3" />
            <span>Full Name</span>
          </div>
          <span className="font-semibold text-gray-900">
            {formData?.studentName || "Not Provided"}
          </span>
        </div>
      </div>
    </div>
  );
}
