<?php
// models/Package.php

class Package
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new package
    public function createPackage($package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active = true)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO packages (package_name, price, parent_seat_count, garland, graduation_cloth, photo_package, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active]);
        return $this->pdo->lastInsertId();
    }

    // Read all packages
    public function getAllPackages()
    {
        $stmt = $this->pdo->query("SELECT * FROM packages");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single package by ID
    public function getPackageById($package_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM packages WHERE package_id = ?");
        $stmt->execute([$package_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a package
    public function updatePackage($package_id, $package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active)
    {
        $stmt = $this->pdo->prepare("
            UPDATE packages 
            SET package_name = ?, price = ?, parent_seat_count = ?, garland = ?, graduation_cloth = ?, photo_package = ?, is_active = ?
            WHERE package_id = ?
        ");
        return $stmt->execute([$package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active, $package_id]);
    }

    // Delete a package
    public function deletePackage($package_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM packages WHERE package_id = ?");
        return $stmt->execute([$package_id]);
    }
}
