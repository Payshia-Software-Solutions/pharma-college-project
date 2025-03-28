const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");
const Course = require("./course");

const Evaluation = sequelize.define(
  "Evaluation",
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    courseId: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    criteria_type: {
      type: DataTypes.STRING(50),
      allowNull: false,
    },
    criteria_value: {
      type: DataTypes.STRING(255),
      allowNull: false,
    },
    weight: {
      type: DataTypes.FLOAT,
      allowNull: false,
    },
    is_active: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: true,
    },
  },
  {
    tableName: "evaluation_criteria",
    timestamps: true,
    createdAt: "createdAt",
    updatedAt: "updatedAt",
  }
);

module.exports = Evaluation;
