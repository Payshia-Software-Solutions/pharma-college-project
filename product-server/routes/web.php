<?php
// server/routes/web.php

require_once __DIR__ . '/../controllers/ProductController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$productController = new ProductController($pdo);

// Define routes
return [
    // Get all products
    'GET /products/?$' => function () use ($productController) {
        $productController->getAll();
    },
    // Get product by ID
    'GET /products/(\\d+)/?$' => function ($id) use ($productController) {
        $productController->getById($id);
    },
    // Create new product
    'POST /products/?$' => function () use ($productController) {
        $productController->create();
    },
    // Update product
    'PUT /products/(\\d+)/?$' => function ($id) use ($productController) {
        $productController->update($id);
    },
    // Delete product
    'DELETE /products/(\\d+)/?$' => function ($id) use ($productController) {
        $productController->delete($id);
    },
];
