"use client";
import React, { useEffect, useState } from "react";
import { motion } from "framer-motion";

const CertificateDeliveryStep = ({
  deliveryMethod,
  setDeliveryMethod,
  setIsValid,
}) => {
  useEffect(() => {
    setIsValid(!!deliveryMethod);
  }, [deliveryMethod, setIsValid]);

  const [loading, setLoading] = useState(false);
  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-2xl font-semibold text-center mb-6">
        Select Certificate Delivery Method
      </h2>
      {loading ? (
        <div className="flex justify-center items-center">
          <svg
            className="animate-spin h-8 w-8 text-blue-600"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
          >
            <circle cx="12" cy="12" r="10" strokeWidth="4" />
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              d="M4 12a8 8 0 118 8"
            />
          </svg>
        </div>
      ) : (
        <div className="flex space-x-4">
          <button
            onClick={() => setDeliveryMethod("Convocation Ceremony")}
            className={`${
              deliveryMethod === "Convocation Ceremony"
                ? "bg-blue-600 text-white border-blue-700"
                : "bg-gray-200 text-gray-700"
            } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-1/2`}
          >
            Convocation Ceremony
          </button>
          <button
            onClick={() => setDeliveryMethod("By Courier")}
            className={`${
              deliveryMethod === "By Courier"
                ? "bg-blue-600 text-white border-blue-700"
                : "bg-gray-200 text-gray-700"
            } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-1/2`}
          >
            By Courier
          </button>
        </div>
      )}
    </motion.div>
  );
};

export default CertificateDeliveryStep;
