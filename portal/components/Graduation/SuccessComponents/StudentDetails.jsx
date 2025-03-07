// StudentDetails.js
import React from "react";
import { User } from "lucide-react";

const StudentDetails = ({ registration }) => (
  <div className="space-y-2">
    <h3 className="text-lg font-medium flex items-center">
      <User className="w-5 h-5 text-green-500 mr-2" />
      Student Details
    </h3>
    <p>
      <strong>Student Number:</strong> {registration.student_number}
    </p>
  </div>
);

export default StudentDetails;
