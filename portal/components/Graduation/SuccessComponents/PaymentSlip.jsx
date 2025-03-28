// PaymentSlip.js
import React from "react";
import { Upload } from "lucide-react";

const PaymentSlip = ({ registration }) => (
  <div className="space-y-2">
    <h3 className="text-lg font-medium flex items-center">
      <Upload className="w-5 h-5 text-green-500 mr-2" />
      Payment Slip
    </h3>
    {registration.image_path ? (
      <div className="mt-2">
        <img
          src={`http://content-provider.pharmacollege.lk${registration.image_path}`}
          alt="Payment Slip"
          className="max-w-full h-auto rounded-lg shadow-md"
        />
        <p className="text-sm text-gray-600 mt-1">
          Uploaded Slip: {registration.image_path.split("/").pop()}
        </p>
      </div>
    ) : (
      <p className="text-gray-600">No payment slip uploaded.</p>
    )}
  </div>
);

export default PaymentSlip;
