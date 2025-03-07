"use client";

import { motion } from "framer-motion";
import { useState, useEffect } from "react";
import { Loader } from "lucide-react";

export default function CourseSelectionStep({
  formData,
  updateFormData,
  setIsValid,
  setStepLoading,
}) {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(false); // Initial false to avoid flash
  const [error, setError] = useState(null);

  // Fetch courses from the API
  useEffect(() => {
    const fetchCourses = async () => {
      setLoading(true);
      if (setStepLoading) setStepLoading(true); // Sync with parent
      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/parent-main-course`,
          {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }
        );

        if (!response.ok) {
          throw new Error("Failed to fetch courses");
        }

        const data = await response.json();
        const formattedCourses = data.map((course) => ({
          id: course.id || course.course_id,
          title: course.course_name || course.name,
        }));
        formattedCourses.push({ id: "custom", title: "Custom" });
        setCourses(formattedCourses);
        setError(null);

        // Restore previous selection if valid
        if (formData.course?.id) {
          const selected = formattedCourses.find(
            (c) => c.id === formData.course.id
          );
          if (selected) {
            updateFormData("course", selected);
            setIsValid(true);
          } else {
            updateFormData("course", { id: "", title: "" });
            setIsValid(false);
          }
        }
      } catch (err) {
        setError(err.message);
        setCourses([]);
        setIsValid(false); // Invalidate on fetch error
      } finally {
        setLoading(false);
        if (setStepLoading) setStepLoading(false);
      }
    };

    fetchCourses();
  }, []); // Empty dependency array for one-time fetch

  // Handle course selection
  const handleCourseChange = (courseId) => {
    const selectedCourse = courses.find((course) => course.id === courseId);
    if (selectedCourse) {
      updateFormData("course", {
        id: selectedCourse.id,
        title: selectedCourse.title,
      });
      setIsValid(true);
    } else {
      updateFormData("course", { id: "", title: "" });
      setIsValid(false);
    }
  };

  // Initial validation check
  useEffect(() => {
    if (!formData.course?.id && courses.length > 0) {
      setIsValid(false); // No selection yet
    }
  }, [courses, formData.course, setIsValid]);

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4">Select Enrolled Course</h2>
      <p className="text-sm text-gray-600">
        Please select one course from the options below. Choose "Custom" if your
        course is not listed.
      </p>

      {loading && (
        <div className="flex items-center justify-center text-gray-600">
          <Loader className="w-6 h-6 animate-spin mr-2" />
          Loading courses...
        </div>
      )}

      {error && (
        <p className="text-red-500 text-sm mt-2">
          {error}. Please try again later or contact support.
        </p>
      )}

      {!loading && !error && courses.length === 0 && (
        <p className="text-gray-600 text-sm mt-2">No courses available.</p>
      )}

      {!loading && !error && courses.length > 0 && (
        <div className="space-y-4 overflow-y-auto">
          {" "}
          {/* Added scroll for long lists */}
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
                  disabled={loading} // Disable during fetch
                  className="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500"
                />
                <div>
                  <h3 className="text-lg font-medium text-gray-800">
                    {course.title}
                  </h3>
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
