<?php

class TempLmsUser
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Get all users
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM temp_lms_user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single user by ID
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM temp_lms_user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new user
    public function createUser($data)
    {
        $sql = "INSERT INTO temp_lms_user (
            email_address, civil_status, first_name, last_name, password, nic_number, 
            phone_number, whatsapp_number, address_l1, address_l2, city, district, 
            postal_code, paid_amount, aprroved_status, created_at, full_name, 
            name_with_initials, gender, index_number, name_on_certificate, selected_course
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['email_address'],
            $data['civil_status'],
            $data['first_name'],
            $data['last_name'],
            $data['password'],
            $data['nic_number'],
            $data['phone_number'],
            $data['whatsapp_number'],
            $data['address_l1'],
            $data['address_l2'],
            $data['city'],
            $data['district'],
            $data['postal_code'],
            $data['paid_amount'],
            $data['aprroved_status'],
            $data['created_at'],
            $data['full_name'],
            $data['name_with_initials'],
            $data['gender'],
            $data['index_number'],
            $data['name_on_certificate'],
            $data['selected_course']
        ]);

        return $this->pdo->lastInsertId(); // Return the ID of the newly created user
    }

    // Update an existing user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE temp_lms_user SET 
            email_address = ?, civil_status = ?, first_name = ?, last_name = ?, 
            password = ?, nic_number = ?, phone_number = ?, whatsapp_number = ?, 
            address_l1 = ?, address_l2 = ?, city = ?, district = ?, postal_code = ?, 
            paid_amount = ?, aprroved_status = ?, created_at = ?, full_name = ?, 
            name_with_initials = ?, gender = ?, index_number = ?, name_on_certificate = ?, 
            selected_course = ? 
            WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['email_address'],
            $data['civil_status'],
            $data['first_name'],
            $data['last_name'],
            $data['password'],
            $data['nic_number'],
            $data['phone_number'],
            $data['whatsapp_number'],
            $data['address_l1'],
            $data['address_l2'],
            $data['city'],
            $data['district'],
            $data['postal_code'],
            $data['paid_amount'],
            $data['aprroved_status'],
            $data['created_at'],
            $data['full_name'],
            $data['name_with_initials'],
            $data['gender'],
            $data['index_number'],
            $data['name_on_certificate'],
            $data['selected_course'],
            $id
        ]);

        return $stmt->rowCount(); // Return the number of affected rows
    }

    // Delete a user by ID
    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM temp_lms_user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Return the number of affected rows
    }
}
