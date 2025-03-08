const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Instructor = sequelize.define(
  "Instructor",
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    instructor_name: {
      type: DataTypes.STRING(255),
      allowNull: false,
    },
    instructor_code: {
      type: DataTypes.STRING(10),
      allowNull: false,
    },
    email: {
      type: DataTypes.STRING(100),
      allowNull: false,
    },
    phone: {
      type: DataTypes.STRING(20),
      allowNull: true,
    },

    is_active: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: true,
    },
  },
  {
    tableName: "instructors",
    timestamps: true,
    createdAt: "createdAt",
    updatedAt: "updatedAt",
    indexes: [
      {
        unique: true,
        fields: ["email"],
        name: "UniqueEmail",
      },
      {
        unique: true,
        fields: ["instructor_code"],
        name: "UniqueInstructorCode",
      },
    ],
  }
);

module.exports = Instructor;
