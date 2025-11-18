import React from "react";
import { BookOpen, AlertCircle } from "lucide-react";

export default function SelectedCoursesCard({ formData }) {
  const hasCourses = formData?.courses && formData.courses.length > 0;

  return (
    <div className="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
      <div className="bg-blue-50 px-4 py-3 border-b border-gray-200">
        <h3 className="text-lg font-medium text-blue-800 flex items-center">
          <BookOpen className="w-5 h-5 text-blue-600 mr-2" />
          Selected Courses
        </h3>
      </div>
      <div className="p-4">
        {hasCourses ? (
          <ul className="space-y-2">
            {formData.courses.map((course, index) => (
              <li
                key={index}
                className="flex items-start py-2 border-b border-gray-100 last:border-0"
              >
                <div className="flex-shrink-0 pt-1">
                  <BookOpen className="w-5 h-5 text-gray-500" />
                </div>
                <div className="ml-3">
                  <span className="font-medium text-gray-900">
                    {course.title}
                  </span>
                  {course.code && (
                    <span className="text-sm text-gray-500 ml-2">
                      ({course.code})
                    </span>
                  )}
                </div>
              </li>
            ))}
          </ul>
        ) : (
          <div className="flex items-center py-3 text-gray-500">
            <AlertCircle className="w-5 h-5 text-gray-400 mr-2" />
            <span>No courses selected</span>
          </div>
        )}
      </div>
    </div>
  );
}
