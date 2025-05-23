"use client";
import React from "react";

import { useState, useEffect } from "react";
import { Upload, Building2 } from "lucide-react";

function BankInfo({ formData, updateFormData, setIsValid, setValue }) {
  const [file, setFile] = useState(null);
  const [preview, setPreview] = useState(null);
  const [error, setError] = useState("");
  const [searchQuery, setSearchQuery] = useState("");
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [banks, setBanks] = useState([]);

  useEffect(() => {
    validateForm();
  }, [formData, file]);

  useEffect(() => {
    const fetchBanks = async () => {
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/banks`
        );
        const data = await response.json();
        console.log("Fetched banks:", data); // Debugging output
        setBanks(Object.values(data));
      } catch (error) {
        console.error("Error fetching banks:", error);
      }
    };

    fetchBanks();
  }, []);

  const handleFileChange = (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
      const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
      if (selectedFile.size > MAX_FILE_SIZE) {
        alert("File size exceeds the maximum limit of 5MB.");
        event.target.value = ""; // Reset file input
        setFile(null); // Clear file state
        setPreview(null); // Clear preview
        return;
      }

      setFile(selectedFile);
      updateFormData("slip", selectedFile);

      if (selectedFile.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onloadend = () => {
          setPreview(reader.result); // Set the image preview
        };
        reader.readAsDataURL(selectedFile);
      } else {
        setPreview(null);
      }
    } else {
      setFile(null);
      setPreview(null);
    }
  };

  const validateForm = () => {
    if (!formData.bank || isNaN(formData.bank)) {
      // Check if bank is a number
      setError("Bank code is required and must be a valid.");
      setIsValid(false);
      return;
    }
    if (!formData.branch.trim()) {
      setError("Branch name is required.");
      setIsValid(false);
      return;
    }
    if (!file) {
      setError("Payment slip is required.");
      setIsValid(false);
      return;
    }
    if (file.size > 10 * 1024 * 1024) {
      setError("File size should not exceed 10MB.");
      setIsValid(false);
      return;
    }
    setError("");
    setIsValid(true);
  };

  return (
    <div className="space-y-4">
      <div className="bg-green-50 p-4 rounded-lg flex items-start space-x-3">
        <Building2 className="w-5 h-5 text-green-500 mt-0.5" />
        <div>
          <h3 className="font-medium text-green-800">Bank Details</h3>
          <p className="text-sm text-green-600">
            Enter your banking information
          </p>
        </div>
      </div>

      <div className="space-y-4">
        <div className="relative">
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Bank
          </label>
          <input
            type="text"
            className="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
            placeholder="Enter bank name"
            value={searchQuery}
            onChange={(e) => {
              setSearchQuery(e.target.value);
              setIsDropdownOpen(true);
            }}
            onFocus={() => setIsDropdownOpen(true)}
            onBlur={() => setTimeout(() => setIsDropdownOpen(false), 200)}
          />

          {typeof window !== "undefined" &&
            isDropdownOpen &&
            banks.length > 0 && (
              <div className="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto z-50">
                {banks
                  .filter((bank) =>
                    bank.bank_name
                      ?.toLowerCase()
                      .includes(searchQuery.toLowerCase())
                  )
                  .map((bank) => (
                    <div
                      key={bank.id}
                      className="p-3 hover:bg-gray-100 cursor-pointer transition-colors"
                      onMouseDown={(e) => {
                        e.preventDefault(); // Prevent input blur before selection
                        setSearchQuery(bank.bank_name); // ✅ Set selected value in input
                        updateFormData("bank", bank.bank_code); // ✅ Store bank code in form
                        setIsDropdownOpen(false);
                      }}
                    >
                      {bank.bank_name} ({bank.bank_code})
                    </div>
                  ))}
              </div>
            )}
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Branch
          </label>
          <input
            type="text"
            value={formData.branch}
            onChange={(e) => updateFormData("branch", e.target.value)}
            className="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
            placeholder="Enter branch name"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Payment Reference
          </label>
          <input
            type="text"
            value={formData.reference}
            onChange={(e) => updateFormData("reference", e.target.value)}
            className="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
            placeholder="Enter reference number(Optional)"
          />
        </div>
      </div>

      <div>
        <label className="block text-sm font-medium text-gray-700 mb-1">
          Payment Slip
        </label>
        <div className="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-colors cursor-pointer">
          <label htmlFor="file-upload">
            <Upload className="w-12 h-12 text-gray-400 mx-auto mb-2" />
            <p className="text-sm text-gray-500">
              Click to upload or drag and drop
            </p>
            <p className="text-xs text-gray-400 mt-1">
              PNG, JPG, PDF up to 10MB
            </p>
            {file && (
              <p className="mt-2 text-sm text-green-500">
                {file.name} ({(file.size / 1024 / 1024).toFixed(2)} MB)
              </p>
            )}
          </label>
          <input
            id="file-upload"
            type="file"
            accept=".png,.jpg,.jpeg,.pdf"
            className="hidden"
            onChange={handleFileChange}
          />
        </div>
      </div>

      {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
    </div>
  );
}

export default BankInfo;
