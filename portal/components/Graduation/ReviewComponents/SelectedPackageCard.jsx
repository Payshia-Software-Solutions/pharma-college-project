import React from "react";
import {
  Package,
  DollarSign,
  Users,
  Gift,
  Check,
  X,
  Camera,
  GraduationCap,
} from "lucide-react";

export default function SelectedPackageCard({
  formData = {},
  selectedPackage = {},
  calculateTotalAmount,
  ADDITIONAL_SEAT_COST,
}) {
  // Ensure formData and packageDetails exist to prevent errors
  const additionalSeats = formData?.packageDetails?.additionalSeats || 0;
  const additionalSeatsCost = additionalSeats * (ADDITIONAL_SEAT_COST || 0);

  // Safely calculate total with fallbacks
  const getTotal = () => {
    if (typeof calculateTotalAmount === "function") {
      return calculateTotalAmount();
    }
    return (selectedPackage?.price || 0) + additionalSeatsCost;
  };

  // Safely access inclusions
  const inclusions = selectedPackage?.inclusions || {};

  return (
    <div className="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
      <div className="bg-blue-50 px-4 py-3 border-b border-gray-200">
        <h3 className="text-lg font-medium text-blue-800 flex items-center">
          <Package className="w-5 h-5 text-blue-600 mr-2" />
          Selected Package
        </h3>
      </div>
      <div className="p-4 space-y-3">
        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <Gift className="w-5 h-5 text-gray-500 mr-3" />
            <span>Package Name</span>
          </div>
          <span className="font-semibold text-gray-900">
            {selectedPackage?.name || "Not Selected"}
          </span>
        </div>

        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <DollarSign className="w-5 h-5 text-gray-500 mr-3" />
            <span>Base Price</span>
          </div>
          <span className="font-semibold text-gray-900">
            Rs {(selectedPackage?.price || 0).toFixed(2)}
          </span>
        </div>

        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <Users className="w-5 h-5 text-gray-500 mr-3" />
            <span>Additional Seats</span>
          </div>
          <span className="font-semibold text-gray-900">
            {additionalSeats}
            <span className="text-sm text-gray-600 ml-1">
              (Rs {additionalSeatsCost.toFixed(2)})
            </span>
          </span>
        </div>

        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <DollarSign className="w-5 h-5 text-green-600 mr-3" />
            <span className="font-medium">Total Payable Amount</span>
          </div>
          <span className="font-bold text-green-700">
            Rs {getTotal().toFixed(2)}
          </span>
        </div>

        <div className="mt-2 pt-2">
          <p className="font-medium text-gray-800 mb-2">Inclusions:</p>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div className="flex items-center py-1">
              <Users className="w-4 h-4 text-gray-500 mr-2" />
              <span className="text-gray-700">Parent Seats: </span>
              <span className="ml-1 font-medium">
                {inclusions.parentSeatCount || 0}
              </span>
            </div>

            <div className="flex items-center py-1">
              <div className="w-4 h-4 flex items-center justify-center mr-2">
                {inclusions.garland ? (
                  <Check className="w-4 h-4 text-green-500" />
                ) : (
                  <X className="w-4 h-4 text-red-500" />
                )}
              </div>
              <span className="text-gray-700">Garland</span>
            </div>

            <div className="flex items-center py-1">
              <div className="w-4 h-4 flex items-center justify-center mr-2">
                {inclusions.graduationCloth ? (
                  <Check className="w-4 h-4 text-green-500" />
                ) : (
                  <X className="w-4 h-4 text-red-500" />
                )}
              </div>
              <span className="text-gray-700">Graduation Cloth</span>
            </div>

            <div className="flex items-center py-1">
              <div className="w-4 h-4 flex items-center justify-center mr-2">
                {inclusions.photoPackage ? (
                  <Check className="w-4 h-4 text-green-500" />
                ) : (
                  <X className="w-4 h-4 text-red-500" />
                )}
              </div>
              <span className="text-gray-700">Photo Package</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
