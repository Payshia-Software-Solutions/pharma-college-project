// FooterNote.js
import React from "react";

const FooterNote = ({ registration }) => (
  <p className="text-sm text-gray-600 text-center border-t pt-4">
    Please keep this reference number ({registration.reference_number}) for your
    records. Contact support if there are any discrepancies.
  </p>
);

export default FooterNote;
