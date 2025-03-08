const express = require("express");
const cors = require("cors");
const path = require("path"); // Add this for file path handling
const fs = require("fs"); // Add for file existence check
const os = require("os"); // Module to get local network IP

// Create a function for logging to both console and log file
const logToFile = (message) => {
  const logMessage = `${new Date().toISOString()} - ${message}\n`;
  console.log(message); // Log to console
  fs.appendFileSync(path.resolve(__dirname, "server.log"), logMessage); // Append to log file
};

// Load environment variables based on NODE_ENV
const env = process.env.NODE_ENV || "development"; // Default to 'development'
const envFile = path.resolve(
  __dirname,
  `.env.${env.trim() === "production" ? "live" : "local"}`
);

// Verify file exists
if (!fs.existsSync(envFile)) {
  logToFile(`❌ Environment file not found: ${envFile}`);
  process.exit(1);
}

// Load environment variables
logToFile(`Loading environment variables from: ${envFile}`);
require("dotenv").config({ path: envFile, override: true });

// Connect to database
const sequelize = require("./config/database");

// Debug environment variables
logToFile(`Environment: ${env}`);

// Import models
const {
  Course,
  Game,
  Evaluation,
  CourseGame,
  Instructor,
} = require("./models/index");

// Import routes
const courseRoutes = require("./routes/courseRoutes");
const gameRoutes = require("./routes/gameRoutes");
const evaluationRoutes = require("./routes/evaluationRoutes");
const instructorRoutes = require("./routes/instructorRoutes");

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Sync database
sequelize
  .sync({ alter: true })
  .then(() => logToFile("\n✅ Database synced successfully"))
  .catch((err) => logToFile(`❌ Error syncing database: ${err.message}`));

// Get the API version from the environment
const apiVersion = process.env.API_VERSION || "v2"; // Default to 'v2' if not defined

// Mount routes with version dynamically
app.use(`/api/${apiVersion}/courses`, courseRoutes);
app.use(`/api/${apiVersion}/games`, gameRoutes);
app.use(`/api/${apiVersion}/evaluations`, evaluationRoutes);
app.use(`/api/${apiVersion}/instructors`, instructorRoutes);

// Root route (optional)
app.get("/", (req, res) =>
  res.send("Welcome to the Ceylon Pharma College API")
);

// Get the local IP address
const getLocalIP = () => {
  const networkInterfaces = os.networkInterfaces();
  let localIP = "localhost"; // Fallback to localhost
  for (const interfaceName in networkInterfaces) {
    for (const iface of networkInterfaces[interfaceName]) {
      // Check if it is an IPv4 address
      if (iface.family === "IPv4" && !iface.internal) {
        localIP = iface.address;
        break;
      }
    }
  }
  return localIP;
};

// Start server
const PORT = process.env.PORT || 5000;
const localIP = getLocalIP(); // Get local network IP
const localUrl = `http://localhost:${PORT}`;
const networkUrl = `http://${localIP}:${PORT}`; // URL accessible on local network

app.listen(PORT, () => {
  logToFile(`Server running on port ${PORT}`);
  logToFile(`\nLocal: ${localUrl}`);
  logToFile(`Network: ${networkUrl}`);
});
