"use client";
import React from "react";
import { motion } from "framer-motion";
import { useState, useEffect } from "react";
import { Loader } from "lucide-react";
import Image from "next/image";

import {
  FaRegGrinStars,
  FaGraduationCap,
  FaScroll,
  FaTimesCircle,
  FaChair,
} from "react-icons/fa";

// Custom icon components using SVG
const ChairIcon = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    className="h-8 w-8"
    viewBox="0 0 20 20"
    fill="currentColor"
  >
    <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2V5z" />
    <path d="M5 13a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2v-2z" />
  </svg>
);

const StarIcon = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    className="h-8 w-8"
    viewBox="0 0 20 20"
    fill="currentColor"
  >
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
);

const GraduationCapIcon = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    className="h-8 w-8"
    viewBox="0 0 20 20"
    fill="currentColor"
  >
    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
  </svg>
);

const ScrollIcon = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    className="h-8 w-8"
    viewBox="0 0 20 20"
    fill="currentColor"
  >
    <path
      fillRule="evenodd"
      d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
      clipRule="evenodd"
    />
  </svg>
);

export default function PackageCustomizationStep({
  formData,
  updatePackageData,
  setIsValid,
  setStepLoading,
}) {
  const [packages, setPackages] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [additionalSeats, setAdditionalSeats] = useState(
    formData.packageDetails?.additionalSeats || 0
  );

  const ADDITIONAL_SEAT_COST = 500;

  // Sync additionalSeats with formData when it changes
  useEffect(() => {
    setAdditionalSeats(formData.packageDetails?.additionalSeats || 0);
  }, [formData.packageDetails]);

  // Fetch packages
  useEffect(() => {
    const fetchPackages = async () => {
      setLoading(true);
      if (setStepLoading) setStepLoading(true);
      try {
        // Check if courses are selected
        const courseIds = formData.courses
          ? formData.courses.map((course) => course.id).join(",")
          : "";
        console.log(courseIds);
        if (!courseIds) {
          setError("No courses selected.");
          setLoading(false);
          return;
        }

        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/packages/by-courses?course_ids=${courseIds}`,
          {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }
        );
        if (!response.ok) throw new Error("Failed to fetch packages");
        const data = await response.json();

        const formattedPackages = data
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
            coverImage: pkg.cover_image,
          }))
          .filter((pkg) => pkg.isActive);

        setPackages(formattedPackages);
        setError(null);
      } catch (err) {
        setError(err.message);
        setPackages([]);
        setIsValid(false);
      } finally {
        setLoading(false);
        if (setStepLoading) setStepLoading(false);
      }
    };
    fetchPackages();
  }, [setStepLoading]);

  // Validate selection
  useEffect(() => {
    if (packages.length > 0) {
      const isSelected = packages.some(
        (pkg) => pkg.package_id === formData.package_id
      );
      if (formData.package_id && isSelected) {
        setIsValid(true);
      } else if (formData.package_id && !isSelected) {
        updatePackageData("package_id", null);
        setIsValid(false);
      } else {
        setIsValid(false);
      }
    }
  }, [formData.package_id, packages, updatePackageData, setIsValid]);

  const handlePackageSelect = (pkg) => {
    updatePackageData("package_id", pkg.package_id);
    updatePackageData("packageDetails", {
      ...pkg.inclusions,
      additionalSeats: additionalSeats,
    });
    setIsValid(true);
  };

  const handleAdditionalSeatsChange = (seats) => {
    const value = Math.max(0, seats); // Ensure non-negative value
    setAdditionalSeats(value);

    if (formData.package_id) {
      const selectedPackage = packages.find(
        (p) => p.package_id === formData.package_id
      );
      if (selectedPackage) {
        updatePackageData("packageDetails", {
          ...selectedPackage.inclusions,
          additionalSeats: value,
        });
      }
    }
  };

  const handleClearAdditionalSeats = () => {
    setAdditionalSeats(0); // Reset the additional seats to 0

    if (formData.package_id) {
      const selectedPackage = packages.find(
        (p) => p.package_id === formData.package_id
      );
      if (selectedPackage) {
        updatePackageData("packageDetails", {
          ...selectedPackage.inclusions,
          additionalSeats: 0, // Update package data with 0 additional seats
        });
      }
    }
  };

  const calculateTotalAmount = () => {
    if (!formData.package_id) return 0;
    const selectedPackage = packages.find(
      (pkg) => pkg.package_id === formData.package_id
    );
    if (!selectedPackage) return 0;
    const basePrice = selectedPackage.price;
    const additionalCost = additionalSeats * ADDITIONAL_SEAT_COST;
    return basePrice + additionalCost;
  };

  console.log(packages);
  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4">Select Your Package</h2>

      {loading && (
        <div className="flex items-center justify-center text-gray-600">
          <Loader className="w-6 h-6 animate-spin mr-2" />
          Loading packages...
        </div>
      )}

      {error && (
        <p className="text-red-500 text-sm mt-2">
          {error}. Please try again later.
        </p>
      )}

      {!loading && !error && packages.length === 0 && (
        <p className="text-gray-600 text-sm mt-2">
          No active packages available.
        </p>
      )}

      {!loading && !error && packages.length > 0 && (
        <div className="space-y-4">
          {packages.map((pkg) => (
            <label
              key={pkg.package_id}
              className={`block border rounded-lg p-4 cursor-pointer transition-all duration-200 ${
                formData.package_id === pkg.package_id
                  ? "border-blue-500 bg-blue-50 shadow-md"
                  : "border-gray-300 hover:bg-gray-50"
              }`}
            >
              <div className="flex flex-row sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                <input
                  type="radio"
                  name="package"
                  value={pkg.package_id}
                  checked={formData.package_id === pkg.package_id}
                  onChange={() => handlePackageSelect(pkg)}
                  disabled={loading}
                  className="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
                />

                <div className="w-full">
                  <div className="flex justify-between items-center flex-wrap mb-3">
                    <h3 className="text-base sm:text-xl font-bold text-gray-800">
                      {pkg.name}
                    </h3>
                    <span className="text-2xl font-semibold text-blue-600">
                      Rs {pkg.price.toFixed(2)}
                    </span>
                  </div>
                  <div className="sm:w-1/2 w-full">
                    <Image
                      src={`https://content-provider.pharmacollege.lk/content-provider/uploads/package-images/${pkg.coverImage}`}
                      alt={pkg.name}
                      width={200}
                      height={200}
                      className="w-full object-cover rounded-lg border"
                    />
                  </div>

                  <div className="flex-1 space-y-2">
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-3 mt-4">
                      {/* Student Seats Card */}
                      <div className="bg-gray-50 p-4 rounded-lg text-center shadow-sm">
                        <div className="text-gray-600 mb-2 flex justify-center">
                          <ChairIcon />
                        </div>
                        <h3 className="font-medium text-gray-700">
                          Student Seat
                        </h3>
                        <p className="text-lg font-bold text-blue-600">
                          {pkg.inclusions.parentSeatCount}
                        </p>
                      </div>

                      {/* Garland Card */}
                      <div
                        className={`p-4 rounded-lg text-center shadow-sm ${
                          pkg.inclusions.garland
                            ? "bg-yellow-50"
                            : "bg-gray-50 opacity-60"
                        }`}
                      >
                        <div
                          className={`${
                            pkg.inclusions.garland
                              ? "text-yellow-500"
                              : "text-gray-400"
                          } mb-2 flex justify-center`}
                        >
                          <StarIcon />
                        </div>
                        <h3 className="font-medium text-gray-700">Garland</h3>
                        <p
                          className={`text-sm font-medium ${
                            pkg.inclusions.garland
                              ? "text-green-600"
                              : "text-red-500"
                          }`}
                        >
                          {pkg.inclusions.garland ? "Included" : "Not Included"}
                        </p>
                      </div>

                      {/* Graduation Cloak Card */}
                      <div
                        className={`p-4 rounded-lg text-center shadow-sm ${
                          pkg.inclusions.graduationCloth
                            ? "bg-blue-50"
                            : "bg-gray-50 opacity-60"
                        }`}
                      >
                        <div
                          className={`${
                            pkg.inclusions.graduationCloth
                              ? "text-blue-500"
                              : "text-gray-400"
                          } mb-2 flex justify-center`}
                        >
                          <GraduationCapIcon />
                        </div>
                        <h3 className="font-medium text-gray-700">
                          Graduation Cloak
                        </h3>
                        <p
                          className={`text-sm font-medium ${
                            pkg.inclusions.graduationCloth
                              ? "text-green-600"
                              : "text-red-500"
                          }`}
                        >
                          {pkg.inclusions.graduationCloth
                            ? "Included"
                            : "Not Included"}
                        </p>
                      </div>

                      {/* Scroll */}
                      <div
                        className={`p-4 rounded-lg text-center shadow-sm ${
                          pkg.inclusions.photoPackage
                            ? "bg-teal-50"
                            : "bg-gray-50 opacity-60"
                        }`}
                      >
                        <div
                          className={`${
                            pkg.inclusions.photoPackage
                              ? "text-teal-500"
                              : "text-gray-400"
                          } mb-2 flex justify-center`}
                        >
                          <ScrollIcon />
                        </div>
                        <h3 className="font-medium text-gray-700">Scroll</h3>
                        <p
                          className={`text-sm font-medium ${
                            pkg.inclusions.photoPackage
                              ? "text-green-600"
                              : "text-red-500"
                          }`}
                        >
                          {pkg.inclusions.photoPackage
                            ? "Included"
                            : "Not Included"}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </label>
          ))}
        </div>
      )}

      {!loading && !error && packages.length > 0 && (
        <>
          <div className="mt-6">
            <label className="block text-sm font-medium text-gray-700">
              Additional Seats
            </label>
            <div className="mt-2 flex space-x-4">
              {[1, 2, 3, 4].map((seats) => (
                <button
                  key={seats}
                  onClick={() => handleAdditionalSeatsChange(seats)} // Call with seat value
                  className={`px-4 py-2 rounded-md text-white font-semibold ${
                    additionalSeats === seats
                      ? "bg-blue-500 hover:bg-blue-600"
                      : "bg-gray-300 hover:bg-gray-400"
                  } focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50`}
                >
                  {seats}
                </button>
              ))}

              {/* Clear Button */}
              <button
                onClick={() => handleClearAdditionalSeats()}
                className="px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 font-semibold focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
              >
                Clear
              </button>
            </div>
            <p className="mt-1 text-sm text-gray-500">
              Add extra parent seats beyond the package inclusion (Rs{" "}
              {ADDITIONAL_SEAT_COST} per seat).
            </p>
          </div>

          <div className="mt-6">
            <div className="flex justify-between items-center">
              <span className="text-lg font-medium text-gray-800">
                Total Payable Amount:
              </span>
              <span className="text-lg font-semibold text-blue-600">
                Rs {calculateTotalAmount().toFixed(2)}
              </span>
            </div>
            {formData.package_id && (
              <p className="mt-1 text-sm text-gray-500">
                (Base Price: Rs{" "}
                {packages
                  .find((pkg) => pkg.package_id === formData.package_id)
                  ?.price.toFixed(2)}{" "}
                + Additional Seats Cost: Rs{" "}
                {(additionalSeats * ADDITIONAL_SEAT_COST).toFixed(2)})
              </p>
            )}
          </div>
        </>
      )}

      {!formData.package_id && !loading && !error && packages.length > 0 && (
        <p className="text-red-500 text-sm mt-2">
          Please select a package to proceed.
        </p>
      )}
    </motion.div>
  );
}
