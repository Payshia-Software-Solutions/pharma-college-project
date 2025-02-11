"use client";
import React, { useState } from "react";
import {
  ArrowLeft,
  UserCircle,
  Phone,
  CheckCircle,
  Calendar,
} from "lucide-react";
import { Card, CardContent } from "@/components/ui/card";
import { motion, AnimatePresence } from "framer-motion";

const RegisterForm = () => {
  const [currentStep, setCurrentStep] = useState(1);
  const [formData, setFormData] = useState({
    title: "Mr.",
    firstName: "",
    lastName: "",
    fullName: "",
    nameWithInitials: "",
    nameOnCertificate: "",
    gender: "",
    nicNumber: "",
    dateOfBirth: "",
    course: "",
    email: "",
    phone: "",
    whatsapp: "",
    addressLine1: "",
    addressLine2: "",
    city: "",
  });

  const [errors, setErrors] = useState({});

  const titles = ["Mr.", "Mrs.", "Miss", "Rev.", "Dr."];
  const genders = ["Male", "Female", "Other"];
  const courses = ["Course 1", "Course 2", "Course 3"];
  const cities = ["Colombo", "Kandy", "Galle", "Jaffna"];

  const steps = [
    { id: 1, title: "Basic Details", icon: UserCircle },
    { id: 2, title: "Contact Info", icon: Phone },
    { id: 3, title: "Review", icon: CheckCircle },
  ];

  const validateStep = (step) => {
    const newErrors = {};

    if (step === 1) {
      if (!formData.firstName.trim())
        newErrors.firstName = "First name is required";
      if (!formData.lastName.trim())
        newErrors.lastName = "Last name is required";
      if (!formData.fullName.trim())
        newErrors.fullName = "Full name is required";
      if (!formData.nameWithInitials.trim())
        newErrors.nameWithInitials = "Name with initials is required";
      if (!formData.nameOnCertificate.trim())
        newErrors.nameOnCertificate = "Certificate name is required";
      if (!formData.gender) newErrors.gender = "Gender is required";
      if (!formData.nicNumber.trim())
        newErrors.nicNumber = "NIC number is required";
      if (!formData.dateOfBirth)
        newErrors.dateOfBirth = "Date of birth is required";
      if (!formData.course) newErrors.course = "Course selection is required";
    }

    if (step === 2) {
      if (!formData.phone.trim()) newErrors.phone = "Phone number is required";
      if (!formData.whatsapp.trim())
        newErrors.whatsapp = "WhatsApp number is required";
      if (!formData.addressLine1.trim())
        newErrors.addressLine1 = "Address line 1 is required";
      if (!formData.city) newErrors.city = "City is required";

      // Phone number validation
      const phoneRegex = /^[0-9]{10}$/;
      if (formData.phone && !phoneRegex.test(formData.phone)) {
        newErrors.phone = "Invalid phone number format";
      }
      if (formData.whatsapp && !phoneRegex.test(formData.whatsapp)) {
        newErrors.whatsapp = "Invalid WhatsApp number format";
      }
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
    // Clear error when user starts typing
    if (errors[name]) {
      setErrors((prev) => ({
        ...prev,
        [name]: "",
      }));
    }
  };

  const nextStep = () => {
    if (validateStep(currentStep)) {
      setCurrentStep((prev) => Math.min(prev + 1, steps.length));
    }
  };

  const prevStep = () => setCurrentStep((prev) => Math.max(prev - 1, 1));

  const handleSubmit = (e) => {
    e.preventDefault();
    if (currentStep < steps.length) {
      nextStep();
    } else if (validateStep(currentStep)) {
      console.log("Form submitted:", formData);
      // Add your submission logic here
    }
  };

  const InputField = ({
    label,
    name,
    type = "text",
    value,
    placeholder,
    options = null,
  }) => (
    <div className="space-y-1">
      <input
        id={name} // Added id attribute
        type={type}
        name={name}
        placeholder={placeholder}
        value={value}
        onChange={handleChange}
        className={`w-full p-2 border rounded-lg ${
          errors[name] ? "border-red-500" : "border-gray-200"
        }`}
      />
      {errors[name] && <p className="text-red-500 text-xs">{errors[name]}</p>}
    </div>
  );

  const SelectField = ({ name, value, options, placeholder }) => (
    <div className="space-y-1">
      <select
        id={name} // Added id attribute
        name={name}
        value={value}
        onChange={handleChange}
        className={`w-full p-2 border rounded-lg ${
          errors[name] ? "border-red-500" : "border-gray-200"
        }`}
      >
        <option value="">{placeholder}</option>
        {options.map((option) => (
          <option key={option} value={option}>
            {option}
          </option>
        ))}
      </select>
      {errors[name] && <p className="text-red-500 text-xs">{errors[name]}</p>}
    </div>
  );

  const BasicInformationStep = () => (
    <div className="space-y-4">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="flex gap-4">
          <div className="flex-1">
            <label
              htmlFor="title"
              className="block text-sm font-medium text-gray-700 mb-1"
            >
              Title
            </label>
            <SelectField
              name="title"
              value={formData.title}
              options={titles}
              placeholder="Title"
            />
          </div>
          <div className="flex-1">
            <label
              htmlFor="firstName"
              className="block text-sm font-medium text-gray-700 mb-1"
            >
              First Name
            </label>
            <InputField
              name="firstName"
              value={formData.firstName}
              placeholder="First Name (මුල් නම)"
            />
          </div>
        </div>
        <div>
          <label
            htmlFor="lastName"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            Last Name
          </label>
          <InputField
            name="lastName"
            value={formData.lastName}
            placeholder="Last Name (අග නම)"
          />
        </div>
      </div>

      <div>
        <label
          htmlFor="fullName"
          className="block text-sm font-medium text-gray-700 mb-1"
        >
          Full Name
        </label>
        <InputField
          name="fullName"
          value={formData.fullName}
          placeholder="Full Name (සම්පූර්ණ නම)"
        />
      </div>

      <div>
        <label
          htmlFor="nameWithInitials"
          className="block text-sm font-medium text-gray-700 mb-1"
        >
          Name with Initials
        </label>
        <InputField
          name="nameWithInitials"
          value={formData.nameWithInitials}
          placeholder="Name with Initials (මුලකුරු සමඟ නම)"
        />
      </div>

      <div>
        <label
          htmlFor="nameOnCertificate"
          className="block text-sm font-medium text-gray-700 mb-1"
        >
          Certificate Name
        </label>
        <InputField
          name="nameOnCertificate"
          value={formData.nameOnCertificate}
          placeholder="Name On Certificate (සහතිකයේ සඳහන් විය යුතු නම)"
        />
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label
            htmlFor="gender"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            Gender
          </label>
          <SelectField
            name="gender"
            value={formData.gender}
            options={genders}
            placeholder="Gender (ස්ත්‍රී පුරුෂ භාවය)"
          />
        </div>
        <div>
          <label
            htmlFor="nicNumber"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            NIC Number
          </label>
          <InputField
            name="nicNumber"
            value={formData.nicNumber}
            placeholder="NIC Number (හැඳුනුම්පත් අංකය)"
          />
        </div>
      </div>

      <div>
        <label
          htmlFor="dateOfBirth"
          className="block text-sm font-medium text-gray-700 mb-1"
        >
          Date of Birth
        </label>
        <InputField
          type="date"
          name="dateOfBirth"
          value={formData.dateOfBirth}
          placeholder="Date of Birth (උපන් දිනය)"
        />
      </div>

      <div>
        <label
          htmlFor="course"
          className="block text-sm font-medium text-gray-700 mb-1"
        >
          Course
        </label>
        <SelectField
          name="course"
          value={formData.course}
          options={courses}
          placeholder="Select the Course (ඩිප්ලෝමා වැඩ පාඨමාලාව)"
        />
      </div>
    </div>
  );

  const ContactInformationStep = () => (
    <div className="space-y-4">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label
            htmlFor="phone"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            Phone Number
          </label>
          <InputField
            type="tel"
            name="phone"
            value={formData.phone}
            placeholder="Phone Number (දුරකථන අංකය)"
          />
        </div>
        <div>
          <label
            htmlFor="whatsapp"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            WhatsApp Number
          </label>
          <InputField
            type="tel"
            name="whatsapp"
            value={formData.whatsapp}
            placeholder="WhatsApp Number (වට්ස්ඇප් අංකය)"
          />
        </div>
      </div>

      <div>
        <label
          htmlFor="addressLine1"
          className="block text-sm font-medium text-gray-700 mb-1"
        >
          Address Line 1
        </label>
        <InputField
          name="addressLine1"
          value={formData.addressLine1}
          placeholder="Address Line 1 (ලිපිනයේ පළමු පේළිය)"
        />
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label
            htmlFor="addressLine2"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            Address Line 2
          </label>
          <InputField
            name="addressLine2"
            value={formData.addressLine2}
            placeholder="Address Line 2 (ලිපිනයේ දෙවන පේළිය)"
          />
        </div>
        <div>
          <label
            htmlFor="city"
            className="block text-sm font-medium text-gray-700 mb-1"
          >
            City
          </label>
          <SelectField
            name="city"
            value={formData.city}
            options={cities}
            placeholder="Choose City (නගරය තෝරන්න)"
          />
        </div>
      </div>
    </div>
  );

  const ReviewStep = () => (
    <div className="space-y-4">
      <div className="space-y-2">
        <h3 className="font-semibold">Basic Information</h3>
        <div className="grid grid-cols-2 gap-2 text-sm">
          <p>Name: </p>
          <p>
            {formData.title} {formData.firstName} {formData.lastName}
          </p>
          <p>Full Name: </p>
          <p>{formData.fullName}</p>
          <p>Name with Initials: </p>
          <p>{formData.nameWithInitials}</p>
          <p>Certificate Name: </p>
          <p>{formData.nameOnCertificate}</p>
          <p>Gender: </p>
          <p>{formData.gender}</p>
          <p>NIC: </p>
          <p>{formData.nicNumber}</p>
          <p>Date of Birth: </p>
          <p>{formData.dateOfBirth}</p>
          <p>Course: </p>
          <p>{formData.course}</p>
        </div>
      </div>

      <div className="space-y-2">
        <h3 className="font-semibold">Contact Information</h3>
        <div className="grid grid-cols-2 gap-2 text-sm">
          <p>Phone: </p>
          <p>{formData.phone}</p>
          <p>WhatsApp: </p>
          <p>{formData.whatsapp}</p>
          <p>Address: </p>
          <p>
            {formData.addressLine1}, {formData.addressLine2}
          </p>
          <p>City: </p>
          <p>{formData.city}</p>
        </div>
      </div>
    </div>
  );

  return (
    <div className="h-screen lg:min-h-40 bg-gradient-to-br from-green-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto">
      {/* Header */}
      <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
        <button
          onClick={() => window.history.back()}
          className="p-2 hover:bg-gray-100 rounded-full transition-colors"
        >
          <ArrowLeft className="w-6 h-6" />
        </button>
        <div className="flex items-center ml-2">
          <UserCircle className="w-6 h-6 text-green-500 mr-2" />
          <h1 className="text-lg font-semibold">Registration Form</h1>
        </div>
      </header>

      {/* Progress Bar */}
      <div className="bg-white px-4 py-6">
        <div className="flex justify-between items-center relative">
          {steps.map((step, idx) => (
            <div
              key={step.id}
              className="relative flex flex-1 flex-col items-center"
            >
              {idx < steps.length - 1 && (
                <div className="absolute top-5 left-1/2 w-full h-1 -z-10">
                  <div
                    className="h-full bg-gray-200 rounded"
                    style={{
                      background: `linear-gradient(to right, #22C55E ${
                        currentStep > step.id ? "100%" : "0%"
                      }, #E5E7EB ${currentStep > step.id ? "0%" : "100%"})`,
                    }}
                  />
                </div>
              )}
              <div
                className={`
                  w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300
                  ${
                    currentStep >= step.id
                      ? "bg-green-500 text-white"
                      : "bg-gray-200 text-gray-500"
                  }
                `}
              >
                <step.icon className="w-5 h-5" />
              </div>
              <span
                className={`mt-2 text-xs font-medium
                  ${currentStep >= step.id ? "text-green-500" : "text-gray-500"}
                `}
              >
                {step.title}
              </span>
            </div>
          ))}
        </div>
      </div>

      <form onSubmit={handleSubmit} className="flex-1 p-4">
        <Card className="bg-white rounded-xl shadow-lg">
          <CardContent className="p-6 space-y-6">
            <AnimatePresence mode="wait">
              <motion.div
                key={currentStep}
                initial={{ opacity: 0, x: 50 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -50 }}
                transition={{ duration: 0.3 }}
              >
                {currentStep === 1 && <BasicInformationStep />}
                {currentStep === 2 && <ContactInformationStep />}
                {currentStep === 3 && <ReviewStep />}
              </motion.div>
            </AnimatePresence>

            <div className="flex gap-4">
              {currentStep > 1 && (
                <button
                  type="button"
                  onClick={prevStep}
                  className="flex-1 bg-gray-100 text-gray-700 p-4 rounded-lg hover:bg-gray-200 transition-colors"
                >
                  Previous
                </button>
              )}
              <button
                type="submit"
                className="flex-1 bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors"
              >
                {currentStep === steps.length ? "Submit" : "Next"}
              </button>
            </div>
          </CardContent>
        </Card>
      </form>
    </div>
  );
};

export default RegisterForm;
