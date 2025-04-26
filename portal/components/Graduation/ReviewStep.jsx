"use client";
import React from "react";
import { motion } from "framer-motion";
import { useState, useEffect } from "react";
import {
  User,
  Book,
  Package as PackageIcon,
  Users,
  Flower,
  GraduationCap,
  Camera,
  DollarSign,
  FileText,
  Loader,
  Upload,
} from "lucide-react";
import StudentInfoCard from "./ReviewComponents/StudentInfo";
import SelectedCoursesCard from "./ReviewComponents/SelectedCoursesCard";
import SelectedPackageCard from "./ReviewComponents/SelectedPackageCard";

export default function ReviewStep({
  formData,
  setIsValid,
  updateFormData,
  packages = [],
}) {
  const [loading] = useState(false);
  const [error] = useState(null);
  const [paymentSlip, setPaymentSlip] = useState(null);
  const [dragActive, setDragActive] = useState(false);

  const ADDITIONAL_SEAT_COST = 500;

  const selectedPackage = packages.find(
    (pkg) => pkg.package_id === formData.package_id
  ) || {
    name: "No Package Selected",
    price: 0,
    inclusions: formData.packageDetails || {
      parentSeatCount: 0,
      garland: false,
      graduationCloth: false,
      photoPackage: false,
      additionalSeats: 0,
    },
  };

  const calculateTotalAmount = () => {
    const basePrice = selectedPackage.price;
    const additionalSeats = formData.packageDetails?.additionalSeats || 0;
    const additionalCost = additionalSeats * ADDITIONAL_SEAT_COST;
    return basePrice + additionalCost;
  };

  useEffect(() => {
    const isComplete =
      formData.studentNumber &&
      formData.studentName &&
      formData.courses.length > 0 &&
      formData.package_id &&
      paymentSlip;
    setIsValid(isComplete);
    if (paymentSlip) {
      updateFormData("paymentSlip", paymentSlip);
    }
  }, [formData, paymentSlip, setIsValid, updateFormData]);

  const handleFileChange = (files) => {
    const file = files[0];
    if (
      file &&
      (file.type === "image/jpeg" ||
        file.type === "image/png" ||
        file.type === "application/pdf")
    ) {
      setPaymentSlip(file);
    } else {
      alert("Please upload a valid payment slip (JPEG, PNG, or PDF).");
      setPaymentSlip(null);
    }
  };

  const handleDragOver = (e) => {
    e.preventDefault();
    setDragActive(true);
  };

  const handleDragLeave = (e) => {
    e.preventDefault();
    setDragActive(false);
  };

  const handleDrop = (e) => {
    e.preventDefault();
    setDragActive(false);
    handleFileChange(e.dataTransfer.files);
  };

  const handleInputChange = (e) => {
    handleFileChange(e.target.files);
  };

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4 flex items-center">
        <FileText className="w-6 h-6 text-blue-500 mr-2" />
        Review Your Registration
      </h2>

      {loading && (
        <div className="flex items-center justify-center text-gray-600">
          <Loader className="w-6 h-6 animate-spin mr-2" />
          Loading package details...
        </div>
      )}

      {error && (
        <p className="text-red-500 text-sm mt-2">
          {error}. Package details may be incomplete.
        </p>
      )}

      {!loading && !error && (
        <div className="space-y-6">
          <StudentInfoCard formData={formData} />

          <SelectedCoursesCard formData={formData} />

          <SelectedPackageCard
            formData={formData}
            selectedPackage={selectedPackage}
            calculateTotalAmount={calculateTotalAmount}
            ADDITIONAL_SEAT_COST={ADDITIONAL_SEAT_COST}
          />

          <div className="bg-gray-50 p-4 rounded-lg">
            <h3 className="text-lg font-medium text-gray-800 flex items-center">
              <Upload className="w-5 h-5 text-green-500 mr-2" />
              Payment Slip
            </h3>
            <div
              className={`mt-2 border-2 border-dashed rounded-lg p-6 text-center ${
                dragActive ? "border-blue-500 bg-blue-50" : "border-gray-300"
              }`}
              onDragOver={handleDragOver}
              onDragLeave={handleDragLeave}
              onDrop={handleDrop}
            >
              {paymentSlip ? (
                <div>
                  <p className="text-gray-700">
                    Uploaded: <strong>{paymentSlip.name}</strong>
                  </p>
                  <button
                    onClick={() => setPaymentSlip(null)}
                    className="mt-2 text-red-500 hover:underline"
                  >
                    Remove
                  </button>
                </div>
              ) : (
                <div>
                  <Upload className="w-8 h-8 text-gray-400 mx-auto mb-2" />
                  <p className="text-gray-600">
                    Drag and drop your payment slip here, or
                  </p>
                  <label className="mt-2 inline-block cursor-pointer text-blue-500 hover:underline">
                    click to upload
                    <input
                      type="file"
                      accept="image/jpeg,image/png,application/pdf"
                      onChange={handleInputChange}
                      className="hidden"
                    />
                  </label>
                  <p className="text-sm text-gray-500 mt-1">
                    (Accepted: JPEG, PNG, PDF)
                  </p>
                </div>
              )}
            </div>
            {!paymentSlip && (
              <p className="text-red-500 text-sm mt-2">
                Please upload a payment slip to proceed.
              </p>
            )}
          </div>
        </div>
      )}
    </motion.div>
  );
}
