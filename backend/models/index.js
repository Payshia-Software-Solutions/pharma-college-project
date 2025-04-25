const Course = require("./course");
const Game = require("./game");
const Evaluation = require("./evaluation");
const CourseGame = require("./courseGame");
const Instructor = require("./instructor");
const Batch = require("./batch");

// Define relationships with onDelete: "RESTRICT"
Course.hasMany(Evaluation, { foreignKey: "courseId", onDelete: "RESTRICT" });
Course.hasMany(Batch, { foreignKey: "courseId", onDelete: "RESTRICT" });
Evaluation.belongsTo(Course, { foreignKey: "courseId", onDelete: "RESTRICT" });

Course.belongsToMany(Game, {
  through: CourseGame,
  foreignKey: "courseId",
  onDelete: "RESTRICT",
});
Game.belongsToMany(Course, {
  through: CourseGame,
  foreignKey: "gameId",
  onDelete: "RESTRICT",
});

module.exports = {
  Course,
  Game,
  Evaluation,
  CourseGame,
  Instructor,
  Batch
};
