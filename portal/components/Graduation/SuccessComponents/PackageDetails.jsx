// PackageDetails.js
import React from "react";
import { Package, DollarSign, Users } from "lucide-react";

const PackageDetails = ({ selectedPackage, registration }) => {
  // Constants for additional seat pricing
  const ADDITIONAL_SEAT_COST = 500; // Replace with your actual cost per seat

  // Get additional seats from registration or default to 0
  const additionalSeats = registration?.additional_seats || 0;
  const additionalSeatsCost = additionalSeats * ADDITIONAL_SEAT_COST;

  // Calculate total
  const basePrice = selectedPackage?.price || 0;
  const totalAmount = basePrice + additionalSeatsCost;

  return (
    <div className="space-y-3">
      <h3 className="text-lg font-medium flex items-center">
        <Package className="w-5 h-5 text-green-500 mr-2" />
        Selected Package
      </h3>

      <div className="bg-gray-50 p-4 rounded-lg space-y-2">
        <p>
          <strong>Package:</strong> {selectedPackage.name}
        </p>

        <p className="flex items-center">
          <DollarSign className="w-5 h-5 text-blue-500 mr-2" />
          <strong>Base Price:</strong> Rs {basePrice.toFixed(2)}
        </p>

        <p className="flex items-center">
          <Users className="w-5 h-5 text-blue-500 mr-2" />
          <strong>Additional Parent Seats:</strong> {additionalSeats}
          {additionalSeats > 0 && (
            <span className="ml-1">(Rs {additionalSeatsCost.toFixed(2)})</span>
          )}
        </p>

        <p className="flex items-center font-medium text-green-700">
          <DollarSign className="w-5 h-5 text-green-600 mr-2" />
          <strong>Total Amount:</strong> Rs {totalAmount.toFixed(2)}
        </p>
      </div>
    </div>
  );
};

export default PackageDetails;
