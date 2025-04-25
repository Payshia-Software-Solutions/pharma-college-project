"use client";
import React, { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import axios from "axios";
import Link from "next/link";
import { motion, AnimatePresence } from "framer-motion";
import { ArrowRight, CheckCircle } from "lucide-react";
import { ToastContainer, toast } from "react-toastify";

import "react-toastify/dist/ReactToastify.css";

import SplashScreen from "../SplashScreen";
import StepHeader from "./StepHeader";
import StepProgress from "./StepProgress";
import FormStep1 from "./FormStep1";
import FormStep2 from "./FormStep2";
import FormStep3 from "./FormStep3";
import FormStep4 from "./FormStep4";
import FormStep5 from "./FormStep5";
import SuccessMessage from "./SuccessMessage";
import NavigationButtons from "./NavigationButtons";

import { useFormStore } from "@/store/formStore";

// Validation Schemas
const formSchema = [
  z.object({
    firstName: z
      .string()
      .min(2, "First name must be at least 2 characters long."),
    lastName: z
      .string()
      .min(2, "Last name must be at least 2 characters long."),
    civilStatus: z.enum(["Mr", "Mrs", "Miss", "Dr"]).optional(),
    nameWithInitials: z
      .string()
      .min(2, "Please enter your name with initials."),
    certificateName: z.string().min(2, "Please enter the certificate name."),
  }),
  z.object({
    address: z.string().min(2, "Address must be at least 2 characters long."),
    city: z.string().nonempty("Please select a city."),
  }),
  z.object({
    gender: z.enum(["Male", "Female", "Other"]),
    nic: z.string().min(10, "NIC must be 10 characters long."),
    dob: z.string().min(2, "Date of birth is required."),
  }),
  z.object({
    phone: z.string().min(10, "Please enter a valid phone number."),
    email: z.string().email("Please enter a valid email address."),
    whatsapp: z.string().min(10, "Please enter a valid WhatsApp number."),
  }),
  z.object({
    course: z.string().min(1, "Please select a course."),
  }),
];

export default function RegistrationForm() {
  const { step, nextStep, prevStep, updateForm, formData, resetForm } =
    useFormStore();

  const [loading, setLoading] = useState(true);
  const [refNumber, setRefNumber] = useState(null);
  const [cities, setCities] = useState([]);
  const [courses, setCourses] = useState([]);
  const [coursesLoading, setCoursesLoading] = useState(true);
  const [searchQuery, setSearchQuery] = useState("");

  const {
    register,
    handleSubmit,
    setValue,
    watch,
    formState: { errors },
  } = useForm({
    resolver: zodResolver(formSchema[step - 1]),
    defaultValues: formData,
  });

  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 1500);
    return () => clearTimeout(timer);
  }, []);

  useEffect(() => {
    const fetchCities = async () => {
      try {
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/cities`);
        const data = await res.json();
        setCities(Object.values(data));
      } catch (err) {
        console.error("Error fetching cities", err);
        toast.error("Error fetching cities. Please try again later.");
      }
    };
    fetchCities();
  }, []);

  useEffect(() => {
    const fetchCourses = async () => {
      try {
        const res = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/parent-main-course`
        );
        const data = await res.json();
        setCourses(data);
      } catch (err) {
        console.error("Error fetching courses", err);
        toast.error("Error fetching courses. Please try again later.");
      } finally {
        setCoursesLoading(false);
      }
    };
    fetchCourses();
  }, []);

  const onSubmit = async (data) => {
    try {
      // Validate the current step
      await formSchema[step - 1].parseAsync(data);
      updateForm(data);

      // If validation passes, move to the next step or submit the form
      if (step < 5) {
        nextStep();
      } else {
        setLoading(true);
        const userData = {
          email_address: formData.email,
          civil_status: formData.civilStatus,
          first_name: formData.firstName,
          last_name: formData.lastName,
          password: "defaultPassword",
          nic_number: formData.nic,
          phone_number: formData.phone,
          whatsapp_number: formData.whatsapp,
          address_l1: formData.address,
          address_l2: "",
          city: formData.city,
          district: "",
          postal_code: "",
          paid_amount: 0,
          aprroved_status: "Not Approved",
          created_at: new Date().toISOString(),
          full_name: `${formData.firstName} ${formData.lastName}`,
          name_with_initials: formData.nameWithInitials,
          gender: formData.gender,
          index_number: "",
          name_on_certificate: formData.certificateName,
          selected_course: formData.course,
        };

        try {
          const response = await axios.post(
            `${process.env.NEXT_PUBLIC_API_URL}/temp-users`,
            userData
          );
          setRefNumber(response.data.user_id);
          resetForm();

          // Show success toast
          toast.success("User created successfully!");
        } catch (error) {
          console.error("Submission failed", error);

          // Show error toast
          if (error.response) {
            const errorMessage =
              error.response.data.error || "Failed to create user";
            const errorDetails = error.response.data.details || errorMessage;

            toast.error(`Error: ${errorMessage} - ${errorDetails}`);
          } else if (error.request) {
            toast.error(
              "Network error or no response from server. Please try again."
            );
          } else if (error.message) {
            toast.error(`Error: ${error.message}`);
          } else {
            toast.error("An unknown error occurred. Please try again later.");
          }
        } finally {
          setLoading(false);
        }
      }
    } catch (validationError) {
      console.log("Validation errors:", validationError.errors);

      // Show validation error toast
      toast.error("Validation failed. Please check the form fields.");
    }
  };

  return (
    <div className="flex justify-center flex-col items-center h-screen">
      <SplashScreen
        loading={loading}
        splashTitle="Registration Portal"
        icon={<CheckCircle className="w-16 h-16" />}
      />

      {!loading && (
        <div className="h-screen bg-white w-full lg:w-[100%] mx-auto relative overflow-auto pb-20">
          <StepHeader />
          <main className="flex-1 p-6 pb-12">
            <div className="bg-white flex justify-center items-center flex-col max-w-4xl mx-auto pt-4">
              <img
                src="/logo.png"
                alt="College Logo"
                className="w-[30%] h-auto object-contain"
              />
              <p className="text-3xl font-bold my-4">Student Registration</p>
            </div>

            <div className="bg-white shadow-lg rounded-lg max-w-4xl mx-auto mt-5 p-6">
              {refNumber ? (
                <SuccessMessage refNumber={refNumber} />
              ) : (
                <div>
                  <StepProgress step={step} />

                  <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
                    <AnimatePresence mode="wait">
                      <motion.div
                        key={step}
                        initial={{ opacity: 0, x: 50 }}
                        animate={{ opacity: 1, x: 0 }}
                        exit={{ opacity: 0, x: -50 }}
                        transition={{ duration: 0.3 }}
                        className="bg-white rounded-xl py-6 space-y-6"
                      >
                        {step === 1 && (
                          <FormStep1 register={register} errors={errors} />
                        )}
                        {step === 2 && (
                          <FormStep2
                            register={register}
                            errors={errors}
                            setValue={setValue}
                            cities={cities}
                            watch={watch}
                            searchQuery={searchQuery}
                            setSearchQuery={setSearchQuery}
                          />
                        )}

                        {step === 3 && (
                          <FormStep3 register={register} errors={errors} />
                        )}
                        {step === 4 && (
                          <FormStep4 register={register} errors={errors} />
                        )}
                        {step === 5 && (
                          <FormStep5
                            register={register}
                            courses={courses}
                            coursesLoading={coursesLoading}
                          />
                        )}

                        <NavigationButtons step={step} prevStep={prevStep} />
                      </motion.div>
                    </AnimatePresence>
                  </form>
                </div>
              )}
            </div>
          </main>
        </div>
      )}

      <ToastContainer />
    </div>
  );
}
