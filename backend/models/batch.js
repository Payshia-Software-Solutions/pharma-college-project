const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Batch = sequelize.define(
    "Batch",
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
        batchTitle: {
            type: DataTypes.STRING(255),
            allowNull: false,
        },
        iconPath: {
            type: DataTypes.STRING(255),
            allowNull: true,
        },
        batchDescription: {
            type: DataTypes.TEXT,
            allowNull: true,
        },
        isActive: {
            type: DataTypes.BOOLEAN,
            allowNull: false,
            defaultValue: true,
        },
    },
    {
        tableName: "batch-list",
        timestamps: true,
        createdAt: "createdAt",
        updatedAt: "updatedAt",
        indexes: [
            {
                unique: true,
                fields: ["batchTitle"],
                name: "UniqueBatchTitle",
            },
        ],
    }
);

module.exports = Batch;
