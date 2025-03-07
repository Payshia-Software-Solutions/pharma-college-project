"use client";

import { motion } from "framer-motion";
import { useState, useEffect } from "react";
import { Loader } from "lucide-react";

export default function CourseSelectionStep({
  formData,
  updateFormData,
  setIsValid,
}) {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch courses from the API
  useEffect(() => {
    const fetchCourses = async () => {
      setLoading(true);
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/parent-main-course`,
          {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
              // Add any required headers (e.g., authorization) if needed
            },
          }
        );

        if (!response.ok) {
          throw new Error("Failed to fetch courses");
        }

        const data = await response.json();
        console.log(data); // For debugging
        // Map API data to { id, title }
        const formattedCourses = data.map((course) => ({
          id: course.id || course.course_id, // Adjust based on API response
          title: course.course_name || course.name, // Use course_name as per your API
        }));
        // Add "Custom" option to the courses list
        formattedCourses.push({ id: "custom", title: "Custom" });
        setCourses(formattedCourses);
        setError(null);
      } catch (err) {
        setError(err.message);
        setCourses([]);
      } finally {
        setLoading(false);
      }
    };

    fetchCourses();
  }, []); // Empty dependency array to fetch only once on mount

  // Handle course selection
  const handleCourseChange = (courseId) => {
    const selectedCourse = courses.find((course) => course.id === courseId);
    if (selectedCourse) {
      updateFormData("course", {
        id: selectedCourse.id,
        title: selectedCourse.title,
      });
      setIsValid(true); // Set as valid once a course is selected
    }
  };

  // Ensure validity is reset if no course is selected
  useEffect(() => {
    setIsValid(!!formData.course?.id); // Valid only if a course ID is selected
  }, [formData.course, setIsValid]);

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4">Select Enrolled Course</h2>

      {loading && (
        <div className="flex items-center justify-center text-gray-600">
          <Loader className="w-6 h-6 animate-spin mr-2" />
          Loading courses...
        </div>
      )}

      {error && (
        <p className="text-red-500 text-sm mt-2">
          {error}. Please try again later.
        </p>
      )}

      {!loading && !error && courses.length === 0 && (
        <p className="text-gray-600 text-sm mt-2">No courses available.</p>
      )}

      {!loading && !error && courses.length > 0 && (
        <div className="space-y-4">
          {courses.map((course) => (
            <label
              key={course.id}
              className={`block border rounded-lg p-4 cursor-pointer transition-all duration-200 ${
                formData.course?.id === course.id
                  ? "border-blue-500 bg-blue-50 shadow-md"
                  : "border-gray-300 hover:bg-gray-50"
              }`}
            >
              <div className="flex items-center space-x-3">
                <input
                  type="radio"
                  name="course"
                  value={course.id}
                  checked={formData.course?.id === course.id}
                  onChange={() => handleCourseChange(course.id)}
                  className="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
                />
                <div>
                  <h3 className="text-lg font-medium text-gray-800">
                    {course.title}
                  </h3>
                  {/* Optionally add a description or more details here if API provides */}
                </div>
              </div>
            </label>
          ))}
        </div>
      )}

      {!formData.course?.id && !loading && !error && courses.length > 0 && (
        <p className="text-red-500 text-sm mt-2">
          Please select a course to proceed.
        </p>
      )}
    </motion.div>
  );
}
