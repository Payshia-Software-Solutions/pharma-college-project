// PackageDetails.js
import React from "react";
import { Package, DollarSign } from "lucide-react";

const PackageDetails = ({ selectedPackage }) => (
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
);

export default PackageDetails;
