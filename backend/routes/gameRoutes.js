const express = require("express");
const router = express.Router();
const gameController = require("../controllers/gameController");

// Game routes
router.post("/", gameController.createGame); // POST /api/v2/games
router.get("/", gameController.getAllGames); // GET /api/v2/games
router.get("/:id", gameController.getGame); // GET /api/v2/games/:id
router.put("/:id", gameController.updateGame); // PUT /api/v2/games/:id
router.delete("/:id", gameController.deleteGame); // DELETE /api/v2/games/:id

module.exports = router;
