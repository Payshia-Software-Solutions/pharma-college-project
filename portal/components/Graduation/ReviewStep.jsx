import { motion } from "framer-motion";
import {
  User,
  Book,
  Package,
  Users,
  Flower,
  GraduationCap,
  Camera,
  DollarSign,
  FileText,
} from "lucide-react";

export default function ReviewStep({ formData, setIsValid }) {
  // Predefined packages (same as in PackageCustomizationStep for consistency)
  const packages = [
    {
      id: "package1",
      name: "Package 1 - Basic",
      price: "$50",
      inclusions: {
        parentSeatCount: 1,
        garland: false,
        graduationCloth: true,
        photoPackage: false,
      },
    },
    {
      id: "package2",
      name: "Package 2 - Standard",
      price: "$75",
      inclusions: {
        parentSeatCount: 2,
        garland: true,
        graduationCloth: true,
        photoPackage: false,
      },
    },
    {
      id: "package3",
      name: "Package 3 - Premium",
      price: "$100",
      inclusions: {
        parentSeatCount: 3,
        garland: true,
        graduationCloth: true,
        photoPackage: true,
      },
    },
  ];

  // Find the selected package based on formData.package
  const selectedPackage = packages.find((pkg) =>
    Object.keys(pkg.inclusions).every(
      (key) => pkg.inclusions[key] === formData.package[key]
    )
  ) || {
    name: "No Package Selected",
    price: "N/A",
    inclusions: formData.package,
  };

  // Use the course title from formData.course
  const selectedCourse = formData.course?.title || "Not Selected";

  // Set validity (should always be true at this stage if reached)
  setIsValid(true);

  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6"
    >
      <h2 className="text-xl font-semibold mb-4 flex items-center">
        <FileText className="w-6 h-6 text-blue-500 mr-2" />
        Review Your Registration
      </h2>

      <div className="space-y-6">
        {/* Student Information */}
        <div className="bg-gray-50 p-4 rounded-lg">
          <h3 className="text-lg font-medium text-gray-800 flex items-center">
            <User className="w-5 h-5 text-green-500 mr-2" />
            Student Information
          </h3>
          <div className="mt-2 space-y-2 text-gray-700">
            <p className="flex items-center">
              <span className="w-5 h-5 mr-2">📍</span>
              <strong>Student Number:</strong> {formData.studentNumber}
            </p>
            <p className="flex items-center">
              <span className="w-5 h-5 mr-2">👤</span>
              <strong>Name:</strong> {formData.studentName}
            </p>
          </div>
        </div>

        {/* Course Selection */}
        <div className="bg-gray-50 p-4 rounded-lg">
          <h3 className="text-lg font-medium text-gray-800 flex items-center">
            <Book className="w-5 h-5 text-green-500 mr-2" />
            Selected Course
          </h3>
          <p className="mt-2 text-gray-700 flex items-center">
            <span className="w-5 h-5 mr-2">📚</span>
            {selectedCourse}
          </p>
        </div>

        {/* Package Details */}
        <div className="bg-gray-50 p-4 rounded-lg">
          <h3 className="text-lg font-medium text-gray-800 flex items-center">
            <Package className="w-5 h-5 text-green-500 mr-2" />
            Selected Package
          </h3>
          <div className="mt-2 space-y-2 text-gray-700">
            <p className="flex items-center">
              <span className="w-5 h-5 mr-2">🎁</span>
              <strong>Package:</strong> {selectedPackage.name}
            </p>
            <p className="flex items-center">
              <DollarSign className="w-5 h-5 text-blue-500 mr-2" />
              <strong>Price:</strong> {selectedPackage.price}
            </p>
            <div className="mt-2">
              <p className="font-medium text-gray-700">Inclusions:</p>
              <ul className="mt-1 space-y-1 text-gray-600">
                <li className="flex items-center">
                  <Users className="w-4 h-4 text-gray-500 mr-2" />
                  Parent Seats: {selectedPackage.inclusions.parentSeatCount}
                </li>
                <li className="flex items-center">
                  <Flower className="w-4 h-4 text-gray-500 mr-2" />
                  Garland: {selectedPackage.inclusions.garland ? "Yes" : "No"}
                </li>
                <li className="flex items-center">
                  <GraduationCap className="w-4 h-4 text-gray-500 mr-2" />
                  Graduation Cloth:{" "}
                  {selectedPackage.inclusions.graduationCloth ? "Yes" : "No"}
                </li>
                <li className="flex items-center">
                  <Camera className="w-4 h-4 text-gray-500 mr-2" />
                  Photo Package:{" "}
                  {selectedPackage.inclusions.photoPackage ? "Yes" : "No"}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </motion.div>
  );
}
