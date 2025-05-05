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
import CertificateDeliveryStep from "@/components/Graduation/CertificateDeliveryStep";
import AddressStep from "@/components/Graduation/AddressStep";

import { User, Book, Package, FileText, GraduationCap } from "lucide-react";

const steps = [
  { id: 1, title: "Student Info", icon: User },
  { id: 2, title: "Course", icon: Book },
  { id: 3, title: "Certificate Delivery", icon: GraduationCap }, // New step
  { id: 4, title: "Package", icon: Package },
  { id: 5, title: "Review & Submit", icon: FileText },
];

export default function ConvocationPortal() {
  const [currentStep, setCurrentStep] = useState(1);
  const [isLoading, setIsLoading] = useState(false);
  const [stepLoading, setStepLoading] = useState(false);
  const [showSuccess, setShowSuccess] = useState(false);
  const [referenceNumber, setReferenceNumber] = useState("");
  const [deliveryMethod, setDeliveryMethod] = useState(null); // For Convocation or Courier

  const [address, setAddress] = useState({
    line1: "",
    line2: "",
    city: "",
    district: "",
    phoneNumber: "",
  });

  const [formData, setFormData] = useState({
    studentNumber: "",
    studentName: "",
    courses: [],
    packageDetails: {
      parentSeatCount: 0,
      garland: false,
      graduationCloth: false,
      photoPackage: false,
      additionalSeats: null,
    },
    package_id: null,
    paymentSlip: null,
    session: null,
    deliveryMethod: null,
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
      (formData.deliveryMethod === "Convocation Ceremony" &&
        !formData.package_id) ||
      (formData.deliveryMethod === "Convocation Ceremony" &&
        !formData.paymentSlip) ||
      !formData.deliveryMethod ||
      (formData.deliveryMethod === "Convocation Ceremony" && !formData.session)
    ) {
      alert(
        "Please complete all required fields, including the payment slip and at least one course."
      );
      setIsLoading(false);
      return;
    }

    const submissionData = new FormData();
    submissionData.append("student_number", formData.studentNumber);
    submissionData.append("student_name", formData.studentName); // Added for clarity
    formData.courses.forEach((course, index) => {
      submissionData.append(`course_id[${index}]`, course.id); // Append multiple course IDs
    });
    submissionData.append("package_id", formData.package_id);
    submissionData.append("payment_slip", formData.paymentSlip);
    submissionData.append(
      "additional_seats",
      formData.packageDetails.additionalSeats
    );
    submissionData.append("deliveryMethod", formData.deliveryMethod);
    submissionData.append("session", formData.session);
    submissionData.append("address_line1", address.line1);
    submissionData.append("address_line2", address.line2 || ""); // Optional field
    submissionData.append("city_id", address.city);
    submissionData.append("district", address.district);
    submissionData.append("mobile", address.phoneNumber);
    submissionData.append("created_by", address.phoneNumber);
    submissionData.append("type", address.phoneNumber);
    submissionData.append("payment", address.phoneNumber);
    submissionData.append("package_id", address.phoneNumber);
    submissionData.append("certificate_id", address.phoneNumber);
    submissionData.append("certificate_status", address.phoneNumber);
    submissionData.append("course_code", address.phoneNumber);

    try {
      // Determine the correct API URL based on the delivery method
      const apiUrl =
        formData.deliveryMethod === "By Courier"
          ? `${process.env.NEXT_PUBLIC_API_URL}/certificate-orders`
          : `${process.env.NEXT_PUBLIC_API_URL}/convocation-registrations`;

      // Make the appropriate API call
      const response = await fetch(apiUrl, {
        method: "POST",
        body: submissionData,
      });

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
                <SuccessStep
                  referenceNumber={referenceNumber}
                  deliveryMethod={formData.deliveryMethod}
                />
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
                    <CertificateDeliveryStep
                      formData={formData}
                      setFormData={setFormData}
                      setIsValid={setIsValid}
                      setStepLoading={setStepLoading}
                    />
                  )}
                  {/* {alert(deliveryMethod)} */}
                  {currentStep === 4 &&
                    formData.deliveryMethod === "By Courier" && (
                      <AddressStep
                        address={address}
                        setAddress={setAddress}
                        setIsValid={setIsValid}
                      />
                    )}

                  {currentStep === 4 &&
                    formData.deliveryMethod !== "By Courier" && (
                      <PackageCustomizationStep
                        formData={formData}
                        updatePackageData={updatePackageData}
                        setIsValid={setIsValid}
                        setStepLoading={setStepLoading}
                        packages={packages}
                      />
                    )}
                  {currentStep === 5 && (
                    <ReviewStep
                      formData={formData}
                      setIsValid={setIsValid}
                      updateFormData={updateFormData}
                      packages={packages}
                      address={address}
                      deliveryMethod={deliveryMethod}
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
