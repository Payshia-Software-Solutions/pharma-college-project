import React from "react";
import { MapPin, Building, Home, Navigation, Phone } from "lucide-react";

export default function CourierAddressCard({ address }) {
  return (
    <div className="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
      <div className="bg-blue-50 px-4 py-3 border-b border-gray-200">
        <h3 className="text-lg font-medium text-blue-800 flex items-center">
          <MapPin className="w-5 h-5 text-blue-600 mr-2" />
          Certificate Delivery Address
        </h3>
      </div>
      <div className="p-4 space-y-3">
        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <Home className="w-5 h-5 text-gray-500 mr-3" />
            <span>Address Line 1</span>
          </div>
          <span className="font-semibold text-gray-900">
            {address?.line1 || "Not Provided"}
          </span>
        </div>

        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <Building className="w-5 h-5 text-gray-500 mr-3" />
            <span>Address Line 2</span>
          </div>
          <span className="font-semibold text-gray-900">
            {address?.line2 || "N/A"}
          </span>
        </div>

        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <Navigation className="w-5 h-5 text-gray-500 mr-3" />
            <span>City</span>
          </div>
          <span className="font-semibold text-gray-900">
            {address?.city || "Not Provided"}
          </span>
        </div>

        <div className="flex items-center justify-between py-2 border-b border-gray-100">
          <div className="flex items-center text-gray-700">
            <MapPin className="w-5 h-5 text-gray-500 mr-3" />
            <span>District</span>
          </div>
          <span className="font-semibold text-gray-900">
            {address?.district || "Not Provided"}
          </span>
        </div>

        <div className="flex items-center justify-between py-2">
          <div className="flex items-center text-gray-700">
            <Phone className="w-5 h-5 text-gray-500 mr-3" />
            <span>Phone Number</span>
          </div>
          <span className="font-semibold text-gray-900">
            {address?.phoneNumber || "Not Provided"}
          </span>
        </div>
      </div>
    </div>
  );
}
