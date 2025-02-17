"use client";
import React from "react";
import Link from "next/link";
import { UserPlus, CreditCard, User } from "lucide-react";
import { Card, CardContent } from "@/components/ui/card";
import { motion } from "framer-motion";
import { cn } from "@/lib/utils";

const PortalLanding = () => {
  return (
    <div className="min-h-screen bg-gradient-to-br from-green-50 via-green-50 to-pink-50 flex flex-col w-full lg:w-[60%] xl:w-[50%] lg:rounded-2xl mx-auto relative overflow-hidden shadow-xl pb-20">
      {/* Animated background elements */}
      <div className="absolute inset-0 overflow-hidden">
        {[...Array(3)].map((_, i) => (
          <motion.div
            key={i}
            className="absolute bg-gradient-to-r from-green-200 to-green-200 rounded-full blur-2xl opacity-20"
            style={{
              width: `${Math.random() * 200 + 100}px`,
              height: `${Math.random() * 200 + 100}px`,
              top: `${Math.random() * 100}%`,
              left: `${Math.random() * 100}%`,
            }}
            animate={{
              scale: [1, 1.2, 1],
              rotate: [0, 360],
            }}
            transition={{
              duration: Math.random() * 10 + 10,
              repeat: Infinity,
              ease: "linear",
            }}
          />
        ))}
      </div>

      {/* Header */}
      <header className="bg-white/80 backdrop-blur-md p-6 flex items-center sticky top-0 z-50 shadow-sm">
        <div className="flex items-center space-x-3">
          <div className="p-2 bg-gradient-to-br from-green-600 to-green-600 rounded-lg shadow-lg">
            <User className="w-6 h-6 text-white" />
          </div>
          <h1 className="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-600 bg-clip-text text-transparent">
            Student Portal
          </h1>
        </div>
      </header>

      {/* Logo Section */}
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="bg-transparent flex justify-center items-center flex-col w-full pt-12"
      >
        <motion.div whileHover={{ scale: 1.05 }} className="w-40 relative mb-3">
          <img
            src="/logo.png"
            alt="College Logo"
            className="w-full object-contain drop-shadow-xl"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-green-500/20 to-green-500/20 rounded-full blur-md -z-10" />
        </motion.div>
        <p className="text-4xl font-extrabold bg-gradient-to-r from-green-600 to-green-600 bg-clip-text text-transparent">
          Welcome Back!
        </p>
        <p className="text-lg text-gray-600 mt-2">Choose your action below</p>
      </motion.div>

      {/* Main Content */}
      <main className="flex-1 p-6 pb-12">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
          {/* Register Card */}
          <PortalCard
            href="/register"
            icon={<UserPlus className="w-8 h-8 text-white" />}
            title="Registration"
            description="Enroll in courses and manage your academic profile"
            gradient="from-green-600 to-green-400"
          />

          {/* Payment Card */}
          <PortalCard
            href="/payment"
            icon={<CreditCard className="w-8 h-8 text-white" />}
            title="Payments"
            description="Secure transactions for fees and university payments"
            gradient="from-green-600 to-green-400"
          />
        </div>
      </main>
    </div>
  );
};

const PortalCard = ({ href, icon, title, description, gradient }) => (
  <motion.div whileHover={{ y: -5 }}>
    <Link href={href}>
      <Card
        className={cn(
          "bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all cursor-pointer border-0",
          "relative overflow-hidden group"
        )}
      >
        <div
          className={`absolute inset-0 bg-gradient-to-r ${gradient} opacity-0 group-hover:opacity-10 transition-opacity`}
        />
        <CardContent className="flex flex-col items-center p-8 space-y-4">
          <div
            className={`p-6 rounded-2xl bg-gradient-to-r ${gradient} shadow-lg`}
          >
            {icon}
          </div>
          <h3 className="text-2xl font-bold text-gray-800">{title}</h3>
          <p className="text-gray-600 text-center text-sm leading-relaxed">
            {description}
          </p>
          <div className="mt-4 px-6 py-2 bg-gradient-to-r from-green-50 to-green-50 rounded-full text-sm font-medium text-green-600">
            Get Started →
          </div>
        </CardContent>
      </Card>
    </Link>
  </motion.div>
);

export default PortalLanding;
