import React, { useEffect, useState } from "react";
import { DollarSign } from "lucide-react";

function PaymentInfo({ formData, updateFormData, setIsValid }) {
  const [paymentOptions, setPaymentOptions] = useState([]);
  const [error, setError] = useState("");

  useEffect(() => {
    // Simulated API fetch
    const fetchPaymentReasons = async () => {
      const data = [
        { label: "Convocation Fee", value: "convocation", fixedAmount: 9500 },
        { label: "Courier Fee", value: "courier", fixedAmount: 400 },
        {
          label: "Course Fee",
          value: "course",
          defaultAmount: 12500,
          isEditable: true,
        },
      ];
      setPaymentOptions(data);
    };

    fetchPaymentReasons();
  }, []);

  useEffect(() => {
    validateForm();
  }, [formData]);

  const handlePaymentChange = (e) => {
    const selectedReason = e.target.value;
    updateFormData("paymentReason", selectedReason);

    const selectedOption = paymentOptions.find(
      (opt) => opt.value === selectedReason
    );

    if (selectedOption) {
      const amount =
        selectedOption.fixedAmount ?? selectedOption.defaultAmount ?? "";
      updateFormData("amount", amount);
    }
  };

  const validateForm = () => {
    if (!formData.paymentReason) {
      setError("Please select a payment reason.");
      setIsValid(false);
      return;
    }
    if (!formData.amount || formData.amount <= 0) {
      setError("Amount must be greater than zero.");
      setIsValid(false);
      return;
    }
    setError("");
    setIsValid(true);
  };

  return (
    <div className="space-y-4">
      <div className="bg-green-50 p-4 rounded-lg flex items-start space-x-3">
        <DollarSign className="w-5 h-5 text-green-500 mt-0.5" />
        <div>
          <h3 className="font-medium text-green-800">Payment Details</h3>
          <p className="text-sm text-green-600">
            Select payment type and amount
          </p>
        </div>
      </div>

      <div className="space-y-4">
        {/* Payment Reason Dropdown */}
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Payment Reason
          </label>
          <select
            value={formData.paymentReason}
            onChange={handlePaymentChange}
            className={`w-full p-3 border rounded-lg focus:ring-2 ${
              error
                ? "border-red-500 focus:ring-red-500"
                : "border-gray-300 focus:ring-green-500"
            } transition-all`}
          >
            <option value="">Select reason</option>
            {paymentOptions.map((option) => (
              <option key={option.value} value={option.value}>
                {option.label}
              </option>
            ))}
          </select>
        </div>

        {/* Amount Input */}
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Amount
          </label>
          <div className="relative">
            <span className="absolute left-4 top-3 text-gray-500">LKR</span>
            <input
              type="number"
              value={formData.amount}
              onChange={(e) => updateFormData("amount", e.target.value)}
              className={`w-full p-3 pl-12 border rounded-lg focus:ring-2 ${
                error
                  ? "border-red-500 focus:ring-red-500"
                  : "border-gray-300 focus:ring-green-500"
              } transition-all`}
              placeholder="0.00"
              min="0"
              disabled={
                paymentOptions.find(
                  (opt) => opt.value === formData.paymentReason
                )?.fixedAmount !== undefined &&
                !paymentOptions.find(
                  (opt) => opt.value === formData.paymentReason
                )?.isEditable
              }
            />
          </div>
        </div>

        {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
      </div>
    </div>
  );
}

export default PaymentInfo;
