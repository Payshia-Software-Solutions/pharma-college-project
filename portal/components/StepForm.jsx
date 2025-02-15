"use client";

import { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { useFormStore } from "../store/formStore";
import { ArrowRight, ArrowLeft, CheckCircle, User } from "lucide-react"; // Import icons from lucide-react
// Import icons from lucid-react-icons

import axios from "axios";
import Link from "next/link";
import RegistrationSplashScreen from "./RegistrationSplashScreen";
import { motion, AnimatePresence } from "framer-motion";

// Course List
const courses = [
  { id: "web_dev", name: "Web Development" },
  { id: "data_sci", name: "Data Science" },
  { id: "mobile_dev", name: "Mobile Development" },
];

// Form Validation Schemas
const formSchema = [
  z.object({
    firstName: z.string().min(2, "First name is required"),
    lastName: z.string().min(2, "Last name is required"),
    civilStatus: z.enum(["Mr", "Mrs", "Miss", "Dr"]).optional(),
    nameWithInitials: z.string().min(2, "Required"),
    certificateName: z.string().min(2, "Required"),
  }),
  z.object({
    address: z.string().min(2, "Required"),
    city: z.string().min(2, "Required"),
  }),
  z.object({
    gender: z.enum(["Male", "Female", "Other"]),
    nic: z.string().min(10, "NIC is required"),
    dob: z.string(),
  }),
  z.object({
    phone: z.string().min(10, "Enter a valid phone number"),
    email: z.string().email("Enter a valid email"),
    whatsapp: z.string().optional(),
  }),
  z.object({
    course: z.string().min(2, "Select a course"),
  }),
];

export default function StepForm() {
  const { step, nextStep, prevStep, updateForm, formData, resetForm } =
    useFormStore();
  const [refNumber, setRefNumber] = useState(null);

  const {
    register,
    handleSubmit,
    watch,
    formState: { errors },
  } = useForm({
    resolver: zodResolver(formSchema[step - 1]),
    defaultValues: formData,
  });

  const onSubmit = async (data) => {
    updateForm(data);
    if (step < 5) {
      nextStep();
    } else {
      setLoading(true);
      try {
        const response = await axios.post("/api/register", {
          ...formData,
          ...data,
        });
        setRefNumber(response.data.refNumber);
        resetForm();
      } catch (error) {
        console.error("Error submitting form", error);
      } finally {
        setLoading(false);
      }
    }
  };

  const [loading, setLoading] = useState(true); // Splash screen state

  // Simulate splash screen for 2.5 seconds
  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 1500);
    return () => clearTimeout(timer);
  }, []);

  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <RegistrationSplashScreen loading={loading} />

      {/* ✅ Main Payment Portal (Visible after splash) */}
      {!loading && (
        <div className="h-screen lg:min-h-40 bg-gradient-to-br from-green-50 to-purple-50 flex flex-col w-full lg:w-[50%] lg:rounded-lg mx-auto relative overflow-auto  pb-20">
          {/* Header */}
          <header className="bg-white md:shadow-none shadow-lg p-4 flex items-center sticky top-0 z-50">
            <div className="flex items-center ml-2">
              <User className="w-6 h-6 text-green-500 mr-2" />
              <h1 className="text-lg font-semibold">Student Portal</h1>
            </div>
          </header>

          {/* Logo Section */}
          <div className="bg-white flex justify-center items-center flex-col w-full pt-4">
            <div className="w-[30%]  flex items-center justify-center">
              {/* Replace with actual Image component when you have the logo */}
              <img
                src="/logo.png"
                alt="College Logo"
                className="w-full h-full object-contain"
              />
            </div>
            <p className="text-3xl font-bold my-4">Student Registration</p>
          </div>

          <div className=" bg-white shadow-lg rounded-lg p-6 mt-5 mx-5">
            {refNumber ? (
              <motion.div
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                transition={{ duration: 0.3 }}
                className=""
              >
                <div className="text-green-600 text-center mb-4">
                  <p>Registration Successful!</p>
                  <p>
                    Reference Number: <strong>{refNumber}</strong>
                  </p>
                </div>
                {/* Payment Button */}
                <Link className="mt-5" href="/payment">
                  <button className="w-full bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200 flex items-center justify-between">
                    <span className="text-lg font-semibold">
                      Continue to Payment
                    </span>
                    <ArrowRight className="w-5 h-5" />
                  </button>
                </Link>
              </motion.div>
            ) : (
              <div>
                <h2 className="text-xl font-bold mb-4">Step {step} of 5</h2>
                <progress
                  className="w-full mb-4"
                  value={step}
                  max="5"
                ></progress>

                <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
                  <AnimatePresence mode="wait">
                    <motion.div
                      key={step}
                      initial={{ opacity: 0, x: 50 }}
                      animate={{ opacity: 1, x: 0 }}
                      exit={{ opacity: 0, x: -50 }}
                      transition={{ duration: 0.3 }}
                      className="bg-white rounded-xl  py-6 space-y-6"
                    >
                      {step === 1 && (
                        <>
                          <div className="floating-input">
                            <input {...register("firstName")} placeholder=" " />
                            <label>First Name</label>
                          </div>
                          <div className="floating-input">
                            <input {...register("lastName")} placeholder=" " />
                            <label>Last Name</label>
                          </div>
                          <div className="floating-input">
                            <select
                              {...register("civilStatus")}
                              className="w-full"
                            >
                              <option value="">Select Civil Status</option>
                              <option value="Mr">Mr</option>
                              <option value="Mrs">Mrs</option>
                              <option value="Miss">Miss</option>
                              <option value="Dr">Dr</option>
                            </select>
                            <label>Civil Status</label>
                          </div>
                          <div className="floating-input">
                            <input
                              {...register("nameWithInitials")}
                              placeholder=" "
                            />
                            <label>Name with Initials</label>
                          </div>
                          <div className="floating-input">
                            <input
                              {...register("certificateName")}
                              placeholder=" "
                            />
                            <label>Name on Certificate</label>
                          </div>
                        </>
                      )}

                      {step === 2 && (
                        <>
                          <div className="floating-input">
                            <input {...register("address")} placeholder=" " />
                            <label>Address</label>
                          </div>

                          <div className="floating-input">
                            <input {...register("city")} placeholder=" " />
                            <label>City</label>
                          </div>
                        </>
                      )}

                      {step === 3 && (
                        <>
                          <div className="floating-input">
                            <select {...register("gender")} className="w-full">
                              <option value="">Select Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Other">Other</option>
                            </select>
                            <label>Gender</label>
                          </div>
                          <div className="floating-input">
                            <input {...register("nic")} placeholder=" " />
                            <label>NIC Number</label>
                          </div>
                          <div className="floating-input">
                            <input {...register("dob")} type="date" />
                            <label>Date of Birth</label>
                          </div>
                        </>
                      )}

                      {step === 4 && (
                        <>
                          <div className="floating-input">
                            <input {...register("phone")} placeholder=" " />
                            <label>Phone Number</label>
                          </div>
                          <div className="floating-input">
                            <input {...register("email")} placeholder=" " />
                            <label>Email</label>
                          </div>
                          <div className="floating-input">
                            <input {...register("whatsapp")} placeholder=" " />
                            <label>WhatsApp (Optional)</label>
                          </div>
                        </>
                      )}

                      {step === 5 && (
                        <>
                          <p>Select a Course:</p>
                          {courses.map((course) => (
                            <label
                              key={course.id}
                              className="course-card flex items-center p-4"
                            >
                              <input
                                type="radio"
                                value={course.id}
                                {...register("course")}
                              />
                              <span className="ml-2">{course.name}</span>
                            </label>
                          ))}
                        </>
                      )}

                      <div className="flex gap-3 justify-between">
                        {step > 1 && (
                          <button
                            type="button"
                            className="btn bg-gray-400 rounded-md p-2 flex items-center justify-center w-1/2"
                            onClick={prevStep}
                          >
                            <ArrowLeft className="h-5 w-5 mr-2" />{" "}
                            {/* Left Chevron Icon */}
                            Back
                          </button>
                        )}

                        <button
                          type="submit"
                          className={`btn ${
                            step === 1 ? "w-full" : "w-1/2"
                          } bg-green-500 text-white rounded-md p-2 flex items-center justify-center`}
                        >
                          {step < 5 ? (
                            <>
                              <ArrowRight className="h-5 w-5 mr-2" />{" "}
                              {/* Right Chevron Icon */}
                              Next
                            </>
                          ) : (
                            <>
                              <CheckCircle className="h-5 w-5 mr-2" />{" "}
                              {/* Check Circle Icon for Submit */}
                              Submit
                            </>
                          )}
                        </button>
                      </div>
                    </motion.div>
                  </AnimatePresence>
                </form>
              </div>
            )}
          </div>
        </div>
      )}
    </div>
  );
}
