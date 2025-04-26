"use client";
import React, { useState, useEffect } from "react";
import { motion } from "framer-motion";
import { Loader } from "lucide-react";

export default function CourseSelectionStep({
  formData,
  updateFormData,
  setIsValid,
  setStepLoading,
}) {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [selectedCourses, setSelectedCourses] = useState(
    formData.courses || []
  );

  useEffect(() => {
    const fetchCourses = async () => {
      setLoading(true);
      if (setStepLoading) setStepLoading(true);

      try {
        const response = await fetch(
          `${process.env.NEXT_PUBLIC_API_URL}/get-student-full-info?loggedUser=${formData.studentNumber}`,
          {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }
        );

        if (!response.ok) {
          throw new Error("Failed to fetch courses");
        }

        const data = await response.json();
        const enrollments = data.studentEnrollments || {};

        // Extract parent_course_id and parent_course_name
        const formattedCourses = Object.values(enrollments).map(
          (enrollment) => ({
            id: enrollment.parent_course_id,
            title: enrollment.parent_course_name,
          })
        );

        // Remove duplicate courses (in case multiple enrollments under same parent course)
        const uniqueCourses = formattedCourses.filter(
          (course, index, self) =>
            index === self.findIndex((c) => c.id === course.id)
        );

        setCourses(uniqueCourses);
        setError(null);

        // Restore previous selections if valid
        if (formData.courses && formData.courses.length > 0) {
          const validSelections = uniqueCourses.filter((course) =>
            formData.courses.some((selected) => selected.id === course.id)
          );
          if (validSelections.length > 0) {
            setSelectedCourses(validSelections);
            updateFormData("courses", validSelections);
            setIsValid(true);
          } else {
            setSelectedCourses([]);
            updateFormData("courses", []);
            setIsValid(false);
          }
        }
      } catch (err) {
        setError(err.message || "An error occurred");
        setCourses([]);
        setSelectedCourses([]);
        setIsValid(false);
      } finally {
        setLoading(false);
        if (setStepLoading) setStepLoading(false);
      }
    };

    fetchCourses();
  }, []); // One-time fetch on mount

  const handleCourseChange = (courseId) => {
    const selectedCourse = courses.find((course) => course.id === courseId);
    let updatedCourses;

    if (selectedCourses.some((course) => course.id === courseId)) {
      updatedCourses = selectedCourses.filter(
        (course) => course.id !== courseId
      );
    } else {
      updatedCourses = [...selectedCourses, selectedCourse];
    }

    setSelectedCourses(updatedCourses);
    updateFormData("courses", updatedCourses);
    setIsValid(updatedCourses.length > 0);
  };

  useEffect(() => {
    if (selectedCourses.length === 0 && courses.length > 0) {
      setIsValid(false);
    }
  }, [courses, selectedCourses, setIsValid]);

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4">Select Enrolled Courses</h2>
      <p className="text-sm text-gray-600">
        Please select one or more courses from the options below.
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
          {courses.map((course) => (
            <label
              key={course.id}
              className={`block border rounded-lg p-4 cursor-pointer transition-all duration-200 ${
                selectedCourses.some((c) => c.id === course.id)
                  ? "border-blue-500 bg-blue-50 shadow-md"
                  : "border-gray-300 hover:bg-gray-50"
              }`}
            >
              <div className="flex items-center space-x-3">
                <input
                  type="checkbox"
                  name="course"
                  value={course.id}
                  checked={selectedCourses.some((c) => c.id === course.id)}
                  onChange={() => handleCourseChange(course.id)}
                  disabled={loading}
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

      {selectedCourses.length === 0 &&
        !loading &&
        !error &&
        courses.length > 0 && (
          <p className="text-red-500 text-sm mt-2">
            Please select at least one course to proceed.
          </p>
        )}
    </motion.div>
  );
}
