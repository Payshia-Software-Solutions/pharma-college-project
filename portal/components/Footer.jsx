import React from "react";

function Footer() {
  return (
    <footer className="w-full p-1 bg-green-500 text-center text-white text-sm">
      &copy; {new Date().getFullYear()} Ceylon Pharma College. All rights
      reserved.
    </footer>
  );
}

export default Footer;
