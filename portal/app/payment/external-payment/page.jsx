import React from "react";

import ExternalStudentPayment from "@/components/ExternalStudentPayment";

export const metadata = {
  title: "Payment Portal",
  description: "Payment Portal",
};

export default function Home() {
  return (
    <div className="">
      <ExternalStudentPayment />
    </div>
  );
}
