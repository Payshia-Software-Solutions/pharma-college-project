import React, { useState } from "react";

const CitySearchDropdown = ({ cities, setValue, register }) => {
  const [searchQuery, setSearchQuery] = useState("");
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);

  return (
    <div className="floating-input relative">
      <input
        type="text"
        placeholder=" "
        value={searchQuery}
        onChange={(e) => {
          setSearchQuery(e.target.value);
          setIsDropdownOpen(true); // Open the dropdown when the input changes
          setValue("city", e.target.value); // Update the form state (e.g., React Hook Form)
        }}
        onFocus={() => setIsDropdownOpen(true)} // Open the dropdown on focus
        onBlur={
          () => setTimeout(() => setIsDropdownOpen(false), 200) // Close the dropdown after a small delay
        }
      />
      <label>City</label>
      {isDropdownOpen && (
        <div className="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto z-50">
          {cities
            .filter((city) =>
              city.name_en.toLowerCase().includes(searchQuery.toLowerCase())
            )
            .map((city) => (
              <div
                key={city.id}
                className="p-3 hover:bg-gray-100 cursor-pointer transition-colors"
                onMouseDown={() => {
                  setValue("city", String(city.id)); // Update the form state with selected city
                  setSearchQuery(city.name_en); // Set the city name in the input
                  setIsDropdownOpen(false); // Close the dropdown
                }}
              >
                {city.name_en} ({city.name_si})
              </div>
            ))}
        </div>
      )}
    </div>
  );
};

export default CitySearchDropdown;
