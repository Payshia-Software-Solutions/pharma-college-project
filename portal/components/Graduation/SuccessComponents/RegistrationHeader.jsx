// RegistrationHeader.js
import React from "react";

const RegistrationHeader = ({ registration }) => (
  <div className="text-center border-b pb-4">
    <p className="text-lg font-semibold">Convocation Registration</p>
    <p className="text-sm text-gray-600">
      Reference Number: <strong>{registration.reference_number}</strong>
    </p>
    <p className="text-sm text-gray-600">
      Registered At: {new Date(registration.registered_at).toLocaleString()}
    </p>
  </div>
);

export default RegistrationHeader;
