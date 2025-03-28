<?php
// controllers/PackageController.php

require_once './models/Package.php';

class PackageController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Package($pdo);
    }

    // GET all packages
    public function getPackages()
    {
        $packages = $this->model->getAllPackages();
        echo json_encode($packages);
    }

    // GET a single package by ID
    public function getPackage($package_id)
    {
        $package = $this->model->getPackageById($package_id);
        if ($package) {
            echo json_encode($package);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Package not found']);
        }
    }

    // POST create a new package
    public function createPackage()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (
            !isset($data['package_name']) || !isset($data['price']) ||
            !isset($data['parent_seat_count']) || !isset($data['garland']) ||
            !isset($data['graduation_cloth']) || !isset($data['photo_package'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $package_id = $this->model->createPackage(
            $data['package_name'],
            $data['price'],
            $data['parent_seat_count'],
            $data['garland'],
            $data['graduation_cloth'],
            $data['photo_package'],
            $data['is_active'] ?? true
        );
        http_response_code(201);
        echo json_encode(['package_id' => $package_id, 'message' => 'Package created successfully']);
    }

    // PUT update a package
    public function updatePackage($package_id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (
            !isset($data['package_name']) || !isset($data['price']) ||
            !isset($data['parent_seat_count']) || !isset($data['garland']) ||
            !isset($data['graduation_cloth']) || !isset($data['photo_package'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $success = $this->model->updatePackage(
            $package_id,
            $data['package_name'],
            $data['price'],
            $data['parent_seat_count'],
            $data['garland'],
            $data['graduation_cloth'],
            $data['photo_package'],
            $data['is_active'] ?? true
        );
        if ($success) {
            echo json_encode(['message' => 'Package updated successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Package not found or update failed']);
        }
    }

    // DELETE a package
    public function deletePackage($package_id)
    {
        $success = $this->model->deletePackage($package_id);
        if ($success) {
            echo json_encode(['message' => 'Package deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Package not found or deletion failed']);
        }
    }
}
