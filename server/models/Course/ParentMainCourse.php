<?php

class ParentMainCourse
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch all records from the table
    public function getAllCourses()
    {
        $stmt = $this->pdo->query("SELECT * FROM parent_main_course");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single record by slug
    // public function getCourseBySlug($slug)
    // {
    //     $stmt = $this->pdo->prepare("SELECT * FROM parent_main_course WHERE slug = :slug");
    //     $stmt->execute(['slug' => $slug]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    public function getCourseBySlug($slug)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM parent_main_course WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    


    // Create a new course record
    public function createCourse($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s'); // Automatically set the created_at timestamp

        // Generate a slug from the course name
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['course_name'])));
        
        // Ensure the slug is unique
        $data['slug'] = $this->generateUniqueSlug($slug);

        $sql = "INSERT INTO parent_main_course (course_name, course_code, instructor_id, course_description, course_duration, 
                course_fee, registration_fee, created_at, created_by, display, course_img, certification, mini_description, 
                is_active, lecture_count, hours_per_lecture, assessments, language, quizzes, skill_level, head_count, 
                module_list, course_mode, slug) 
                VALUES (:course_name, :course_code, :instructor_id, :course_description, :course_duration, :course_fee, 
                :registration_fee, :created_at, :created_by, :display, :course_img, :certification, :mini_description, 
                :is_active, :lecture_count, :hours_per_lecture, :assessments, :language, :quizzes, :skill_level, :head_count, 
                :module_list, :course_mode, :slug)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    // Update an existing course record by slug
    public function updateCourse($slug, $data)
    {
        // Check if the course_name is being updated and regenerate the slug if needed
        if (!empty($data['course_name'])) {
            $newSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['course_name'])));
            $data['slug'] = $this->generateUniqueSlug($newSlug);
        } else {
            $data['slug'] = $slug;
        }

        $sql = "UPDATE parent_main_course SET 
                    course_name = :course_name, 
                    course_code = :course_code, 
                    instructor_id = :instructor_id, 
                    course_description = :course_description, 
                    course_duration = :course_duration, 
                    course_fee = :course_fee, 
                    registration_fee = :registration_fee, 
                    created_by = :created_by, 
                    display = :display, 
                    course_img = :course_img, 
                    certification = :certification, 
                    mini_description = :mini_description, 
                    is_active = :is_active, 
                    lecture_count = :lecture_count, 
                    hours_per_lecture = :hours_per_lecture, 
                    assessments = :assessments, 
                    language = :language, 
                    quizzes = :quizzes, 
                    skill_level = :skill_level, 
                    head_count = :head_count, 
                    module_list = :module_list, 
                    course_mode = :course_mode, 
                    slug = :slug
                WHERE slug = :slug";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    // Delete a course record by slug
    public function deleteCourse($slug)
    {
        $stmt = $this->pdo->prepare("DELETE FROM parent_main_course WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
    }

      // Delete a course record by ID
      public function deleteCourseById($id)
      {
          $stmt = $this->pdo->prepare("DELETE FROM parent_main_course WHERE id = :id");
          $stmt->execute(['id' => $id]);
      }
    // Fetch courses by their active status
    public function getActiveCourses()
    {
        $stmt = $this->pdo->query("SELECT * FROM parent_main_course WHERE is_active = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count total courses by mode (Free or Paid)
    public function countCoursesByMode()
    {
        $sql = "SELECT course_mode, COUNT(*) AS total FROM parent_main_course GROUP BY course_mode";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch courses by skill level
    public function getCoursesBySkillLevel($skill_level)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM parent_main_course WHERE skill_level = :skill_level");
        $stmt->execute(['skill_level' => $skill_level]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Helper method to generate a unique slug
    private function generateUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Helper method to check if a slug exists
    private function slugExists($slug)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM parent_main_course WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchColumn() > 0;
    }
}
