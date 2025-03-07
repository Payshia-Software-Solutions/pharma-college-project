import { motion } from "framer-motion";
import { useEffect } from "react";

export default function PackageCustomizationStep({
  formData,
  updatePackageData,
  setIsValid,
}) {
  // Predefined packages with prices
  const packages = [
    {
      id: "package1",
      name: "Package 1 - Basic",
      price: "$50",
      inclusions: {
        parentSeatCount: 1,
        garland: false,
        graduationCloth: true,
        photoPackage: false,
      },
    },
    {
      id: "package2",
      name: "Package 2 - Standard",
      price: "$75",
      inclusions: {
        parentSeatCount: 2,
        garland: true,
        graduationCloth: true,
        photoPackage: false,
      },
    },
    {
      id: "package3",
      name: "Package 3 - Premium",
      price: "$100",
      inclusions: {
        parentSeatCount: 3,
        garland: true,
        graduationCloth: true,
        photoPackage: true,
      },
    },
  ];

  // Handle package selection
  const handlePackageSelect = (pkg) => {
    // Update the entire package object in formData
    updatePackageData("parentSeatCount", pkg.inclusions.parentSeatCount);
    updatePackageData("garland", pkg.inclusions.garland);
    updatePackageData("graduationCloth", pkg.inclusions.graduationCloth);
    updatePackageData("photoPackage", pkg.inclusions.photoPackage);
    updatePackageData("package_id", selectedPackage.package_id);
    setIsValid(true); // Set as valid once a package is selected
  };

  // Check if the current formData.package matches any predefined package
  const selectedPackageId = packages.find((pkg) =>
    Object.keys(pkg.inclusions).every(
      (key) => pkg.inclusions[key] === formData.package[key]
    )
  )?.id;

  // Ensure validity is set based on whether a package is selected
  useEffect(() => {
    setIsValid(!!selectedPackageId); // Valid only if a package is fully selected
  }, [formData.package, setIsValid]);

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4">Select Your Package</h2>
      <div className="space-y-4">
        {packages.map((pkg) => (
          <label
            key={pkg.id}
            className={`block border rounded-lg p-4 cursor-pointer transition-all duration-200 ${
              selectedPackageId === pkg.id
                ? "border-blue-500 bg-blue-50 shadow-md"
                : "border-gray-300 hover:bg-gray-50"
            }`}
          >
            <div className="flex items-center space-x-3">
              <input
                type="radio"
                name="package"
                value={pkg.id}
                checked={selectedPackageId === pkg.id}
                onChange={() => handlePackageSelect(pkg)}
                className="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
              />
              <div className="flex-1">
                <div className="flex justify-between items-center">
                  <h3 className="text-lg font-medium text-gray-800">
                    {pkg.name}
                  </h3>
                  <span className="text-lg font-semibold text-blue-600">
                    {pkg.price}
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
                    Photo Package: {pkg.inclusions.photoPackage ? "Yes" : "No"}
                  </li>
                </ul>
              </div>
            </div>
          </label>
        ))}
      </div>
      {!selectedPackageId && (
        <p className="text-red-500 text-sm mt-2">
          Please select a package to proceed.
        </p>
      )}
    </motion.div>
  );
}
