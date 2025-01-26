<?php

class DeliveryOrder
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch all delivery orders
    public function getAllRecords()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM delivery_orders");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Fetch a delivery order by ID
    public function getRecordById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Insert a new delivery order
    public function createRecord($data)
    {
        try {
            $sql = "INSERT INTO delivery_orders 
                    (delivery_id, tracking_number, index_number, order_date, packed_date, send_date, removed_date, 
                    current_status, delivery_partner, value, payment_method, course_code, estimate_delivery, full_name, 
                    street_address, city, district, phone_1, phone_2, is_active, received_date, cod_amount, package_weight) 
                    VALUES 
                    (:delivery_id, :tracking_number, :index_number, :order_date, :packed_date, :send_date, :removed_date, 
                    :current_status, :delivery_partner, :value, :payment_method, :course_code, :estimate_delivery, :full_name, 
                    :street_address, :city, :district, :phone_1, :phone_2, :is_active, :received_date, :cod_amount, :package_weight)";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Update an existing delivery order
    public function updateRecord($id, $data)
    {
        try {
            $data['id'] = $id;

            $sql = "UPDATE delivery_orders SET 
                        delivery_id = :delivery_id, 
                        tracking_number = :tracking_number, 
                        index_number = :index_number, 
                        order_date = :order_date, 
                        packed_date = :packed_date, 
                        send_date = :send_date, 
                        removed_date = :removed_date, 
                        current_status = :current_status, 
                        delivery_partner = :delivery_partner, 
                        value = :value, 
                        payment_method = :payment_method, 
                        course_code = :course_code, 
                        estimate_delivery = :estimate_delivery, 
                        full_name = :full_name, 
                        street_address = :street_address, 
                        city = :city, 
                        district = :district, 
                        phone_1 = :phone_1, 
                        phone_2 = :phone_2, 
                        is_active = :is_active, 
                        received_date = :received_date, 
                        cod_amount = :cod_amount, 
                        package_weight = :package_weight 
                    WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Delete a delivery order
    public function deleteRecord($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM delivery_orders WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // Get a delivery order by Index Number
    public function getRecordByIndexNumber($index_number)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE index_number = :index_number");
        $stmt->execute(['index_number' => $index_number]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches all matching records
    }

    public function getRecordByIndexNumberAndCourse($index_number, $courseCode)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE index_number = :index_number AND course_code = :course_code");
        $stmt->execute(['index_number' => $index_number, 'course_code' => $courseCode]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches all matching records
    }



    // Get a delivery order by Tracking Number
    public function getRecordByTrackingNumber($tracking_number)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE tracking_number = :tracking_number");
            $stmt->execute(['tracking_number' => $tracking_number]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }




    // Get a delivery order by Current Status
    public function getRecordByCurrentStatus($current_status)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM delivery_orders WHERE current_status = :current_status");
            $stmt->execute(['current_status' => $current_status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
