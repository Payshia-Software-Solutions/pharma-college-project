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

  // Fetch packages from API (runs once on mount)
  useEffect(() => {
    const fetchPackages = async () => {
      setLoading(true);
      if (setStepLoading) setStepLoading(true);
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/packages`,
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
  }, [setStepLoading]); // Only re-run if setStepLoading changes (rare)

  // Validate and restore selection (runs when packages or formData.package_id changes)
  useEffect(() => {
    if (packages.length > 0) {
      const isSelected = packages.some(
        (pkg) => pkg.package_id === formData.package_id
      );
      if (formData.package_id && isSelected) {
        const selected = packages.find(
          (p) => p.package_id === formData.package_id
        );
        updatePackageData("packageDetails", { ...selected.inclusions }); // Restore details
        setIsValid(true);
      } else if (formData.package_id && !isSelected) {
        updatePackageData("package_id", null); // Clear invalid selection
        setIsValid(false);
      } else {
        setIsValid(false); // No selection yet
      }
    }
  }, [formData.package_id, packages, updatePackageData, setIsValid]);

  // Handle package selection
  const handlePackageSelect = (pkg) => {
    updatePackageData("package_id", pkg.package_id);
    updatePackageData("packageDetails", { ...pkg.inclusions });
    setIsValid(true);
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

      {!formData.package_id && !loading && !error && packages.length > 0 && (
        <p className="text-red-500 text-sm mt-2">
          Please select a package to proceed.
        </p>
      )}
    </motion.div>
  );
}
