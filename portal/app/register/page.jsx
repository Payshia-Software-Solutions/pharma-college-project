import React from "react";

import StepForm from "@/components/StepForm";
import RegistrationForm from "@/components/registration/RegistrationForm";

export const metadata = {
  title: "Registration Portal",
  description: "Registration Portal",
};

export default function Home() {
  return (
    <div className="">
      <RegistrationForm />
    </div>
  );
}
