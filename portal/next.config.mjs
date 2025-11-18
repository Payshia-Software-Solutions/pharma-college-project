/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    domains: [
      'content-provider.pharmacollege.lk',
      'placehold.co',
      'via.placeholder.com',
      'placehold.co'  // Correct domain without https://
    ],
  },
};

export default nextConfig;
