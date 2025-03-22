const { Instructor } = require("../models/index");

const instructorController = {
  async createInstructor(req, res) {
    try {
      const instructor = await Instructor.create(req.body);
      res.status(201).json(instructor);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  async getAllInstructors(req, res) {
    try {
      const instructors = await Instructor.findAll();
      res.json(instructors);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async getInstructor(req, res) {
    try {
      const instructor = await Instructor.findByPk(req.params.id);
      if (!instructor)
        return res.status(404).json({ error: "Instructor not found" });
      res.json(instructor);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async updateInstructor(req, res) {
    try {
      const instructor = await Instructor.findByPk(req.params.id);
      if (!instructor)
        return res.status(404).json({ error: "Instructor not found" });
      await instructor.update(req.body);
      res.json(instructor);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  async deleteInstructor(req, res) {
    try {
      const instructor = await Instructor.findByPk(req.params.id);
      if (!instructor)
        return res.status(404).json({ error: "Instructor not found" });
      await instructor.destroy();
      res.status(204).send();
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },
};

module.exports = instructorController;
