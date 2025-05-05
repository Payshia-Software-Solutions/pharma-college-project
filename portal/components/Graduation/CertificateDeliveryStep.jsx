"use client";
import React, { useEffect, useState } from "react";
import { motion } from "framer-motion";

const CertificateDeliveryStep = ({
  formData,
  setFormData,
  setIsValid,
  setStepLoading,
}) => {
  useEffect(() => {
    setIsValid(
      !!formData.deliveryMethod &&
        (formData.deliveryMethod !== "Convocation Ceremony" || formData.session)
    );
  }, [formData.deliveryMethod, formData.session, setIsValid]);

  const [convocation, setConvocation] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchConvocation = async () => {
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}convocations/1`
        );
        if (!response.ok) {
          throw new Error("Failed to fetch convocation data");
        }
        const data = await response.json();
        setConvocation(data);
        console.log(convocation);
      } catch (error) {
        setError(error.message);
      } finally {
        setStepLoading(false);
      }
    };

    fetchConvocation();
  }, []);

  const handleDeliveryMethodChange = (method) => {
    setFormData((prevState) => ({
      ...prevState,
      deliveryMethod: method,
      session: method === "Convocation Ceremony" ? prevState.session : null, // Clear session if not Convocation Ceremony
    }));
  };

  const handleSessionChange = (session) => {
    setFormData((prevState) => ({
      ...prevState,
      session,
    }));
  };

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
      <div className="flex space-x-4">
        <button
          onClick={() => handleDeliveryMethodChange("Convocation Ceremony")}
          className={`${
            formData.deliveryMethod === "Convocation Ceremony"
              ? "bg-blue-600 text-white border-blue-700"
              : "bg-gray-200 text-gray-700"
          } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-1/2`}
        >
          Convocation Ceremony
        </button>
        <button
          onClick={() => handleDeliveryMethodChange("By Courier")}
          className={`${
            formData.deliveryMethod === "By Courier"
              ? "bg-blue-600 text-white border-blue-700"
              : "bg-gray-200 text-gray-700"
          } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-1/2`}
        >
          By Courier
        </button>
      </div>

      {formData.deliveryMethod === "Convocation Ceremony" && (
        <div className="mt-6 space-y-4">
          <h3 className="text-lg font-semibold text-center">Select Session</h3>

          <div className="flex space-x-4 justify-center">
            <button
              onClick={() => handleSessionChange("Session 1")}
              className={`${
                formData.session === "Session 1"
                  ? "bg-blue-600 text-white border-blue-700"
                  : "bg-gray-200 text-gray-700"
              } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-1/2`}
            >
              Session 1<p>10.00 - 12.00</p>
            </button>
            <button
              onClick={() => handleSessionChange("Session 2")}
              className={`${
                formData.session === "Session 2"
                  ? "bg-blue-600 text-white border-blue-700"
                  : "bg-gray-200 text-gray-700"
              } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-1/2`}
            >
              Session 2<p>12.30 - 2.30</p>
            </button>
          </div>
        </div>
      )}
    </motion.div>
  );
};

export default CertificateDeliveryStep;
