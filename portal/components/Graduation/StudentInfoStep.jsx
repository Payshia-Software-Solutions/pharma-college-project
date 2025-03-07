"use client";
import React from "react";

import { useState, useEffect } from "react"; // Added useEffect for better state management
import { motion } from "framer-motion";
import { User, Loader } from "lucide-react";

export default function StudentInfoStep({
  formData,
  updateFormData,
  setIsValid,
}) {
  const [error, setError] = useState("");
  const [studentInfo, setStudentInfo] = useState(null);
  const [loading, setLoading] = useState(false);

  // Validate student number format
  const validateStudentNumber = (value) => {
    if (!value) {
      setError("Student number is required.");
      return false;
    }
    if (!/^PA\d{5,}$/.test(value)) {
      setError(
        "Student number must start with 'PA' followed by at least 5 digits."
      );
      return false;
    }
    setError("");
    return true;
  };

  // Fetch student details from API
  const fetchStudentDetails = async (studentNumber) => {
    setLoading(true);
    try {
      const response = await fetch(
        `${process.env.NEXT_PUBLIC_API_URL}/userFullDetails/username/${studentNumber}`
      );
      if (!response.ok) {
        throw new Error("Student not found");
      }
      const data = await response.json();
      setStudentInfo(data);
      updateFormData("studentName", `${data.first_name} ${data.last_name}`);
      setIsValid(true); // Only set true on successful fetch
    } catch (error) {
      setStudentInfo(null);
      setError("Student not found. Please check the student number.");
      setIsValid(false);
    } finally {
      setLoading(false);
    }
  };

  // Handle input change
  const handleChange = (e) => {
    const value = e.target.value.toUpperCase();
    updateFormData("studentNumber", value);
    if (validateStudentNumber(value)) {
      fetchStudentDetails(value);
    } else {
      setStudentInfo(null);
      setIsValid(false); // Invalidate if format fails
    }
  };

  // Sync isValid with initial load or formData changes
  useEffect(() => {
    if (
      formData.studentNumber &&
      validateStudentNumber(formData.studentNumber)
    ) {
      if (!studentInfo) {
        fetchStudentDetails(formData.studentNumber); // Fetch if valid but no info yet
      } else {
        setIsValid(true); // Valid if we already have studentInfo
      }
    } else {
      setIsValid(false); // Invalid if studentNumber is empty or malformed
    }
  }, [formData.studentNumber]);

  // Masking functions
  const maskEmail = (email) =>
    email
      ? `${email.slice(0, 2)}***${email.slice(-2)}@${email.split("@")[1]}`
      : "N/A";
  const maskPhone = (phone) =>
    phone ? phone.replace(/\d(?=\d{4})/g, "*") : "N/A";
  const maskNIC = (nic) =>
    nic && nic.length > 4
      ? `${nic.slice(0, 4)}***${nic.slice(-4)}`
      : nic || "N/A";

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <div className="space-y-4">
        <div className="bg-green-50 p-4 rounded-lg flex items-start space-x-3">
          <User className="w-5 h-5 text-green-500 mt-0.5" />
          <div>
            <h3 className="font-medium text-green-800">Student Information</h3>
            <p className="text-sm text-green-600">
              Please enter your student details
            </p>
          </div>
        </div>

        <div className="space-y-4">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Student Number
            </label>
            <div className="relative">
              <input
                type="text"
                name="studentNumber"
                value={formData.studentNumber}
                onChange={handleChange}
                disabled={loading} // Disable input during fetch
                className={`w-full p-3 pr-10 border rounded-lg focus:ring-2 ${
                  error
                    ? "border-red-500 focus:ring-red-500"
                    : "border-gray-300 focus:ring-green-500"
                }`}
                placeholder="e.g., PA12345"
              />
              <User className="w-5 h-5 text-gray-400 absolute right-3 top-3" />
            </div>
            {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
          </div>

          {loading && (
            <div className="flex items-center text-green-600">
              <Loader className="w-5 h-5 animate-spin mr-2" />
              Fetching student details...
            </div>
          )}

          {studentInfo && (
            <div className="bg-green-50 rounded-lg p-3">
              <h1 className="font-medium text-xl mb-2 border-b text-gray-800">
                Student Information
              </h1>

              <div className="space-y-2">
                <div className="flex justify-between">
                  <div>
                    <div className="text-sm text-gray-500">Full Name</div>
                    <div className="text-gray-700 font-medium">
                      {studentInfo.first_name} {studentInfo.last_name}
                    </div>
                  </div>
                </div>
                <div className="flex justify-between">
                  <div>
                    <div className="text-sm text-gray-500">Email Address</div>
                    <div className="text-gray-700 font-medium">
                      {maskEmail(studentInfo.e_mail)}
                    </div>
                  </div>
                  <span className="text-2xl">📧</span>
                </div>
                <div className="flex justify-between">
                  <div>
                    <div className="text-sm text-gray-500">Phone Number</div>
                    <div className="text-gray-700 font-medium">
                      {maskPhone(studentInfo.telephone_1)}
                    </div>
                  </div>
                  <span className="text-2xl">📱</span>
                </div>
                <div className="flex justify-between">
                  <div>
                    <div>
                      <div className="text-sm text-gray-500">NIC Number</div>
                      <div className="text-gray-700 font-medium">
                        {maskNIC(studentInfo.nic)}
                      </div>
                    </div>
                  </div>
                  <span className="text-2xl">🪪</span>
                </div>
              </div>
              <div className="mt-2 p-4 bg-orange-50 rounded-xl border border-orange-100">
                <div className="flex items-start">
                  <span className="text-xl mr-3">⚠️</span>
                  <p className="text-sm text-orange-700">
                    Please verify that this information is correct. If you
                    notice any discrepancies, contact student support
                    immediately.
                  </p>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>
    </motion.div>
  );
}
