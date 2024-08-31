<?php

// SaveAnswer.php
class StudentPayment
{
    protected $db;
    protected $table_name = "student_payment";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Insert a new employee
    public function add($data)
    {
        return $this->db->insert($this->table_name, $data);
    }

    // Update an existing employee
    public function update($data, $id)
    {
        $condition = "id = :id";
        $data['id'] = $id; // Add the ID to the data array for binding
        return $this->db->update($this->table_name, $data, $condition);
    }

    // Delete an employee
    public function delete($id)
    {
        $condition = "id = :id";
        return $this->db->delete($this->table_name, $condition, ['id' => $id]);
    }

    // Get the last error from the database
    public function getLastError()
    {
        return $this->db->getLastError();
    }

    public function fetchAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }

    public function fetchById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }

    public function fetchByStudentId($student_id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE student_id = :student_id";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }


    public function fetchByReceiptNumber($receipt_number)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE receipt_number = :receipt_number";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':receipt_number', $receipt_number, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }

    public function fetchByCourseId($course_code, $student_id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE course_code = :course_code AND student_id = :student_id";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }

    public function fetchByCourseIdTotal($course_code, $student_id)
    {
        try {
            $query = "SELECT SUM(`paid_amount`) AS `payments`,  SUM(`discount_amount`) AS `discounts` FROM " . $this->table_name . " WHERE course_code = :course_code AND student_id = :student_id";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }
}
