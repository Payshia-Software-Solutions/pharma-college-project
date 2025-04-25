"use client";
import React from "react";
import { motion } from "framer-motion";
import { useState, useEffect } from "react";
import { Loader } from "lucide-react";

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

  const handleAdditionalSeatsChange = (e) => {
    const value = Math.max(0, parseInt(e.target.value) || 0);
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
              <div className="flex items-center space-x-3">
                <input
                  type="radio"
                  name="package"
                  value={pkg.package_id}
                  checked={formData.package_id === pkg.package_id}
                  onChange={() => handlePackageSelect(pkg)}
                  disabled={loading}
                  className="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
                />
                <div className="flex-1">
                  <div className="flex justify-between items-center">
                    <h3 className="text-lg font-medium text-gray-800">
                      {pkg.name}
                    </h3>
                    <span className="text-lg font-semibold text-blue-600">
                      Rs {pkg.price.toFixed(2)}
                    </span>
                  </div>
                  <ul className="mt-2 text-sm text-gray-600 space-y-1">
                    <li>Parent Seats: {pkg.inclusions.parentSeatCount}</li>
                    <li>Garland: {pkg.inclusions.garland ? "Yes" : "No"}</li>
                    <li>
                      Graduation Cloth:{" "}
                      {pkg.inclusions.graduationCloth ? "Yes" : "No"}
                    </li>
                    <li>
                      Photo Package:{" "}
                      {pkg.inclusions.photoPackage ? "Yes" : "No"}
                    </li>
                  </ul>
                </div>
              </div>
            </label>
          ))}
        </div>
      )}

      <div className="mt-6">
        <label className="block text-sm font-medium text-gray-700">
          Additional Parent Seats
        </label>
        <input
          type="number"
          min="0"
          value={additionalSeats}
          onChange={handleAdditionalSeatsChange}
          className="mt-1 p-3 block w-full rounded-md border border-gray-800 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
          placeholder="Enter number of additional seats"
        />
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

      {!formData.package_id && !loading && !error && packages.length > 0 && (
        <p className="text-red-500 text-sm mt-2">
          Please select a package to proceed.
        </p>
      )}
    </motion.div>
  );
}
