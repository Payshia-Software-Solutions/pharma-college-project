const {  Batch } = require("../models/index");

const batchController = {
    async createBatch(req, res) {
        try {
            const batch = await Batch.create(req.body);
            res.status(201).json(batch);
        } catch (error) {
            res.status(400).json({error: error.message});
        }
    },

    async getAllBatches(req, res) {
        try {
            const batch = await Batch.findAll();
            res.json(batch);
        } catch (error) {
            res.status(500).json({ error: error.message });
        }
    },

    async getBatch(req, res) {
        try {
            const batch = await Batch.findByPk(req.params.id);
            if (!batch) return res.status(404).json({ error: "Batch not found" });
            res.json(batch);
        } catch (error) {
            res.status(500).json({ error: error.message });
        }
    },

    async updateBatch(req, res) {
        try {
            const batch = await Batch.findByPk(req.params.id);
            if (!batch) return res.status(404).json({ error: "Batch not found" });
            await batch.update(req.body);
            res.json(batch);
        } catch (error) {
            res.status(400).json({ error: error.message });
        }
    },

    async deleteBatch(req, res) {
        try {
            const batch = await Batch.findByPk(req.params.id);
            if (!batch) return res.status(404).json({ error: "Batch not found" });
            await batch.destroy();
            res.status(204).send();
        } catch (error) {
            res.status(500).json({ error: error.message });
        }
    },
};

module.exports = batchController;
