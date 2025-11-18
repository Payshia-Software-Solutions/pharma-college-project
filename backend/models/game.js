const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");
const Course = require("./course");

const Game = sequelize.define(
  "Game",
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    game_title: {
      type: DataTypes.STRING(255),
      allowNull: false,
    },
    icon_path: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    game_description: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
    is_active: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: true,
    },
  },
  {
    tableName: "games",
    timestamps: true,
    createdAt: "createdAt",
    updatedAt: "updatedAt",
    indexes: [
      {
        unique: true,
        fields: ["game_title"],
        name: "UniqueGameTitle", // Optional: remove if games can have duplicate titles
      },
    ],
  }
);

module.exports = Game;
