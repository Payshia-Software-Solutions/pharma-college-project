import React from "react";
import { motion } from "framer-motion";
import { ArrowRight } from "lucide-react";
import Link from "next/link";

export default function SuccessMessage({ refNumber }) {
  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.9 }}
      animate={{ opacity: 1, scale: 1 }}
      transition={{ duration: 0.3 }}
      className=""
    >
      <div className="text-green-600 text-center mb-4">
        <p>Registration Successful!</p>
        <p>
          Reference Number: REF<strong>{refNumber}</strong>
        </p>
      </div>
      {/* Payment Button */}
      <Link className="mt-5" href="/payment/external-payment">
        <button className="w-full bg-brand text-white p-4 rounded-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200 flex items-center justify-between">
          <span className="text-lg font-semibold">Continue to Payment</span>
          <ArrowRight className="w-5 h-5" />
        </button>
      </Link>
    </motion.div>
  );
}
