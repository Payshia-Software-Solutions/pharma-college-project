<?php
// routes/PackageRoutes.php

require_once './controllers/PackageController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$packageController = new PackageController($pdo);

// Define an array of routes
return [
    // GET all packages
    'GET /packages/$' => function () use ($packageController) {
        return $packageController->getPackages();
    },

    // GET a single package by ID
    'GET /packages/(\d+)/$' => function ($package_id) use ($packageController) {
        return $packageController->getPackage($package_id);
    },

    // POST create a new package
    'POST /packages/$' => function () use ($packageController) {
        return $packageController->createPackage();
    },

    // PUT update a package
    'PUT /packages/(\d+)/$' => function ($package_id) use ($packageController) {
        return $packageController->updatePackage($package_id);
    },

    // DELETE a package
    'DELETE /packages/(\d+)/$' => function ($package_id) use ($packageController) {
        return $packageController->deletePackage($package_id);
    },
];
