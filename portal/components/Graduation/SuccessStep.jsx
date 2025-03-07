import { motion } from "framer-motion";

export default function SuccessStep({ referenceNumber }) {
  return (
    <motion.div
      initial={{ opacity: 0, x: 50 }}
      animate={{ opacity: 1, x: 0 }}
      exit={{ opacity: 0, x: -50 }}
      transition={{ duration: 0.3 }}
      className="bg-white rounded-xl shadow-lg p-6 space-y-6 text-center"
    >
      <h2 className="text-2xl font-bold text-green-600">
        Registration Successful!
      </h2>
      <p>
        Your Reference Number: <strong>{referenceNumber}</strong>
      </p>
      <p>Please keep this number for your records.</p>
    </motion.div>
  );
}
