import React from "react";

export default function FormStep5({ register, courses, coursesLoading }) {
  return (
    <>
      <p>Select a Course:</p>
      {coursesLoading ? (
        <div className="text-gray-500">Loading courses...</div>
      ) : courses.length > 0 ? (
        courses.map((course) => (
          <label
            key={course.id}
            className="course-card flex items-center p-4 border rounded-lg mb-3 hover:bg-gray-50 transition-colors"
          >
            <input
              type="radio"
              value={course.id}
              {...register("course")}
              className="mr-3"
            />
            <div>
              <h3 className="font-semibold">{course.course_name}</h3>
              <p className="text-sm text-gray-600">
                Course Code: {course.course_code} | Duration:{" "}
                {course.course_duration} months
              </p>
              <p className="text-sm text-gray-600 mt-1">
                Course Fee: LKR {course.course_fee?.toLocaleString()}
              </p>
            </div>
          </label>
        ))
      ) : (
        <div className="text-red-500">No courses available</div>
      )}
    </>
  );
}
