import React from "react";

function LoginScreen({ setStudentNumber, setCurrentScreen, studentNumber }) {
  return (
    <div className="min-h-screen bg-white flex flex-col">
      <div className="flex-1 flex flex-col justify-center px-6">
        <div className="text-center mb-12">
          <div className="w-24 h-24 mx-auto mb-6 bg-teal-100 rounded-full flex items-center justify-center">
            <div className="text-teal-600 text-2xl font-bold">📚</div>
          </div>
          <h1 className="text-2xl font-bold text-gray-800 mb-2">
            Student Login
          </h1>
          <p className="text-gray-600 text-sm">
            Enter your credentials to access the convocation portal
          </p>
        </div>

        <div className="space-y-4">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Student Number
            </label>
            <input
              type="text"
              value={studentNumber}
              onChange={(e) => setStudentNumber(e.target.value)}
              placeholder="Enter your student number"
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            />
          </div>

          <button
            onClick={() => setCurrentScreen("chat")}
            className="w-full bg-teal-500 text-white py-3 rounded-lg font-medium hover:bg-teal-600 transition-colors"
          >
            Login
          </button>

          <div className="text-center">
            <span className="text-gray-600 text-sm">
              Don&apos;t know your student number?{" "}
            </span>
            <button className="text-teal-500 text-sm font-medium">
              Retrieve it here
            </button>
          </div>

          <div className="text-center mt-4">
            <span className="text-gray-600 text-sm">Need help? </span>
            <button
              onClick={() => setCurrentScreen("chat")}
              className="text-teal-500 text-sm font-medium"
            >
              Contact Support
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default LoginScreen;
