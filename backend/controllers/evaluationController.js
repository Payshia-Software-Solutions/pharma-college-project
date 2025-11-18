const { Evaluation } = require("../models/index");

const evaluationController = {
  // Create a new evaluation
  async createEvaluation(req, res) {
    try {
      const evaluation = await Evaluation.create(req.body);
      res.status(201).json(evaluation);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  // Get all evaluations
  async getAllEvaluations(req, res) {
    try {
      const evaluations = await Evaluation.findAll();
      res.json(evaluations);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  // Get a single evaluation by ID
  async getEvaluation(req, res) {
    try {
      const evaluation = await Evaluation.findByPk(req.params.id);
      if (!evaluation)
        return res.status(404).json({ error: "Evaluation not found" });
      res.json(evaluation);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  // Update an evaluation
  async updateEvaluation(req, res) {
    try {
      const evaluation = await Evaluation.findByPk(req.params.id);
      if (!evaluation)
        return res.status(404).json({ error: "Evaluation not found" });
      await evaluation.update(req.body);
      res.json(evaluation);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  // Delete an evaluation
  async deleteEvaluation(req, res) {
    try {
      const evaluation = await Evaluation.findByPk(req.params.id);
      if (!evaluation)
        return res.status(404).json({ error: "Evaluation not found" });
      await evaluation.destroy();
      res.status(204).send();
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },
};

module.exports = evaluationController;
