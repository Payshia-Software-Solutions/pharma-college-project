"use client";
import React from "react";
import { Book } from "lucide-react";

const CourseDetails = ({ registration, allCourses }) => {
  // Handle missing registration or course_id
  if (!registration || !registration.course_id) {
    return (
      <div className="space-y-2">
        <h3 className="text-lg font-medium flex items-center">
          <Book className="w-5 h-5 text-green-500 mr-2" />
          Course
        </h3>
        <p>
          <strong>Course Name(s):</strong> No course data available
        </p>
      </div>
    );
  }

  // Handle invalid allCourses
  if (!Array.isArray(allCourses) || allCourses.length === 0) {
    console.warn(
      "[CourseDetails] allCourses is not an array or is empty:",
      allCourses
    );
    return (
      <div className="space-y-2">
        <h3 className="text-lg font-medium flex items-center">
          <Book className="w-5 h-5 text-green-500 mr-2" />
          Course
        </h3>
        <p>
          <strong>Course Name(s):</strong> Courses not loaded
        </p>
      </div>
    );
  }

  // Split the course_id string into an array of IDs
  const courseIds = registration.course_id.split(",").map((id) => id.trim());

  // Map each course ID to its name
  const courseNames = courseIds.map((id) => {
    const course = allCourses.find((course) => {
      const match = course.id == id; // Using == for loose comparison (string vs number)
      return match;
    });
    return course ? course.course_name : `Unknown Course (ID: ${id})`;
  });

  return (
    <div className="space-y-2">
      <h3 className="text-lg font-medium flex items-center">
        <Book className="w-5 h-5 text-green-500 mr-2" />
        Course
      </h3>
      <div>
        <strong>Course Name(s):</strong>
        {courseNames.length > 0 ? (
          <ul className="list-disc pl-5 mt-1">
            {courseNames.map((name, index) => (
              <li key={index}>{name}</li>
            ))}
          </ul>
        ) : (
          <p className="mt-1">No matching courses found</p>
        )}
      </div>
    </div>
  );
};

export default CourseDetails;
