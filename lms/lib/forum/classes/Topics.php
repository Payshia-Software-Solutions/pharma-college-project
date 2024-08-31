<?php
// HunterMedicine.php
class Topics
{
    protected $db;
    protected $table_name = "community_post";
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

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['id']] = $row;
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }

    public function fetchLimitedAll($offset = 0, $limit = 10, $orderByColumn = null, $orderDirection = 'ASC')
    {
        try {
            $query = "SELECT * FROM " . $this->table_name;

            if ($orderByColumn) {
                $orderDirection = strtoupper($orderDirection);
                if (!in_array($orderDirection, ['ASC', 'DESC'])) {
                    throw new InvalidArgumentException("Invalid order direction: $orderDirection");
                }
                $query .= " ORDER BY current_status ASC, " . $orderByColumn . " " . $orderDirection;
            }

            $query .= " LIMIT :offset, :limit";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        } catch (InvalidArgumentException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }

    public function fetchLimitedAllByUser($offset = 0, $limit = 10, $orderByColumn = null, $orderDirection = 'ASC', $userName = '')
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_account LIKE :user_account";

            if ($orderByColumn) {
                $orderDirection = strtoupper($orderDirection);
                if (!in_array($orderDirection, ['ASC', 'DESC'])) {
                    throw new InvalidArgumentException("Invalid order direction: $orderDirection");
                }
                $query .= " ORDER BY " . $orderByColumn . " " . $orderDirection;
            }

            $query .= " LIMIT :offset, :limit";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':user_account', $userName, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        } catch (InvalidArgumentException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }

    public function fetchAllByUser($userName)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_account LIKE :user_account";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':user_account', $userName, PDO::PARAM_STR);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['id']] = $row;
            }

            return $resultArray;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return [];
        }
    }

    public function fetchAllSolvedByUser($userName)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_account LIKE :user_account AND current_status LIKE 2";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':user_account', $userName, PDO::PARAM_STR);
            $stmt->execute();

            $resultArray = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultArray[$row['id']] = $row;
            }

            return $resultArray;
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
}
