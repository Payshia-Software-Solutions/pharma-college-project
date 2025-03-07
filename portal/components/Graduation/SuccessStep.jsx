"use client";
import React, { useState, useEffect } from "react";
import { motion } from "framer-motion";
import {
  Loader,
  FileText,
  User,
  Book,
  Package,
  DollarSign,
  Upload,
} from "lucide-react";

export default function SuccessStep({ referenceNumber }) {
  const [registration, setRegistration] = useState(null);
  const [courses, setCourses] = useState([]);
  const [packages, setPackages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch registration details and related information
  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      try {
        // Fetch registration details
        const regResponse = await fetch(
          `https://qa-api.pharmacollege.lk/convocation-registrations/${referenceNumber}`,
          {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }
        );
        if (!regResponse.ok)
          throw new Error("Failed to fetch registration details");
        const regData = await regResponse.json();
        setRegistration(regData);

        // Fetch course details for multiple course_ids
        const courseIds = regData.course_ids
          ? regData.course_ids.split(",")
          : [];

        if (courseIds.length > 0 && courseIds[0]) {
          const fetchCourseDetails = async (courseIds) => {
            const coursePromises = courseIds.map(async (id) => {
              const response = await fetch(
                `${process.env.NEXT_PUBLIC_API_URL}/parent-main-course/get-id/${id}`,
                {
                  method: "GET",
                  headers: { "Content-Type": "application/json" },
                }
              );
              if (!response.ok)
                throw new Error(`Failed to fetch course ID: ${id}`);
              return response.json();
            });

            return Promise.all(coursePromises);
          };

          try {
            const courseData = await fetchCourseDetails(courseIds);
            setCourses(courseData);
          } catch (err) {
            console.error("Error fetching course details:", err);
          }
        }

        // Fetch packages
        const pkgResponse = await fetch(
          "https://qa-api.pharmacollege.lk/packages",
          {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }
        );
        if (!pkgResponse.ok) throw new Error("Failed to fetch packages");
        const pkgData = await pkgResponse.json();
        setPackages(
          pkgData.map((pkg) => ({
            package_id: pkg.package_id,
            name: pkg.package_name,
            price: parseFloat(pkg.price),
          }))
        );
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    if (referenceNumber) {
      fetchData();
    }
  }, [referenceNumber]);

  // Find selected package
  const selectedPackage = registration
    ? packages.find((pkg) => pkg.package_id === registration.package_id) || {
        name: "Unknown Package",
        price: 0,
      }
    : { name: "Loading...", price: 0 };

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6 max-w-2xl mx-auto"
    >
      <h2 className="text-2xl font-bold text-green-600 text-center flex items-center justify-center">
        <FileText className="w-6 h-6 mr-2" />
        Registration Receipt
      </h2>

      {loading && (
        <div className="flex items-center justify-center text-gray-600">
          <Loader className="w-6 h-6 animate-spin mr-2" />
          Loading receipt details...
        </div>
      )}

      {error && (
        <p className="text-red-500 text-center">
          {error}. Unable to load receipt details.
        </p>
      )}

      {!loading && !error && registration && (
        <div className="space-y-6">
          {/* Header */}
          <div className="text-center border-b pb-4">
            <p className="text-lg font-semibold">Convocation Registration</p>
            <p className="text-sm text-gray-600">
              Reference Number: <strong>{registration.reference_number}</strong>
            </p>
            <p className="text-sm text-gray-600">
              Registered At:{" "}
              {new Date(registration.registered_at).toLocaleString()}
            </p>
          </div>

          {/* Student Information */}
          <div className="space-y-2">
            <h3 className="text-lg font-medium flex items-center">
              <User className="w-5 h-5 text-green-500 mr-2" />
              Student Details
            </h3>
            <p>
              <strong>Student Number:</strong> {registration.student_number}
            </p>
            <p>
              <strong>Name:</strong> {registration.student_name}
            </p>
          </div>

          {/* Course Information */}
          <div className="space-y-2">
            <h3 className="text-lg font-medium flex items-center">
              <Book className="w-5 h-5 text-green-500 mr-2" />
              Courses
            </h3>
            {courses.length > 0 ? (
              <ul className="list-disc list-inside space-y-1">
                {courses.map((course, index) => (
                  <li key={index} className="flex items-center">
                    <span className="w-5 h-5 mr-2">📚</span>
                    {course.course_name || `Course ID: ${course.id}`}
                  </li>
                ))}
              </ul>
            ) : (
              <p className="flex items-center">
                <span className="w-5 h-5 mr-2">📚</span>No courses selected
              </p>
            )}
          </div>

          {/* Package Information */}
          <div className="space-y-2">
            <h3 className="text-lg font-medium flex items-center">
              <Package className="w-5 h-5 text-green-500 mr-2" />
              Selected Package
            </h3>
            <p>
              <strong>Package:</strong> {selectedPackage.name}
            </p>
            <p className="flex items-center">
              <DollarSign className="w-5 h-5 text-blue-500 mr-2" />
              <strong>Price:</strong> ${selectedPackage.price.toFixed(2)}
            </p>
          </div>

          {/* Payment Status */}
          <div className="space-y-2">
            <h3 className="text-lg font-medium flex items-center">
              <DollarSign className="w-5 h-5 text-green-500 mr-2" />
              Payment Status
            </h3>
            <p>
              <strong>Status:</strong>{" "}
              <span
                className={`capitalize ${
                  registration.payment_status === "pending"
                    ? "text-yellow-600"
                    : "text-green-600"
                }`}
              >
                {registration.payment_status}
              </span>
            </p>
          </div>

          {/* Footer Note */}
          <p className="text-sm text-gray-600 text-center border-t pt-4">
            Please keep this reference number ({registration.reference_number})
            for your records. Contact support if there are any discrepancies.
          </p>
        </div>
      )}
    </motion.div>
  );
}
