"use client";
import React, { useState, useEffect } from "react";

export default function ConvocationPortal({ address, setAddress, setIsValid }) {
  // Function to handle change for address fields
  const handleAddressChange = (e) => {
    const { name, value } = e.target;
    setAddress((prevAddress) => ({
      ...prevAddress,
      [name]: value,
    }));
  };

  // UseEffect to check if all fields are filled
  useEffect(() => {
    const isComplete =
      address.line1 && address.city && address.district && address.phoneNumber; // Ensure all fields have values

    setIsValid(isComplete);
  }, [address]); // Runs when the address changes

  return (
    <div className="px-4 py-6 mx-auto bg-white rounded-lg shadow-md">
      <h2 className="text-2xl font-semibold text-center mb-6">
        Enter Your Delivery Address
      </h2>

      {/* Address Line 1 */}
      <div className="mb-4">
        <label
          htmlFor="addressLine1"
          className="block text-sm font-medium text-gray-700"
        >
          Address Line 1
        </label>
        <input
          id="addressLine1"
          name="line1"
          type="text"
          value={address.line1}
          onChange={handleAddressChange}
          placeholder="Enter Address Line 1"
          className="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      {/* Address Line 2 */}
      <div className="mb-4">
        <label
          htmlFor="addressLine2"
          className="block text-sm font-medium text-gray-700"
        >
          Address Line 2 (Optional)
        </label>
        <input
          id="addressLine2"
          name="line2"
          type="text"
          value={address.line2}
          onChange={handleAddressChange}
          placeholder="Enter Address Line 2"
          className="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      {/* City */}
      <div className="mb-4">
        <label
          htmlFor="city"
          className="block text-sm font-medium text-gray-700"
        >
          City
        </label>
        <input
          id="city"
          name="city"
          type="text"
          value={address.city}
          onChange={handleAddressChange}
          placeholder="Enter City"
          className="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      {/* District */}
      <div className="mb-4">
        <label
          htmlFor="district"
          className="block text-sm font-medium text-gray-700"
        >
          District
        </label>
        <input
          id="district"
          name="district"
          type="text"
          value={address.district}
          onChange={handleAddressChange}
          placeholder="Enter District"
          className="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
      </div>

      {/* Phone Number */}
      <div className="mb-6">
        <label
          htmlFor="phoneNumber"
          className="block text-sm font-medium text-gray-700"
        >
          Phone Number
        </label>
        <input
          id="phoneNumber"
          name="phoneNumber"
          type="tel"
          value={address.phoneNumber}
          onChange={handleAddressChange}
          placeholder="Enter Phone Number"
          className="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
      </div>
    </div>
  );
}
