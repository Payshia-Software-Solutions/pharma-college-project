const { Course, Game, Evaluation, Batch } = require("../models/index");

const courseController = {
  async createCourse(req, res) {
    try {
      const course = await Course.create(req.body);
      res.status(201).json(course);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  async getAllCourses(req, res) {
    try {
      const courses = await Course.findAll({
        include: [
          { model: Game, as: "Games" },
          { model: Evaluation, as: "Evaluations" },
          { model: Batch, as: "Batches" },
        ],
      });
      res.json(courses);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async getCourse(req, res) {
    try {
      const course = await Course.findByPk(req.params.id, {
        include: [
          { model: Game, as: "Games" },
          { model: Evaluation, as: "Evaluations" },
          { model: Batch, as: "Batches" },
        ],
      });
      if (!course) return res.status(404).json({ error: "Course not found" });
      res.json(course);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async updateCourse(req, res) {
    try {
      const course = await Course.findByPk(req.params.id);
      if (!course) return res.status(404).json({ error: "Course not found" });
      await course.update(req.body);
      res.json(course);
    } catch (error) {
      res.status(400).json({ error: error.message });
    }
  },

  async deleteCourse(req, res) {
    try {
      const course = await Course.findByPk(req.params.id);
      if (!course) return res.status(404).json({ error: "Course not found" });
      await course.destroy();
      res.status(204).send();
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  },

  async addGameToCourse(req, res) {
    try {
      const { courseId, gameId, minQuantity } = req.body;

      // Validate input
      if (!courseId || !gameId) {
        return res
          .status(400)
          .json({ error: "courseId and gameId are required" });
      }

      const course = await Course.findByPk(courseId);
      const game = await Game.findByPk(gameId);

      if (!course || !game) {
        return res.status(404).json({ error: "Course or Game not found" });
      }

      // Add game to course with minQuantity
      await course.addGame(game, { through: { minQuantity } });

      res.status(200).json({
        message: "Game added to course successfully",
        data: { courseId, gameId, minQuantity },
      });
    } catch (error) {
      console.error("Error in addGameToCourse:", error);
      res.status(400).json({ error: error.message });
    }
  },

  async removeGameFromCourse(req, res) {
    try {
      const { courseId, gameId } = req.body;

      // Validate input
      if (!courseId || !gameId) {
        return res
          .status(400)
          .json({ error: "courseId and gameId are required" });
      }

      const course = await Course.findByPk(courseId);
      const game = await Game.findByPk(gameId);

      if (!course || !game) {
        return res.status(404).json({ error: "Course or Game not found" });
      }

      // Remove game from course
      await course.removeGame(game);

      res.status(200).json({
        message: "Game removed from course successfully",
        data: { courseId, gameId },
      });
    } catch (error) {
      console.error("Error in removeGameFromCourse:", error);
      res.status(400).json({ error: error.message });
    }
  },
};

module.exports = courseController;
