import { ArrowLeft, CheckCircle } from "lucide-react";

export default function ActionButtons({
  currentStep,
  showSuccess,
  isValid,
  isLoading,
  nextStep,
  handleSubmit,
}) {
  return (
    <div className="mt-6">
      {currentStep < 4 && !showSuccess ? (
        <button
          onClick={nextStep}
          disabled={!isValid || isLoading}
          className="w-full bg-brand text-white p-4 rounded-lg hover:bg-blue-600 transition-colors focus:ring-4 focus:ring-blue-200 disabled:opacity-50 flex items-center justify-center space-x-2"
        >
          {isLoading ? (
            <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin" />
          ) : (
            <>
              <span>Continue</span>
              <ArrowLeft className="w-5 h-5 transform rotate-180" />
            </>
          )}
        </button>
      ) : null}

      {currentStep === 4 && !showSuccess && (
        <button
          onClick={handleSubmit}
          disabled={!isValid || isLoading}
          className="w-full bg-brand text-white p-4 rounded-lg hover:bg-blue-600 transition-colors focus:ring-4 focus:ring-blue-200 disabled:opacity-50 flex items-center justify-center space-x-2"
        >
          {isLoading ? (
            <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin" />
          ) : (
            <>
              <span>Submit Registration</span>
              <CheckCircle className="w-5 h-5" />
            </>
          )}
        </button>
      )}

      {showSuccess && (
        <button
          onClick={() => (window.location.href = "/dashboard")}
          className="w-full bg-brand text-white p-4 rounded-lg hover:bg-blue-600 transition-colors focus:ring-4 focus:ring-blue-200 disabled:opacity-50 flex items-center justify-center space-x-2"
        >
          <span>Go to Dashboard</span>
        </button>
      )}
    </div>
  );
}
