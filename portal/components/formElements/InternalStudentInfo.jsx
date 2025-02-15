import { useState } from "react";
import { User, Loader } from "lucide-react";

function InternalStudentInfo({ formData, updateFormData, setIsValid }) {
  const [error, setError] = useState("");
  const [studentInfo, setStudentInfo] = useState(null);
  const [loading, setLoading] = useState(false);

  const validateStudentNumber = (value) => {
    if (!value) {
      setError("Student number is required.");
      setIsValid(false);
      return false;
    }
    if (!/^PA\d{5,}$/.test(value)) {
      setError(
        "Student number must start with 'PA' followed by at least 5 digits."
      );
      setIsValid(false);
      return false;
    }
    setError("");
    setIsValid(true);
    return true;
  };

  const fetchStudentDetails = async (studentNumber) => {
    setLoading(true);
    try {
      const response = await fetch(
        `https://api.pharmacollege.lk/userFullDetails/username/${studentNumber}`
      ); // Replace with actual API URL
      if (!response.ok) {
        throw new Error("Student not found");
      }
      const data = await response.json();
      setStudentInfo(data);
    } catch (error) {
      setStudentInfo(null);
      setError("Student not found. Please check the student number.");
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e) => {
    const value = e.target.value.toUpperCase();
    updateFormData("studentNumber", value);
    if (validateStudentNumber(value)) {
      fetchStudentDetails(value);
    } else {
      setStudentInfo(null);
    }
  };

  const handleBlur = () => {
    validateStudentNumber(formData.studentNumber);
  };

  const maskEmail = (email) => {
    if (!email) return "N/A";
    const [name, domain] = email.split("@");

    if (name.length > 4) {
      return `${name.slice(0, 2)}***${name.slice(-2)}@${domain}`;
    }

    return `${name[0]}***@${domain}`;
  };
  const maskPhone = (phone) => {
    if (!phone) return "N/A";
    return phone.replace(/\d(?=\d{4})/g, "*"); // Mask all but last two digits
  };

  const maskNIC = (nic) => {
    if (!nic) return "N/A";
    return nic.length > 4 ? `${nic.slice(0, 4)}***${nic.slice(-4)}` : nic;
  };
  return (
    <div>
      <div className="space-y-4">
        <div className="bg-green-50 p-4 rounded-lg flex items-start space-x-3">
          <User className="w-5 h-5 text-green-500 mt-0.5" />
          <div>
            <h3 className="font-medium text-green-800">Student Information</h3>
            <p className="text-sm text-green-600">
              Please enter your student details
            </p>
          </div>
        </div>

        <div className="space-y-4">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">
              Student Number
            </label>
            <div className="relative">
              <input
                type="text"
                name="studentNumber"
                value={formData.studentNumber}
                onChange={handleChange}
                onBlur={handleBlur}
                className={`w-full p-3 pr-10 border rounded-lg focus:ring-2 
                  ${
                    error
                      ? "border-red-500 focus:ring-red-500"
                      : "border-gray-300 focus:ring-green-500"
                  }
                `}
                placeholder="Enter Student number (e.g., PA-XXXXXX)"
              />
              <User className="w-5 h-5 text-gray-400 absolute right-3 top-3" />
            </div>
            {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
          </div>

          {loading && (
            <div className="flex items-center text-green-600">
              <Loader className="w-5 h-5 animate-spin mr-2" />
              Fetching student details...
            </div>
          )}

          {studentInfo && (
            <div>
              <div className="bg-green-50 rounded-lg p-3 ">
                {/* Contact Details */}
                <div className="">
                  <h1 className="font-medium text-xl mb-2 border-b text-gray-800">
                    Student Information
                  </h1>
                  {/* Name */}
                  <div className="group  mb-2 rounded-xl hover:bg-gray-50 hover:p-2 transition-all duration-300">
                    <div className="flex items-center justify-between">
                      <div>
                        <div className="text-sm text-gray-500 mb-1">
                          Full Name
                        </div>
                        <div className="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                          {studentInfo.first_name} {studentInfo.last_name}
                        </div>
                      </div>
                    </div>
                  </div>

                  {/* Email */}
                  <div className="group  mb-2 rounded-xl hover:bg-gray-50 hover:p-2 transition-all duration-300">
                    <div className="flex items-center justify-between">
                      <div>
                        <div className="text-sm text-gray-500 mb-1">
                          Email Address
                        </div>
                        <div className="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                          {maskEmail(studentInfo.e_mail)}
                        </div>
                      </div>
                      <span className="text-2xl">📧</span>
                    </div>
                  </div>

                  {/* Phone */}
                  <div className="group mb-2 rounded-xl hover:bg-gray-50 hover:p-2 transition-all duration-300">
                    <div className="flex items-center justify-between">
                      <div>
                        <div className="text-sm text-gray-500 mb-1">
                          Phone Number
                        </div>
                        <div className="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                          {maskPhone(studentInfo.telephone_1)}
                        </div>
                      </div>
                      <span className="text-2xl">📱</span>
                    </div>
                  </div>

                  {/* NIC */}
                  <div className="group mb-3 rounded-xl hover:bg-gray-50 hover:p-2 transition-all duration-300">
                    <div className="flex items-center justify-between">
                      <div>
                        <div className="text-sm text-gray-500 mb-1">
                          NIC Number
                        </div>
                        <div className="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">
                          {maskNIC(studentInfo.nic)}
                        </div>
                      </div>
                      <span className="text-2xl">🪪</span>
                    </div>
                  </div>
                </div>
              </div>

              {/* Warning Message */}
              <div className="mt-2 p-4 bg-orange-50 rounded-xl border border-orange-100">
                <div className="flex items-start">
                  <span className="text-xl mr-3">⚠️</span>
                  <p className="text-sm text-orange-700">
                    Please verify that this information is correct. If you
                    notice any discrepancies, contact student support
                    immediately.
                  </p>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

export default InternalStudentInfo;
