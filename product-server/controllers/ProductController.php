<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $product;

    public function __construct($pdo) {
        $this->product = new Product($pdo);
    }

    public function getAll() {
        $products = $this->product->getAll();
        header('Content-Type: application/json');
        echo json_encode($products);
    }

    public function getById($id) {
        $product = $this->product->getById($id);
        header('Content-Type: application/json');
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Product not found."]);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->product->create($data)) {
            http_response_code(201);
            echo json_encode(["message" => "Product was created."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create product."]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->product->update($id, $data)) {
            http_response_code(200);
            echo json_encode(["message" => "Product was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update product."]);
        }
    }

    public function delete($id) {
        if ($this->product->delete($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Product was deleted."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete product."]);
        }
    }
}
