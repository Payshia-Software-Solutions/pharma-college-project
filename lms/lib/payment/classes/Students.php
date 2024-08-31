<?php
include_once 'StudentPayment.php';

class Students extends StudentPayment
{
    protected $db;
    protected $table_name = "users";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function GetStudentIdByUserName($username)
    {
        try {
            $query = "SELECT userid FROM " . $this->table_name . " WHERE username = :username";
            $stmt = $this->db->prepare($query); // Use the PDO connection
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['userid'] : null;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return null;
        }
    }
}
