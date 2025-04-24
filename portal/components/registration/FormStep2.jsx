import React, { useState } from "react";

export default function FormStep2({
  register,
  errors,
  searchQuery,
  setSearchQuery,
  setValue,
  cities,
}) {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  return (
    <>
      <div className="floating-input">
        <input
          {...register("address", { required: "Address is required" })}
          placeholder=" "
        />
        <label>Address</label>
      </div>
      {errors.address && (
        <p className="text-red-500 text-sm mt-1">{errors.address.message}</p>
      )}

      <div className="floating-input relative">
        <input
          type="text"
          placeholder=" "
          value={searchQuery}
          onChange={(e) => {
            setSearchQuery(e.target.value);
            setIsDropdownOpen(true);
            setValue("city", "");
          }}
          onFocus={() => setIsDropdownOpen(true)}
          onBlur={() => setTimeout(() => setIsDropdownOpen(false), 200)}
        />
        <label>City</label>

        {/* Hidden input for validation */}
        <input
          type="hidden"
          {...register("city", { required: "City is required" })}
        />

        {/* Dropdown List */}
        {isDropdownOpen && (
          <div className="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto z-50">
            {cities
              .filter((city) => {
                const nameEn = city.name_en || "";
                const nameSi = city.name_si || "";
                const query = searchQuery?.toLowerCase() || "";
                return (
                  nameEn.toLowerCase().includes(query) ||
                  nameSi.toLowerCase().includes(query)
                );
              })
              .map((city) => (
                <div
                  key={city.id}
                  className="p-3 hover:bg-gray-100 cursor-pointer transition-colors"
                  onMouseDown={() => {
                    setValue("city", String(city.id));
                    setSearchQuery(city.name_en); // Set visible name
                    setIsDropdownOpen(false);
                  }}
                >
                  {city.name_en} ({city.name_si})
                </div>
              ))}
          </div>
        )}
      </div>
      {errors.city && (
        <p className="text-red-500 text-sm">{errors.city.message}</p>
      )}
    </>
  );
}
