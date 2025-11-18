import React, { useEffect } from "react";
import { Wallet, Building2, GraduationCap } from "lucide-react";

const SplashScreen = ({ loading, splashTitle, icon }) => {
  const iconProps = {
    strokeWidth: 1.5,
    className: "w-8 h-8",
  };

  useEffect(() => {
    if (typeof document !== "undefined") {
      const style = document.createElement("style");
      style.textContent = `
        @keyframes spin-slow {
          to {
            transform: rotate(360deg);
          }
        }
        
        @keyframes loading-bar {
          0% { transform: translateX(-100%); }
          100% { transform: translateX(100%); }
        }
        
        .animate-spin-slow {
          animation: spin-slow 8s linear infinite;
        }
        
        .animate-loading-bar {
          animation: loading-bar 2s linear infinite;
        }
        
        .animate-fade-in {
          opacity: 0;
          animation: fadeIn 0.5s ease-out forwards;
        }
        
        .animate-fade-in-delay-1 {
          opacity: 0;
          animation: fadeIn 0.5s ease-out 0.2s forwards;
        }
        
        .animate-fade-in-delay-2 {
          opacity: 0;
          animation: fadeIn 0.5s ease-out 0.4s forwards;
        }
        
        @keyframes fadeIn {
          to { opacity: 1; }
        }
      `;
      document.head.appendChild(style);
    }
  }, []); // Runs only once when the component mounts

  return (
    <>
      {loading && (
        <div className="fixed inset-0 flex items-center justify-center bg-gradient-to-br from-brand to-brand_light text-white z-50">
          {/* Main Content Container */}
          <div className="flex flex-col items-center justify-center space-y-8 p-8">
            {/* Logo Container */}
            <div className="relative">
              {/* Rotating outer circle */}
              <div className="absolute inset-0 animate-spin-slow">
                <div className="h-32 w-32 rounded-full border-4 border-white/30" />
              </div>

              {/* Pulsing icon */}
              <div className="relative flex h-32 w-32 items-center justify-center animate-pulse">
                {icon}
              </div>
            </div>

            {/* Text Content */}
            <div className="text-center space-y-4">
              <h1 className="text-3xl font-bold tracking-tight">
                Ceylon Pharma College
              </h1>
              <p className="text-xl font-medium text-white">{splashTitle}</p>
            </div>

            {/* Loading Bar */}
            <div className="w-64 h-2 bg-white/20 rounded-full overflow-hidden">
              <div className="h-full bg-white animate-loading-bar" />
            </div>

            {/* Feature Icons */}
            <div className="flex space-x-8 text-white">
              <div className="flex flex-col items-center space-y-2 animate-fade-in">
                <Wallet {...iconProps} />
                <span className="text-sm">Secure</span>
              </div>
              <div className="flex flex-col items-center space-y-2 animate-fade-in-delay-1">
                <Building2 {...iconProps} />
                <span className="text-sm">Trusted</span>
              </div>
              <div className="flex flex-col items-center space-y-2 animate-fade-in-delay-2">
                <GraduationCap {...iconProps} />
                <span className="text-sm">Academic</span>
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
};

export default SplashScreen;
