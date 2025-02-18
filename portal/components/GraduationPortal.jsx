"use client";

import { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import {
  GraduationCap,
  Package,
  ClipboardList,
  CheckCircle,
} from "lucide-react";
import SplashScreen from "./SplashScreen";
import Footer from "./Footer";

const steps = [
  { id: 1, title: "Enter Student Number", icon: GraduationCap },
  { id: 2, title: "Eligibility Result", icon: CheckCircle },
  { id: 3, title: "Package Selection", icon: Package },
  { id: 4, title: "Review & Submit", icon: ClipboardList },
];

export default function GraduationApplication() {
  const [currentStep, setCurrentStep] = useState(1);
  const [isLoading, setIsLoading] = useState(false);
  const [showSuccess, setShowSuccess] = useState(false);
  const [eligibilityStatus, setEligibilityStatus] = useState(null);
  const [completionRates, setCompletionRates] = useState(null);
  const [formData, setFormData] = useState({
    studentNumber: "",
    selectedPackage: null,
  });

  const packages = [
    {
      id: 1,
      name: "Basic Package",
      price: 150,
      includes: ["Gown Rental", "Certificate Holder"],
    },
    {
      id: 2,
      name: "Standard Package",
      price: 250,
      includes: ["Gown Rental", "Professional Photos", "Souvenir"],
    },
    {
      id: 3,
      name: "Premium Package",
      price: 400,
      includes: ["Custom Gown", "Full Photo Package", "VIP Seating"],
    },
  ];

  const updateFormData = (field, value) =>
    setFormData((prev) => ({ ...prev, [field]: value }));

  const nextStep = () => setCurrentStep((prev) => Math.min(prev + 1, 4));
  const prevStep = () => setCurrentStep((prev) => Math.max(prev - 1, 1));

  const checkEligibility = async () => {
    // setIsLoading(true);
    try {
      // const response = await fetch(
      //   `/api/eligibility/${formData.studentNumber}`
      // );
      // if (!response.ok) throw new Error("Failed to fetch data");

      // const data = await response.json();
      const data = {
        eligible: true,
        completionRates: 100, // Adjust as needed
      };

      if (data.eligible !== undefined) {
        setEligibilityStatus(data.eligible);
        setCompletionRates(data.completionRates);
        nextStep(); // Move to the next step only if data is valid
      } else {
        alert("Invalid response from server");
      }
    } catch {
      alert("Error checking eligibility");
    } finally {
      setIsLoading(false);
    }
  };

  const handleSubmit = async () => {
    setIsLoading(true);
    try {
      const response = await fetch("/api/graduation-application", {
        method: "POST",
        body: JSON.stringify(formData),
      });
      if (response.ok) {
        setShowSuccess(true);
      }
    } catch {
      alert("Submission failed");
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="flex flex-col items-center h-screen">
      <SplashScreen
        loading={isLoading}
        splashTitle="Graduation Application Portal"
        icon={<GraduationCap className="w-16 h-16" />}
      />
      <div className="w-full lg:w-1/2 bg-white shadow-lg rounded-lg p-6 mt-4">
        <AnimatePresence mode="wait">
          <motion.div
            key={currentStep}
            initial={{ opacity: 0, x: 50 }}
            animate={{ opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: -50 }}
            transition={{ duration: 0.3 }}
          >
            {showSuccess ? (
              <div className="text-center p-8">
                <CheckCircle className="w-16 h-16 text-green-500 mx-auto" />
                <h2 className="text-2xl font-bold mt-4">
                  Application Submitted!
                </h2>
                <p className="mt-4">
                  Your graduation package application has been received.
                </p>
              </div>
            ) : (
              <>
                {currentStep === 1 && (
                  <div>
                    <h3 className="text-xl font-semibold">
                      Enter Student Number
                    </h3>
                    <input
                      type="text"
                      placeholder="Enter Student Number"
                      className="w-full p-3 border rounded-lg mt-2"
                      value={formData.studentNumber}
                      onChange={(e) =>
                        updateFormData("studentNumber", e.target.value)
                      }
                    />
                    <button
                      onClick={checkEligibility}
                      disabled={!formData.studentNumber || isLoading}
                      className="w-full bg-blue-600 text-white p-3 rounded-lg mt-4"
                    >
                      {isLoading ? "Checking..." : "Check Eligibility"}
                    </button>
                  </div>
                )}
                {currentStep === 2 && (
                  <div>
                    <h3 className="text-xl font-semibold">
                      Eligibility Result
                    </h3>
                    {eligibilityStatus ? (
                      <p className="text-green-500">Eligible for graduation</p>
                    ) : (
                      <p className="text-red-500">
                        Not eligible for graduation
                      </p>
                    )}
                    {completionRates && (
                      <div className="mt-4 bg-gray-100 p-3 rounded-lg">
                        <h4 className="font-semibold">Completion Rates:</h4>
                        <p>
                          Ceylon Pharmacy: {completionRates.ceylonPharmacy}%
                        </p>
                        <p>Pharma Hunter: {completionRates.pharmaHunter}%</p>
                        <p>Due Balance: {completionRates.dueBalance}%</p>
                      </div>
                    )}
                    <div className="flex justify-between mt-4">
                      <button
                        onClick={prevStep}
                        className="bg-gray-400 text-white p-3 rounded-lg"
                      >
                        Back
                      </button>
                      <button
                        onClick={nextStep}
                        disabled={!eligibilityStatus}
                        className="bg-blue-600 text-white p-3 rounded-lg"
                      >
                        Continue
                      </button>
                    </div>
                  </div>
                )}
                {currentStep === 3 && (
                  <div>
                    <h3 className="text-xl font-semibold">
                      Select Your Package
                    </h3>
                    {packages.map((pkg) => (
                      <div
                        key={pkg.id}
                        className="p-4 border rounded-lg mt-2"
                        onClick={() => updateFormData("selectedPackage", pkg)}
                      >
                        <h4 className="font-semibold">{pkg.name}</h4>
                        <p>${pkg.price}</p>
                      </div>
                    ))}
                    <div className="flex justify-between mt-4">
                      <button
                        onClick={prevStep}
                        className="bg-gray-400 text-white p-3 rounded-lg"
                      >
                        Back
                      </button>
                      <button
                        onClick={nextStep}
                        disabled={!formData.selectedPackage}
                        className="bg-blue-600 text-white p-3 rounded-lg"
                      >
                        Continue
                      </button>
                    </div>
                  </div>
                )}
                {currentStep === 4 && (
                  <div>
                    <h3 className="text-xl font-semibold">Review & Submit</h3>
                    <p>
                      <strong>Student Number:</strong> {formData.studentNumber}
                    </p>
                    <p>
                      <strong>Package:</strong> {formData.selectedPackage?.name}
                    </p>
                    <button
                      onClick={prevStep}
                      className="bg-gray-400 text-white p-3 rounded-lg mt-4"
                    >
                      Back
                    </button>
                    <button
                      onClick={handleSubmit}
                      className="w-full bg-green-600 text-white p-3 rounded-lg mt-4"
                    >
                      Submit
                    </button>
                  </div>
                )}
              </>
            )}
          </motion.div>
        </AnimatePresence>
      </div>
    </div>
  );
}
