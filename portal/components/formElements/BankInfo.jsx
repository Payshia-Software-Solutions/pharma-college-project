"use client";

import { useState, useEffect } from "react";
import { Upload, Building2 } from "lucide-react";

function BankInfo({ formData, updateFormData, setIsValid }) {
  const [file, setFile] = useState(null);
  const [preview, setPreview] = useState(null);
  const [error, setError] = useState("");

  useEffect(() => {
    validateForm();
  }, [formData, file]);

  const handleFileChange = (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
      // Validate file size (e.g., max 5MB)
      const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
      if (selectedFile.size > MAX_FILE_SIZE) {
        alert("File size exceeds the maximum limit of 5MB.");
        event.target.value = ""; // Reset file input
        setFile(null); // Clear file state
        setPreview(null); // Clear preview
        return;
      }

      // Set file and update form data
      setFile(selectedFile);
      updateFormData("slip", selectedFile);

      // Check if file is an image
      if (selectedFile.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onloadend = () => {
          setPreview(reader.result); // Set the image preview
        };
        reader.readAsDataURL(selectedFile);
      } else {
        // If not an image, clear the preview
        setPreview(null);
      }
    } else {
      // Reset when no file is selected (if user removes the file)
      setFile(null);
      setPreview(null);
    }
  };

  const validateForm = () => {
    if (!formData.reference.trim()) {
      setError("Payment reference is required.");
      setIsValid(false);
      return;
    }
    if (!formData.bank.trim()) {
      setError("Bank name is required.");
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
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Payment Reference
          </label>
          <input
            type="text"
            value={formData.reference}
            onChange={(e) => updateFormData("reference", e.target.value)}
            className="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
            placeholder="Enter reference number"
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">
            Bank Name
          </label>
          <input
            type="text"
            value={formData.bank}
            onChange={(e) => updateFormData("bank", e.target.value)}
            className="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
            placeholder="Enter bank name"
          />
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
