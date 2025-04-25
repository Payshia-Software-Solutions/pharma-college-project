// PaymentStatus.js
import React from "react";
import { DollarSign } from "lucide-react";

const PaymentStatus = ({ registration }) => (
  <div className="space-y-2">
    <h3 className="text-lg font-medium flex items-center">
      <DollarSign className="w-5 h-5 text-green-500 mr-2" />
      Payment Status
    </h3>
    <p>
      <strong>Status:</strong>{" "}
      <span
        className={`capitalize ${
          registration.payment_status === "pending"
            ? "text-yellow-600"
            : "text-green-600"
        }`}
      >
        {registration.payment_status}
      </span>
    </p>
    {registration.payment_amount && (
      <p>
        <strong>Amount:</strong> $
        {parseFloat(registration.payment_amount).toFixed(2)}
      </p>
    )}
  </div>
);

export default PaymentStatus;
