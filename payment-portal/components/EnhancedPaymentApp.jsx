"use client";

import { useState, useEffect } from "react";

import Image from "next/image";
import {
  ArrowLeft,
  Upload,
  CheckCircle,
  CreditCard,
  Building2,
  FileText,
  User,
  DollarSign,
} from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";
import StudentInfo from "./formElements/StudentInfo";
import PaymentInfo from "./formElements/PaymentInfo";
import BankInfo from "./formElements/BankInfo";
import ReviewPage from "./formElements/ReviewPage";
import SplashScreen from "./SplashScreen";
import PaymentSuccess from "./PaymentSuccess";
import Footer from "./Footer";

const steps = [
  { id: 1, title: "Student Info", icon: User },
  { id: 2, title: "Payment", icon: CreditCard },
  { id: 3, title: "Bank Details", icon: Building2 },
  { id: 4, title: "Review", icon: FileText },
];

export default function EnhancedPaymentApp() {
  const [currentStep, setCurrentStep] = useState(1);
  const [isLoading, setIsLoading] = useState(false);
  const [showSuccess, setShowSuccess] = useState(false);
  const [formData, setFormData] = useState({
    studentNumber: "",
    paymentReason: "",
    amount: "",
    reference: "",
    bank: "",
    branch: "",
    slip: null,
  });

  const [isValid, setIsValid] = useState(false); // Track if the current step is valid
  const [paymentReferenceNumber, setPaymentReferenceNumber] = useState("");

  const updateFormData = (field, value) => {
    setFormData((prev) => ({ ...prev, [field]: value }));
  };

  const nextStep = () => {
    if (!isValid) return; // Prevent step change if input is invalid

    setIsLoading(true);
    setTimeout(() => {
      setCurrentStep((prev) => Math.min(prev + 1, 4));
      setIsLoading(false);
    }, 500);
  };

  const prevStep = () => setCurrentStep((prev) => Math.max(prev - 1, 1));

  // const handleSubmit = async () => {
  //   setIsLoading(true);
  //   setShowSuccess(false);

  //   // Validate required fields
  //   if (
  //     !formData.studentNumber ||
  //     !formData.paymentReason ||
  //     !formData.amount ||
  //     !formData.reference ||
  //     !formData.bank ||
  //     !formData.branch ||
  //     !formData.slip
  //   ) {
  //     alert("Please complete all fields, including the payment slip.");
  //     setIsLoading(false);
  //     return;
  //   }

  //   try {
  //     const formDataToSend = new FormData();
  //     formDataToSend.append("studentNumber", formData.studentNumber);
  //     formDataToSend.append("paymentReason", formData.paymentReason);
  //     formDataToSend.append("amount", formData.amount);
  //     formDataToSend.append("reference", formData.reference);
  //     formDataToSend.append("bank", formData.bank);
  //     formDataToSend.append("branch", formData.branch);
  //     formDataToSend.append("slip", formData.slip); // File upload

  //     const response = await fetch("https://api.pharmacollege.lk/payment", {
  //       method: "POST",
  //       body: formDataToSend, // Sending as FormData
  //     });

  //     if (!response.ok) {
  //       throw new Error("Payment submission failed. Please try again.");
  //     }

  //     // Success - Show PaymentSuccess
  //     setShowSuccess(true);
  //   } catch (error) {
  //     alert(error.message);
  //   } finally {
  //     setIsLoading(false);
  //   }
  // };

  const handleSubmit = async () => {
    setIsLoading(true);
    setShowSuccess(false);

    // Collect missing fields
    let missingFields = [];

    if (!formData.studentNumber) missingFields.push("Student Number");
    if (!formData.paymentReason) missingFields.push("Payment Reason");
    if (!formData.amount) missingFields.push("Amount");
    if (!formData.reference) missingFields.push("Reference");
    if (!formData.bank) missingFields.push("Bank");
    if (!formData.branch) missingFields.push("Branch");
    if (!formData.slip) missingFields.push("Payment Slip");

    // If any fields are missing, show alert and return
    if (missingFields.length > 0) {
      alert(
        `Please complete the following fields:\n- ${missingFields.join("\n- ")}`
      );
      setIsLoading(false);
      return;
    }

    try {
      // Simulate API request with a delay
      await new Promise((resolve) => setTimeout(resolve, 2000)); // 2-second delay

      // Simulated response
      const mockResponse = {
        success: true,
        message: "Payment recorded successfully!",
        reference: 4654321,
      };

      setPaymentReferenceNumber(mockResponse.reference);

      if (!mockResponse.success) {
        throw new Error("Payment submission failed. Please try again.");
      }

      // Success - Show PaymentSuccess
      setShowSuccess(true);
    } catch (error) {
      alert(error.message);
    } finally {
      setIsLoading(false);
    }
  };

  const StepIcon = steps[currentStep - 1].icon;

  const [loading, setLoading] = useState(true); // Splash screen state

  // Simulate splash screen for 2.5 seconds
  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 2500);
    return () => clearTimeout(timer);
  }, []);

  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <SplashScreen loading={loading} />

      {/* ✅ Main Payment Portal (Visible after splash) */}
      {!loading && (
        <div className="h-screen lg:min-h-40 bg-gradient-to-br from-green-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto">
          {/* Header */}
          <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
            {currentStep > 1 && (
              <button
                onClick={prevStep}
                className="p-2 hover:bg-gray-100 rounded-full transition-colors"
              >
                <ArrowLeft className="w-6 h-6" />
              </button>
            )}
            <div className="flex items-center ml-2">
              <StepIcon className="w-6 h-6 text-green-500 mr-2" />
              <h1 className="text-lg font-semibold">
                {steps[currentStep - 1].title}
              </h1>
            </div>
          </header>

          {/* Logo */}
          <div className="bg-white flex justify-center items-center flex-col w-full pt-4">
            <Image
              src={`/logo.png`}
              width={550}
              alt="Logo of Ceylon Pharma College"
              height={550}
              className="w-[30%] "
            ></Image>
            <p className="text-3xl font-bold">Payment Portal</p>
          </div>

          {/* Progress Bar */}
          <div className="bg-white px-4 py-6 md:shadow-none shadow-lg">
            <div className="flex justify-between items-center relative">
              {steps.map((step, idx) => (
                <div
                  key={step.id}
                  className="relative flex flex-1 flex-col items-center"
                >
                  {/* Connector */}
                  {idx < steps.length - 1 && (
                    <div className="absolute top-5 left-1/2 w-full h-1 -z-10">
                      <div
                        className="h-full bg-gray-200 rounded"
                        style={{
                          background: `linear-gradient(to right, #3B82F6 ${
                            currentStep > step.id ? "100%" : "0%"
                          }, #E5E7EB ${currentStep > step.id ? "0%" : "100%"})`,
                        }}
                      />
                    </div>
                  )}
                  {/* Step Icon */}
                  <motion.div
                    className={`
                w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 z-10
                ${
                  currentStep >= step.id
                    ? "bg-green-500 text-white scale-110"
                    : "bg-gray-200 text-gray-500"
                }
              `}
                    whileHover={{ scale: 1.1 }}
                  >
                    <step.icon className="w-5 h-5" />
                  </motion.div>
                  {/* Step Title */}
                  <span
                    className={`mt-2 text-xs font-medium transition-colors duration-300 text-center
                ${currentStep >= step.id ? "text-green-500" : "text-gray-500"}
              `}
                  >
                    {step.title}
                  </span>
                </div>
              ))}
            </div>
          </div>

          {/* Main Content */}
          <main className="flex-1 p-4">
            <AnimatePresence mode="wait">
              <motion.div
                key={currentStep}
                initial={{ opacity: 0, x: 50 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -50 }}
                transition={{ duration: 0.3 }}
                className="bg-white rounded-xl shadow-lg p-6 space-y-6"
              >
                {showSuccess ? (
                  <PaymentSuccess
                    paymentReference={paymentReferenceNumber}
                    amount={formData.amount}
                    date={new Date().toISOString()}
                    method="Credit Card"
                  />
                ) : (
                  <>
                    {currentStep === 1 && (
                      <StudentInfo
                        formData={formData}
                        updateFormData={updateFormData}
                        setIsValid={setIsValid}
                      />
                    )}

                    {currentStep === 2 && (
                      <PaymentInfo
                        formData={formData}
                        updateFormData={updateFormData}
                        setIsValid={setIsValid}
                      />
                    )}

                    {currentStep === 3 && (
                      <BankInfo
                        formData={formData}
                        updateFormData={updateFormData}
                        setIsValid={setIsValid}
                      />
                    )}

                    {currentStep === 4 && (
                      <ReviewPage
                        formData={formData}
                        updateFormData={updateFormData}
                        setIsValid={setIsValid}
                      />
                    )}
                  </>
                )}

                {/* Action Buttons */}
                <div className="">
                  {/* Show "Continue" button for steps before review, unless success is shown */}
                  {currentStep < 4 && !showSuccess ? (
                    <button
                      onClick={nextStep}
                      disabled={!isValid || isLoading}
                      className="w-full bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200 disabled:opacity-50 flex items-center justify-center space-x-2"
                    >
                      {isLoading ? (
                        <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin" />
                      ) : (
                        <>
                          <span>Continue</span>
                          <ArrowLeft className="w-5 h-5 transform rotate-180" />
                        </>
                      )}
                    </button>
                  ) : null}

                  {/* Show "Submit Payment" button only on the Review page if payment is not successful */}
                  {currentStep === 4 && !showSuccess && (
                    <button
                      onClick={handleSubmit}
                      disabled={!isValid || isLoading}
                      className="w-full bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200 disabled:opacity-50 flex items-center justify-center space-x-2"
                    >
                      {isLoading ? (
                        <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin" />
                      ) : (
                        <>
                          <span>Submit Payment</span>
                          <CheckCircle className="w-5 h-5" />
                        </>
                      )}
                    </button>
                  )}

                  {/* Show "Go to Home" button if payment is successful */}
                  {showSuccess && (
                    <button
                      onClick={() => (window.location.href = "/")} // Or use Next.js routing for better navigation
                      className="w-full bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-blue-200 disabled:opacity-50 flex items-center justify-center space-x-2"
                    >
                      <span>Go to Back</span>
                    </button>
                  )}
                </div>
              </motion.div>
            </AnimatePresence>
          </main>
        </div>
      )}

      <Footer />
    </div>
  );
}
