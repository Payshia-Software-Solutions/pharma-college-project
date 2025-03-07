"use client";

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

export default function ReviewStep({
  formData,
  setIsValid,
  updateFormData,
  packages = [],
}) {
  const [loading] = useState(false); // No fetching here if packages are passed
  const [error] = useState(null);
  const [paymentSlip, setPaymentSlip] = useState(null); // Store uploaded file
  const [dragActive, setDragActive] = useState(false); // For drag-and-drop styling

  // Find the selected package based on formData.package_id
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
    },
  };

  // Validate all required fields, including payment slip
  useEffect(() => {
    const isComplete =
      formData.studentNumber &&
      formData.studentName &&
      formData.course?.id &&
      formData.package_id &&
      paymentSlip; // Require payment slip
    setIsValid(isComplete);
    if (paymentSlip) {
      updateFormData("paymentSlip", paymentSlip); // Update formData in parent
    }
  }, [formData, paymentSlip, setIsValid, updateFormData]);

  // Handle file drop or selection
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

  // Drag-and-drop handlers
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
          {/* Student Information */}
          <div className="bg-gray-50 p-4 rounded-lg">
            <h3 className="text-lg font-medium text-gray-800 flex items-center">
              <User className="w-5 h-5 text-green-500 mr-2" />
              Student Information
            </h3>
            <div className="mt-2 space-y-2 text-gray-700">
              <p className="flex items-center">
                <span className="w-5 h-5 mr-2">📍</span>
                <strong>Student Number:</strong>{" "}
                {formData.studentNumber || "Not Provided"}
              </p>
              <p className="flex items-center">
                <span className="w-5 h-5 mr-2">👤</span>
                <strong>Name:</strong> {formData.studentName || "Not Provided"}
              </p>
            </div>
          </div>

          {/* Course Selection */}
          <div className="bg-gray-50 p-4 rounded-lg">
            <h3 className="text-lg font-medium text-gray-800 flex items-center">
              <Book className="w-5 h-5 text-green-500 mr-2" />
              Selected Course
            </h3>
            <p className="mt-2 text-gray-700 flex items-center">
              <span className="w-5 h-5 mr-2">📚</span>
              {formData.course?.title || "Not Selected"}
            </p>
          </div>

          {/* Package Details */}
          <div className="bg-gray-50 p-4 rounded-lg">
            <h3 className="text-lg font-medium text-gray-800 flex items-center">
              <PackageIcon className="w-5 h-5 text-green-500 mr-2" />
              Selected Package
            </h3>
            <div className="mt-2 space-y-2 text-gray-700">
              <p className="flex items-center">
                <span className="w-5 h-5 mr-2">🎁</span>
                <strong>Package:</strong> {selectedPackage.name}
              </p>
              <p className="flex items-center">
                <DollarSign className="w-5 h-5 text-blue-500 mr-2" />
                <strong>Price:</strong> ${selectedPackage.price.toFixed(2)}
              </p>
              <div className="mt-2">
                <p className="font-medium text-gray-700">Inclusions:</p>
                <ul className="mt-1 space-y-1 text-gray-600">
                  <li className="flex items-center">
                    <Users className="w-4 h-4 text-gray-500 mr-2" />
                    Parent Seats: {selectedPackage.inclusions.parentSeatCount}
                  </li>
                  <li className="flex items-center">
                    <Flower className="w-4 h-4 text-gray-500 mr-2" />
                    Garland: {selectedPackage.inclusions.garland ? "Yes" : "No"}
                  </li>
                  <li className="flex items-center">
                    <GraduationCap className="w-4 h-4 text-gray-500 mr-2" />
                    Graduation Cloth:{" "}
                    {selectedPackage.inclusions.graduationCloth ? "Yes" : "No"}
                  </li>
                  <li className="flex items-center">
                    <Camera className="w-4 h-4 text-gray-500 mr-2" />
                    Photo Package:{" "}
                    {selectedPackage.inclusions.photoPackage ? "Yes" : "No"}
                  </li>
                </ul>
              </div>
            </div>
          </div>

          {/* Payment Slip Upload */}
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
