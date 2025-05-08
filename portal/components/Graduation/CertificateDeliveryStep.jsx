"use client";
import React, { useEffect, useState } from "react";
import { motion } from "framer-motion";

const CertificateDeliveryStep = ({
  formData,
  setFormData,
  setIsValid,
  setStepLoading,
}) => {
  const [convocation, setConvocation] = useState(null);
  const [sessionRegistrations, setSessionRegistrations] = useState([]);
  const [error, setError] = useState(null);

  // Fetch convocation data and session registrations
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
      } catch (error) {
        setError(error.message);
      } finally {
        setStepLoading(false);
      }
    };

    const fetchRegistrations = async () => {
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}convocation-registrations/get-counts-by-sessions/`
        );
        if (!response.ok) {
          throw new Error("Failed to fetch session registrations");
        }
        const data = await response.json();
        setSessionRegistrations(data);
      } catch (error) {
        setError(error.message);
      } finally {
        setStepLoading(false);
      }
    };

    fetchConvocation();
    fetchRegistrations();
  }, [setStepLoading]);

  const getRemainingSeats = (sessionId) => {
    if (!convocation || sessionRegistrations.length === 0) return 0;

    const session = sessionRegistrations.find(
      (item) => item.session === sessionId
    );

    if (session) {
      const remainingSeats = Math.max(
        0,
        convocation.student_seats - session.sessionCounts
      );

      return remainingSeats;
    }

    // Default case if session not found
    return convocation.student_seats;
  };

  // Update form validity based on both sessions' availability
  useEffect(() => {
    const remainingSeatsSession1 = getRemainingSeats(1);
    const remainingSeatsSession2 = getRemainingSeats(2);

    // If both sessions are full, set form as invalid
    if (remainingSeatsSession1 === 0 && remainingSeatsSession2 === 0) {
      setIsValid(false); // Disable form if both sessions have no remaining seats
    } else {
      setIsValid(true); // Enable form if any session has remaining seats
    }
  }, [convocation, sessionRegistrations, setIsValid]);

  // Handle the delivery method change
  const handleDeliveryMethodChange = (method) => {
    setFormData((prevState) => ({
      ...prevState,
      deliveryMethod: method,
      session: method === "Convocation Ceremony" ? prevState.session : null, // Clear session if not Convocation Ceremony
    }));
  };

  // Handle session change
  const handleSessionChange = (session) => {
    setFormData((prevState) => ({
      ...prevState,
      session: session,
    }));
  };

  // Validate form based on delivery method and session
  useEffect(() => {
    setIsValid(
      !!formData.deliveryMethod &&
        (formData.deliveryMethod !== "Convocation Ceremony" || formData.session)
    );
  }, [formData.deliveryMethod, formData.session, setIsValid]);

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
          Convocation Ceremony (BMICH)
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

          <div className="flex flex-col md:flex-row md:space-x-4 justify-center gap-4 md:gap-0">
            <button
              onClick={() => handleSessionChange(1)}
              disabled={getRemainingSeats(1) === 0} // Disable button if no seats left
              className={`${
                formData.session === 1
                  ? "bg-blue-600 text-white border-blue-700"
                  : "bg-gray-200 text-gray-700"
              } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-1/2 ${
                getRemainingSeats(1) === 0
                  ? "cursor-not-allowed opacity-50"
                  : ""
              }`}
            >
              Session 1<p>Time: 10.00 - 12.00</p>
              <p>Remaining: {getRemainingSeats(1)}</p>
            </button>

            <button
              onClick={() => handleSessionChange(2)}
              disabled={getRemainingSeats(2) === 0} // Disable button if no seats left
              className={`${
                formData.session === 2
                  ? "bg-blue-600 text-white border-blue-700"
                  : "bg-gray-200 text-gray-700"
              } py-3 px-4 rounded-lg border transition-all duration-300 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-1/2 ${
                getRemainingSeats(2) === 0
                  ? "cursor-not-allowed opacity-50"
                  : ""
              }`}
            >
              Session 2<p>Time: 12.30 - 2.30</p>
              <p>Remaining: {getRemainingSeats(2)}</p>
            </button>
          </div>
        </div>
      )}
    </motion.div>
  );
};

export default CertificateDeliveryStep;
