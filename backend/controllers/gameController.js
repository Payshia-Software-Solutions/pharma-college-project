const { Game } = require("../models/index");

const gameController = {
  async createGame(req, res) {
    try {
      const game = await Game.create(req.body);
      res.status(201).json(game);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  async getAllGames(req, res) {
    try {
      const games = await Game.findAll();
      res.json(games);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async getGame(req, res) {
    try {
      const game = await Game.findByPk(req.params.id);
      if (!game) return res.status(404).json({ error: "Game not found" });
      res.json(game);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async updateGame(req, res) {
    try {
      const game = await Game.findByPk(req.params.id);
      if (!game) return res.status(404).json({ error: "Game not found" });
      await game.update(req.body);
      res.json(game);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  async deleteGame(req, res) {
    try {
      const game = await Game.findByPk(req.params.id);
      if (!game) return res.status(404).json({ error: "Game not found" });
      await game.destroy();
      res.status(204).send();
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },
};

module.exports = gameController;
