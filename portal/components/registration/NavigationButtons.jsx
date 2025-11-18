import React from "react";
import { ArrowLeft, ArrowRight, CheckCircle } from "lucide-react";

export default function NavigationButtons({ step, prevStep, onSubmit }) {
  return (
    <div className="flex gap-3 justify-between">
      {step > 1 && (
        <button
          type="button"
          className="btn bg-gray-400 text-white rounded-md p-2 flex items-center justify-center w-1/2"
          onClick={prevStep}
        >
          <ArrowLeft className="h-5 w-5 mr-2" /> Back
        </button>
      )}

      <button
        type="submit"
        className={`btn ${
          step === 1 ? "w-full" : "w-1/2"
        } bg-brand text-white rounded-md p-2 flex items-center justify-center`}
      >
        {step < 5 ? (
          <>
            <ArrowRight className="h-5 w-5 mr-2" /> Next
          </>
        ) : (
          <>
            <CheckCircle className="h-5 w-5 mr-2" /> Submit
          </>
        )}
      </button>
    </div>
  );
}
