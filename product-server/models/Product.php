<?php

class Product {
    private $conn;
    private $table_name = "master_product";

    public $product_id;
    public $product_code;
    public $ProductName;
    public $DisplayName;
    public $PrintName;
    public $SectionID;
    public $DepartmentID;
    public $CategoryID;
    public $BrandId;
    public $UOMeasurement;
    public $ReOderLevel;
    public $LeadDays;
    public $CostPrice;
    public $SellingPrice;
    public $MinimumPrice;
    public $WholesalePrice;
    public $ItemType;
    public $ItemLocation;
    public $ImagePath;
    public $CreatedBy;
    public $CreatedAt;
    public $active_status;
    public $GenericID;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " SET product_code=:product_code, ProductName=:ProductName, DisplayName=:DisplayName, PrintName=:PrintName, SectionID=:SectionID, DepartmentID=:DepartmentID, CategoryID=:CategoryID, BrandId=:BrandId, UOMeasurement=:UOMeasurement, ReOderLevel=:ReOderLevel, LeadDays=:LeadDays, CostPrice=:CostPrice, SellingPrice=:SellingPrice, MinimumPrice=:MinimumPrice, WholesalePrice=:WholesalePrice, ItemType=:ItemType, ItemLocation=:ItemLocation, ImagePath=:ImagePath, CreatedBy=:CreatedBy, active_status=:active_status, GenericID=:GenericID";
        $stmt = $this->conn->prepare($query);

        // sanitize
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags($value));
        }

        // bind values
        $stmt->bindParam(":product_code", $data['product_code']);
        $stmt->bindParam(":ProductName", $data['ProductName']);
        $stmt->bindParam(":DisplayName", $data['DisplayName']);
        $stmt->bindParam(":PrintName", $data['PrintName']);
        $stmt->bindParam(":SectionID", $data['SectionID']);
        $stmt->bindParam(":DepartmentID", $data['DepartmentID']);
        $stmt->bindParam(":CategoryID", $data['CategoryID']);
        $stmt->bindParam(":BrandId", $data['BrandId']);
        $stmt->bindParam(":UOMeasurement", $data['UOMeasurement']);
        $stmt->bindParam(":ReOderLevel", $data['ReOderLevel']);
        $stmt->bindParam(":LeadDays", $data['LeadDays']);
        $stmt->bindParam(":CostPrice", $data['CostPrice']);
        $stmt->bindParam(":SellingPrice", $data['SellingPrice']);
        $stmt->bindParam(":MinimumPrice", $data['MinimumPrice']);
        $stmt->bindParam(":WholesalePrice", $data['WholesalePrice']);
        $stmt->bindParam(":ItemType", $data['ItemType']);
        $stmt->bindParam(":ItemLocation", $data['ItemLocation']);
        $stmt->bindParam(":ImagePath", $data['ImagePath']);
        $stmt->bindParam(":CreatedBy", $data['CreatedBy']);
        $stmt->bindParam(":active_status", $data['active_status']);
        $stmt->bindParam(":GenericID", $data['GenericID']);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET product_code = :product_code, ProductName = :ProductName, DisplayName = :DisplayName, PrintName = :PrintName, SectionID = :SectionID, DepartmentID = :DepartmentID, CategoryID = :CategoryID, BrandId = :BrandId, UOMeasurement = :UOMeasurement, ReOderLevel = :ReOderLevel, LeadDays = :LeadDays, CostPrice = :CostPrice, SellingPrice = :SellingPrice, MinimumPrice = :MinimumPrice, WholesalePrice = :WholesalePrice, ItemType = :ItemType, ItemLocation = :ItemLocation, ImagePath = :ImagePath, CreatedBy = :CreatedBy, active_status = :active_status, GenericID = :GenericID WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        // sanitize
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags($value));
        }
        $id = htmlspecialchars(strip_tags($id));

        // bind values
        $stmt->bindParam(":product_code", $data['product_code']);
        $stmt->bindParam(":ProductName", $data['ProductName']);
        $stmt->bindParam(":DisplayName", $data['DisplayName']);
        $stmt->bindParam(":PrintName", $data['PrintName']);
        $stmt->bindParam(":SectionID", $data['SectionID']);
        $stmt->bindParam(":DepartmentID", $data['DepartmentID']);
        $stmt->bindParam(":CategoryID", $data['CategoryID']);
        $stmt->bindParam(":BrandId", $data['BrandId']);
        $stmt->bindParam(":UOMeasurement", $data['UOMeasurement']);
        $stmt->bindParam(":ReOderLevel", $data['ReOderLevel']);
        $stmt->bindParam(":LeadDays", $data['LeadDays']);
        $stmt->bindParam(":CostPrice", $data['CostPrice']);
        $stmt->bindParam(":SellingPrice", $data['SellingPrice']);
        $stmt->bindParam(":MinimumPrice", $data['MinimumPrice']);
        $stmt->bindParam(":WholesalePrice", $data['WholesalePrice']);
        $stmt->bindParam(":ItemType", $data['ItemType']);
        $stmt->bindParam(":ItemLocation", $data['ItemLocation']);
        $stmt->bindParam(":ImagePath", $data['ImagePath']);
        $stmt->bindParam(":CreatedBy", $data['CreatedBy']);
        $stmt->bindParam(":active_status", $data['active_status']);
        $stmt->bindParam(":GenericID", $data['GenericID']);
        $stmt->bindParam(':product_id', $id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(':product_id', $id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
