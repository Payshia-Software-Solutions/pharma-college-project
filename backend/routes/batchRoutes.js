const express = require("express");
const router = express.Router();
const batchController = require("../controllers/batchController");

// Game routes
router.post("/", batchController.createBatch);
router.get("/", batchController.getAllBatches);
router.get("/:id", batchController.getBatch);
router.put("/:id", batchController.updateBatch);
router.delete("/:id", batchController.deleteBatch);

module.exports = router;
