"use client";
import React from "react";
import {
  Home,
  CreditCard,
  UserPlus,
  GraduationCap,
  ShieldCheck,
} from "lucide-react";
import Link from "next/link";
import { usePathname } from "next/navigation";

const FloatingNavFullUnderline = () => {
  const pathname = usePathname();

  const tabs = [
    {
      id: "registration",
      icon: UserPlus,
      label: "Registration",
      link: "/register",
    },
    { id: "payments", icon: CreditCard, label: "Payments", link: "/payment" },
    { id: "home", icon: Home, label: "Home", link: "/" },
    {
      id: "graduation",
      icon: GraduationCap,
      label: "Graduation",
      link: "/graduation",
    },
    {
      id: "certification",
      icon: ShieldCheck,
      label: "Certificate",
      link: "/certification",
    },
  ];

  return (
    <div className="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 pb-safe z-50">
      <div className="flex justify-around items-center h-16 px-4 max-w-lg mx-auto">
        {tabs.map(({ id, icon: Icon, label, link }) => {
          const isActive =
            link === "/" ? pathname === link : pathname.startsWith(link);

          return (
            <Link
              key={id}
              href={link}
              className="relative flex flex-col items-center justify-center w-1/3"
            >
              <div
                className={`flex flex-col items-center transition-transform duration-200 ${
                  isActive ? "-translate-y-4" : ""
                }`}
              >
                <div
                  className={`relative flex items-center justify-center rounded-2xl ${
                    isActive ? "bg-brand shadow-lg p-3 " : ""
                  }`}
                >
                  <Icon
                    className={`h-6 w-6 ${
                      isActive ? "text-white" : "text-gray-600"
                    }`}
                    strokeWidth={isActive ? 2.5 : 2}
                  />
                  {isActive && (
                    <div className="absolute inset-0 bg-blue-400/20 rounded-2xl blur-md -z-10" />
                  )}
                </div>
                <span
                  className={`text-xs mt-1 ${
                    isActive ? "text-brand font-medium" : "text-gray-600"
                  }`}
                >
                  {label}
                </span>
                {isActive && (
                  <div className="absolute -bottom-2 left-0 right-0 h-1 bg-brand rounded-t-full" />
                )}
              </div>
            </Link>
          );
        })}
      </div>
    </div>
  );
};

export default FloatingNavFullUnderline;
