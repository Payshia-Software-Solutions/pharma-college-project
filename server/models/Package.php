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
    public function createPackage($package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active = true, $courses)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO packages (package_name, price, parent_seat_count, garland, graduation_cloth, photo_package, is_active, courses)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active, $courses]);
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

    public function getPackagesByCourseIds(array $courseIds)
    {
        if (empty($courseIds)) {
            return []; // Return empty if no course IDs
        }

        // Create placeholders for the IN clause
        $placeholders = implode(',', array_fill(0, count($courseIds), '?'));

        $sql = "
        SELECT DISTINCT p.* 
        FROM packages p
        INNER JOIN package_courses pc ON p.package_id = pc.package_id
        WHERE pc.course_id IN ($placeholders)
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($courseIds);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Update a package
    public function updatePackage($package_id, $package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active, $courses)
    {
        $stmt = $this->pdo->prepare("
            UPDATE packages 
            SET package_name = ?, price = ?, parent_seat_count = ?, garland = ?, graduation_cloth = ?, photo_package = ?, is_active = ?, courses= ?
            WHERE package_id = ?
        ");
        return $stmt->execute([$package_name, $price, $parent_seat_count, $garland, $graduation_cloth, $photo_package, $is_active, $courses, $package_id]);
    }

    // Delete a package
    public function deletePackage($package_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM packages WHERE package_id = ?");
        return $stmt->execute([$package_id]);
    }

    public function updatePackageStatus($package_id, $is_active)
    {
        $sql = "UPDATE packages SET is_active = :is_active WHERE package_id = :package_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':is_active', $is_active, PDO::PARAM_INT);
        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
