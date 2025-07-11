<?php

class StudentCourseModelNew
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create new student course enrollment
    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO student_course (course_code, student_id, enrollment_key, created_at)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['course_code'],
            $data['student_id'],
            $data['enrollment_key'],
            $data['created_at']
        ]);

        return $this->pdo->lastInsertId();
    }

    // Read all enrollments with user details
    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT 
                sc.id AS student_course_id,
                sc.course_code,
                sc.student_id,
                sc.enrollment_key,
                sc.created_at,

                ufd.id AS user_id,
                ufd.username,
                ufd.civil_status,
                ufd.first_name,
                ufd.last_name,
                ufd.gender,
                ufd.address_line_1,
                ufd.address_line_2,
                ufd.city,
                ufd.district,
                ufd.postal_code,
                ufd.telephone_1,
                ufd.telephone_2,
                ufd.nic,
                ufd.e_mail,
                ufd.birth_day,
                ufd.updated_by,
                ufd.updated_at,
                ufd.full_name,
                ufd.name_with_initials,
                ufd.name_on_certificate

            FROM student_course sc
            INNER JOIN user_full_details ufd ON sc.student_id = ufd.student_id
            ORDER BY sc.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read single enrollment with user details by ID
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                sc.id AS student_course_id,
                sc.course_code,
                sc.student_id,
                sc.enrollment_key,
                sc.created_at,

                ufd.id AS user_id,
                ufd.username,
                ufd.civil_status,
                ufd.first_name,
                ufd.last_name,
                ufd.gender,
                ufd.address_line_1,
                ufd.address_line_2,
                ufd.city,
                ufd.district,
                ufd.postal_code,
                ufd.telephone_1,
                ufd.telephone_2,
                ufd.nic,
                ufd.e_mail,
                ufd.birth_day,
                ufd.updated_by,
                ufd.updated_at,
                ufd.full_name,
                ufd.name_with_initials,
                ufd.name_on_certificate

            FROM student_course sc
            INNER JOIN user_full_details ufd ON sc.student_id = ufd.student_id
            WHERE sc.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update enrollment by ID
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE student_course 
            SET course_code = ?, student_id = ?, enrollment_key = ?, created_at = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['course_code'],
            $data['student_id'],
            $data['enrollment_key'],
            $data['created_at'],
            $id
        ]);
    }

    // Delete enrollment by ID
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM student_course WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
