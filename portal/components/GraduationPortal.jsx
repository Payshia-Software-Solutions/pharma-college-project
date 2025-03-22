"use client";
import React from "react";

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
import { User, Book, Package, FileText, GraduationCap } from "lucide-react";

const steps = [
  { id: 1, title: "Student Info", icon: User },
  { id: 2, title: "Course", icon: Book },
  { id: 3, title: "Package", icon: Package },
  { id: 4, title: "Review & Submit", icon: FileText },
];

export default function ConvocationPortal() {
  const [currentStep, setCurrentStep] = useState(1);
  const [isLoading, setIsLoading] = useState(false);
  const [stepLoading, setStepLoading] = useState(false);
  const [showSuccess, setShowSuccess] = useState(false);
  const [referenceNumber, setReferenceNumber] = useState("");
  const [formData, setFormData] = useState({
    studentNumber: "",
    studentName: "",
    courses: [], // Changed from course: { id: "", title: "" }
    packageDetails: {
      parentSeatCount: 0,
      garland: false,
      graduationCloth: false,
      photoPackage: false,
    },
    package_id: null,
    paymentSlip: null,
  });
  const [isValid, setIsValid] = useState(false);
  const [splashLoading, setSplashLoading] = useState(true);
  const [packages, setPackages] = useState([]);

  // Fetch packages centrally
  useEffect(() => {
    const fetchPackages = async () => {
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/packages`
        );
        if (!response.ok) throw new Error("Failed to fetch packages");
        const data = await response.json();
        setPackages(
          data
            .map((pkg) => ({
              package_id: pkg.package_id,
              name: pkg.package_name,
              price: parseFloat(pkg.price),
              inclusions: {
                parentSeatCount: pkg.parent_seat_count,
                garland: !!pkg.garland,
                graduationCloth: !!pkg.graduation_cloth,
                photoPackage: !!pkg.photo_package,
              },
              isActive: !!pkg.is_active,
            }))
            .filter((pkg) => pkg.isActive)
        );
      } catch (err) {
        console.error(err);
      }
    };
    fetchPackages();
  }, []);

  useEffect(() => {
    const timer = setTimeout(() => setSplashLoading(false), 1500);
    return () => clearTimeout(timer);
  }, []);

  const updateFormData = (field, value) => {
    setFormData((prev) => ({
      ...prev,
      [field]: value,
    }));
  };

  const updatePackageData = (field, value) => {
    setFormData((prev) => ({
      ...prev,
      [field === "packageDetails" ? "packageDetails" : field]: value,
    }));
  };

  const navigateStep = (direction) => {
    if (direction === "next" && (!isValid || stepLoading)) return;
    setIsLoading(true);
    setTimeout(() => {
      setCurrentStep((prev) =>
        direction === "next"
          ? Math.min(prev + 1, steps.length)
          : Math.max(prev - 1, 1)
      );
      setIsLoading(false);
    }, 500);
  };

  const nextStep = () => navigateStep("next");
  const prevStep = () => navigateStep("prev");

  const handleSubmit = async () => {
    setIsLoading(true);
    setShowSuccess(false);

    if (
      !formData.studentNumber ||
      !formData.studentName ||
      formData.courses.length === 0 || // Changed from !formData.course.id
      !formData.package_id ||
      !formData.paymentSlip
    ) {
      alert(
        "Please complete all required fields, including the payment slip and at least one course."
      );
      setIsLoading(false);
      return;
    }

    try {
      const submissionData = new FormData();
      submissionData.append("student_number", formData.studentNumber);
      submissionData.append("student_name", formData.studentName); // Added for clarity
      formData.courses.forEach((course, index) => {
        submissionData.append(`course_id[${index}]`, course.id); // Append multiple course IDs
      });
      submissionData.append("package_id", formData.package_id);
      submissionData.append("payment_slip", formData.paymentSlip);

      const response = await fetch(
        `${process.env.NEXT_PUBLIC_API_URL}/convocation-registrations`,
        {
          method: "POST",
          body: submissionData,
        }
      );

      const responseBody = await response.json();

      if (!response.ok) {
        throw new Error(
          responseBody.error || "Registration failed. Please try again."
        );
      }

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
        loading={splashLoading}
        splashTitle="Convocation Registration Portal"
        icon={<GraduationCap className="w-16 h-16" />}
      />

      {!splashLoading && (
        <div className="h-screen lg:min-h-40 bg-gradient-to-br from-blue-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto pb-20">
          <Header currentStep={currentStep} prevStep={prevStep} steps={steps} />
          <div className="bg-white flex justify-center items-center flex-col w-full pt-4">
            <Image
              src="/logo.png"
              width={550}
              height={550}
              alt="Logo of Ceylon Pharma College"
              className="w-[30%]"
            />
            <p className="text-xl font-bold">Convocation Registration Portal</p>
          </div>
          <ProgressBar steps={steps} currentStep={currentStep} />
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
                      setStepLoading={setStepLoading}
                    />
                  )}
                  {currentStep === 2 && (
                    <CourseSelectionStep
                      formData={formData}
                      updateFormData={updateFormData}
                      setIsValid={setIsValid}
                      setStepLoading={setStepLoading}
                    />
                  )}
                  {currentStep === 3 && (
                    <PackageCustomizationStep
                      formData={formData}
                      updatePackageData={updatePackageData}
                      setIsValid={setIsValid}
                      setStepLoading={setStepLoading}
                      packages={packages}
                    />
                  )}
                  {currentStep === 4 && (
                    <ReviewStep
                      formData={formData}
                      setIsValid={setIsValid}
                      updateFormData={updateFormData}
                      packages={packages}
                    />
                  )}
                </>
              )}
            </AnimatePresence>
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
