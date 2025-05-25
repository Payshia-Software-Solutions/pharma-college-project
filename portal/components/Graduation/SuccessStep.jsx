import React, { useState, useEffect } from "react";
import { motion } from "framer-motion";
import { Loader, FileText } from "lucide-react";
import { CheckCircle, Truck, Copy, Calendar } from "lucide-react";

// Import other components
import RegistrationHeader from "./SuccessComponents/RegistrationHeader";
import StudentDetails from "./SuccessComponents/StudentDetails";
import CourseDetails from "./SuccessComponents/CourseDetails";
import PackageDetails from "./SuccessComponents/PackageDetails";
import PaymentStatus from "./SuccessComponents/PaymentStatus";
import PaymentSlip from "./SuccessComponents/PaymentSlip";
import FooterNote from "./SuccessComponents/FooterNote";
import CertificateConfirmation from "./SuccessComponents/CertificateConfirmation";

export default function SuccessStep({ referenceNumber, deliveryMethod }) {
  const [registration, setRegistration] = useState(null);
  const [packages, setPackages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [allCourses, setAllCourses] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      try {
        // Conditional API endpoints based on deliveryMethod
        const registrationUrl =
          deliveryMethod === "By Courier"
            ? `${process.env.NEXT_PUBLIC_API_URL}/certificate-orders/${referenceNumber}`
            : `${process.env.NEXT_PUBLIC_API_URL}/convocation-registrations/${referenceNumber}`;

        const [regResponse, pkgResponse, courseResponse] = await Promise.all([
          fetch(registrationUrl, {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }),
          fetch(`${process.env.NEXT_PUBLIC_API_URL}/packages`, {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }),
          fetch(`${process.env.NEXT_PUBLIC_API_URL}/parent-main-course`, {
            method: "GET",
            headers: { "Content-Type": "application/json" },
          }),
        ]);

        if (!regResponse.ok)
          throw new Error("Failed to fetch registration details");
        if (!pkgResponse.ok) throw new Error("Failed to fetch packages");
        if (!courseResponse.ok) throw new Error("Failed to fetch courses");

        const [regData, pkgData, courseData] = await Promise.all([
          regResponse.json(),
          pkgResponse.json(),
          courseResponse.json(),
        ]);

        setRegistration(regData);
        setPackages(
          pkgData.map((pkg) => ({
            package_id: pkg.package_id,
            name: pkg.package_name,
            price: parseFloat(pkg.price),
          }))
        );
        if (Array.isArray(courseData)) {
          setAllCourses(courseData);
        } else {
          throw new Error("Invalid course data");
        }
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [referenceNumber, deliveryMethod]); // Add deliveryMethod to dependency array

  const selectedPackage = registration
    ? packages.find((pkg) => pkg.package_id === registration.package_id) || {
        name: "Unknown Package",
        price: 0,
      }
    : { name: "Loading...", price: 0 };

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6 max-w-2xl mx-auto"
    >
      <h2 className="text-2xl font-bold text-green-600 text-center flex items-center justify-center">
        <FileText className="w-6 h-6 mr-2" />
        Registration Receipt
      </h2>

      {loading && (
        <div className="flex items-center justify-center text-gray-600">
          <Loader className="w-6 h-6 animate-spin mr-2" />
          Loading receipt details...
        </div>
      )}

      {error && (
        <p className="text-red-500 text-center">
          {error}. Unable to load receipt details.
        </p>
      )}

      {!loading && !error && registration && allCourses.length > 0 && (
        <>
          {/* Conditionally render content based on the delivery method */}
          {deliveryMethod === "By Courier" ? (
            <>
              <CertificateConfirmation referenceNumber={referenceNumber} />
            </>
          ) : (
            <>
              <RegistrationHeader registration={registration} />
              <StudentDetails registration={registration} />
              <CourseDetails
                registration={registration}
                allCourses={allCourses}
              />
              <PackageDetails
                selectedPackage={selectedPackage}
                registration={registration}
              />
              <PaymentStatus registration={registration} />
              <PaymentSlip registration={registration} />
              <FooterNote registration={registration} />
            </>
          )}
        </>
      )}
    </motion.div>
  );
}
