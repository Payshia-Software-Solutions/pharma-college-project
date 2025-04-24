import React from "react";
// components/CitySearchDropdown.jsx
const CitySearchDropdown = ({
  cities,
  searchQuery,
  setSearchQuery,
  setIsDropdownOpen,
  isDropdownOpen,
  setValue,
  errors,
}) => {
  return (
    <div className="floating-input relative">
      <input
        type="text"
        placeholder=" "
        value={searchQuery}
        onChange={(e) => {
          setSearchQuery(e.target.value);
          setIsDropdownOpen(true);
          setValue("city", e.target.value);
        }}
        onFocus={() => setIsDropdownOpen(true)}
        onBlur={() => setTimeout(() => setIsDropdownOpen(false), 200)}
      />
      <label>City</label>
      {errors.city && (
        <p className="text-red-500 text-sm mt-1">{errors.city.message}</p>
      )}

      {isDropdownOpen && (
        <div className="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto z-50">
          {cities
            .filter((city) =>
              `${city.name_en}${city.name_si}`
                .toLowerCase()
                .includes(searchQuery.toLowerCase())
            )
            .map((city) => (
              <div
                key={city.id}
                className="p-3 hover:bg-gray-100 cursor-pointer"
                onMouseDown={() => {
                  setValue("city", String(city.id));
                  setSearchQuery(city.name_en);
                  setIsDropdownOpen(false);
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
