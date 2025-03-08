const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Course = sequelize.define(
  "Course",
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    courseName: {
      type: DataTypes.STRING(255),
      allowNull: false,
    },
    courseCode: {
      type: DataTypes.STRING(10),
      allowNull: false,
    },
    instructorId: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    courseDescription: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
    courseDuration: {
      type: DataTypes.STRING(50),
      allowNull: false,
    },
    courseFee: {
      type: DataTypes.FLOAT,
      allowNull: false,
    },
    registrationFee: {
      type: DataTypes.FLOAT,
      allowNull: false,
    },
    createdBy: {
      type: DataTypes.STRING(255),
      allowNull: false,
    },
    updatedBy: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    display: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: true,
    },
    courseImg: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    certification: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: false,
    },
    miniDescription: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
    isActive: {
      type: DataTypes.BOOLEAN,
      allowNull: false,
      defaultValue: true,
    },
    lectureCount: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    hoursPerLecture: {
      type: DataTypes.FLOAT,
      allowNull: false,
    },
    assessments: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    language: {
      type: DataTypes.STRING(50),
      allowNull: false,
    },
    quizzes: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    skillLevel: {
      type: DataTypes.STRING(50),
      allowNull: false,
    },
    headCount: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    moduleList: {
      type: DataTypes.JSON,
      allowNull: true,
    },
    courseMode: {
      type: DataTypes.STRING(50),
      allowNull: false,
    },
    slug: {
      type: DataTypes.STRING(255),
      allowNull: false,
    },
  },
  {
    timestamps: true,
    createdAt: "createdAt",
    updatedAt: "updatedAt",
    indexes: [
      {
        unique: true,
        fields: ["courseCode"],
        name: "UniqueCourseCode",
      },
      {
        unique: true,
        fields: ["slug"],
        name: "UniqueSlug",
      },
    ],
  }
);

module.exports = Course;
