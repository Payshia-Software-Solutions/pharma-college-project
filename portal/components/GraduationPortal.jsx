"use client";

import { useState, useEffect } from "react";
import Image from "next/image";
import { AnimatePresence } from "framer-motion";
import SplashScreen from "@/components/SplashScreen";
import Footer from "@/components/Footer";
import Header from "@/components/Graduation/Header";
import ProgressBar from "@/components/Graduation/ProgressBar";
import StudentInfoStep from "@/components/Graduation/StudentInfoStep";
import CourseSelectionStep from "@/components/Graduation/CourseSelectionStep";
import PackageCustomizationStep from "@/components/Graduation/PackageCustomizationStep";
import ReviewStep from "@/components/Graduation/ReviewStep";
import SuccessStep from "@/components/Graduation/SuccessStep";
import ActionButtons from "@/components/Graduation/ActionButtons";

// Define steps for the convocation registration process
const steps = [
  { id: 1, title: "Student Info", icon: "User" },
  { id: 2, title: "Course Selection", icon: "Book" },
  { id: 3, title: "Package Customization", icon: "Package" },
  { id: 4, title: "Review & Submit", icon: "FileText" },
];

export default function ConvocationPortal() {
  const [currentStep, setCurrentStep] = useState(1);
  const [isLoading, setIsLoading] = useState(false);
  const [showSuccess, setShowSuccess] = useState(false);
  const [referenceNumber, setReferenceNumber] = useState("");
  const [formData, setFormData] = useState({
    studentNumber: "",
    studentName: "",
    course: "",
    package: {
      parentSeatCount: 0,
      garland: false,
      graduationCloth: false,
      photoPackage: false,
    },
    package_id: "",
  });
  const [isValid, setIsValid] = useState(false);
  const [loading, setLoading] = useState(true);

  // Simulate splash screen for 1.5 seconds
  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 1500);
    return () => clearTimeout(timer);
  }, []);

  // Update form data
  const updateFormData = (field, value) => {
    setFormData((prev) => ({ ...prev, [field]: value }));
  };

  // Update package details
  const updatePackageData = (field, value) => {
    setFormData((prev) => ({
      ...prev,
      package: { ...prev.package, [field]: value },
    }));
  };

  // Navigate to the next step
  const nextStep = () => {
    if (!isValid) return;
    setIsLoading(true);
    setTimeout(() => {
      setCurrentStep((prev) => Math.min(prev + 1, 4));
      setIsLoading(false);
    }, 500);
  };

  // Navigate to the previous step
  const prevStep = () => setCurrentStep((prev) => Math.max(prev - 1, 1));

  // Handle form submission
  const handleSubmit = async () => {
    setIsLoading(true);
    setShowSuccess(false);

    // Validate required fields
    if (
      !formData.studentNumber ||
      !formData.studentName ||
      !formData.course?.id || // Check course.id since course is an object
      !formData.package || // Check if package object exists
      !selectedPackage?.package_id // Ensure selectedPackage has a package_id
    ) {
      alert("Please complete all required fields.");
      setIsLoading(false);
      return;
    }

    try {
      const response = await fetch(
        `${process.env.NEXT_PUBLIC_API_URL}/convocation-registrations`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            student_number: formData.studentNumber,
            course_id: formData.course.id,
            package_id: selectedPackage.package_id, // Use selectedPackage.package_id
          }),
        }
      );

      const responseBody = await response.json();

      if (!response.ok) {
        throw new Error(
          responseBody.error || "Registration failed. Please try again."
        );
      }

      // Set reference_number from response (matches backend return)
      setReferenceNumber(responseBody.reference_number);
      setShowSuccess(true);
    } catch (error) {
      alert(error.message);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <SplashScreen
        loading={loading}
        splashTitle={`Convocation Registration Portal`}
        icon={<div className="w-16 h-16" />}
      />

      {!loading && (
        <div className="h-screen lg:min-h-40 bg-gradient-to-br from-blue-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto pb-20">
          {/* Header */}
          <Header currentStep={currentStep} prevStep={prevStep} steps={steps} />

          {/* Logo */}
          <div className="bg-white flex justify-center items-center flex-col w-full pt-4">
            <Image
              src={`/logo.png`}
              width={550}
              alt="Logo of Ceylon Pharma College"
              height={550}
              className="w-[30%]"
            />
            <p className="text-xl font-bold">Convocation Registration Portal</p>
          </div>

          {/* Progress Bar */}
          <ProgressBar steps={steps} currentStep={currentStep} />

          {/* Main Content */}
          <main className="flex-1 p-4">
            <AnimatePresence mode="wait">
              {showSuccess ? (
                <SuccessStep referenceNumber={referenceNumber} />
              ) : (
                <>
                  {currentStep === 1 && (
                    <StudentInfoStep
                      formData={formData}
                      updateFormData={updateFormData}
                      setIsValid={setIsValid}
                    />
                  )}
                  {currentStep === 2 && (
                    <CourseSelectionStep
                      formData={formData}
                      updateFormData={updateFormData}
                      setIsValid={setIsValid}
                    />
                  )}
                  {currentStep === 3 && (
                    <PackageCustomizationStep
                      formData={formData}
                      updatePackageData={updatePackageData}
                      setIsValid={setIsValid}
                    />
                  )}
                  {currentStep === 4 && (
                    <ReviewStep formData={formData} setIsValid={setIsValid} />
                  )}
                </>
              )}
            </AnimatePresence>

            {/* Action Buttons */}
            <ActionButtons
              currentStep={currentStep}
              showSuccess={showSuccess}
              isValid={isValid}
              isLoading={isLoading}
              nextStep={nextStep}
              handleSubmit={handleSubmit}
            />
          </main>
        </div>
      )}

      <Footer />
    </div>
  );
}
