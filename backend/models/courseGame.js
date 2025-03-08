const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");
const Course = require("./course");
const Game = require("./game");

const CourseGame = sequelize.define(
  "CourseGame",
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    courseId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Course,
        key: "id",
      },
    },
    gameId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Game,
        key: "id",
      },
    },
    is_active: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: true,
    },
  },
  {
    tableName: "course_games",
    timestamps: true,
    createdAt: "createdAt",
    updatedAt: "updatedAt",
    indexes: [
      {
        unique: true,
        fields: ["courseId", "gameId"],
        name: "UniqueCourseGame",
      },
    ],
  }
);

module.exports = CourseGame;
