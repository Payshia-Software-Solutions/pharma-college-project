const express = require("express");
const router = express.Router();
const instructorController = require("../controllers/instructorController");

// Instructor routes
router.post("/", instructorController.createInstructor); // POST /api/v2/instructors
router.get("/", instructorController.getAllInstructors); // GET /api/v2/instructors
router.get("/:id", instructorController.getInstructor); // GET /api/v2/instructors/:id
router.put("/:id", instructorController.updateInstructor); // PUT /api/v2/instructors/:id
router.delete("/:id", instructorController.deleteInstructor); // DELETE /api/v2/instructors/:id

module.exports = router;
