const express = require("express");
const router = express.Router();
const evaluationController = require("../controllers/evaluationController");

// Evaluation routes
router.post("/", evaluationController.createEvaluation); // POST /api/v2/evaluations
router.get("/", evaluationController.getAllEvaluations); // GET /api/v2/evaluations
router.get("/:id", evaluationController.getEvaluation); // GET /api/v2/evaluations/:id
router.put("/:id", evaluationController.updateEvaluation); // PUT /api/v2/evaluations/:id
router.delete("/:id", evaluationController.deleteEvaluation); // DELETE /api/v2/evaluations/:id

module.exports = router;
