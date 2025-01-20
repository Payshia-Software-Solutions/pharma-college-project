<?php
// routes/deliveryOrderRoutes.php

require_once './controllers/DeliveryOrderController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$deliveryOrderController = new DeliveryOrderController($pdo);

// Define delivery order routes
return [
    'GET /delivery-orders' => [$deliveryOrderController, 'getDeliveryOrders'],
    'GET /delivery-orders/{username}/' => [$deliveryOrderController, 'getDeliveryOrderByIndexNumber'],
    'POST /delivery-orders' => [$deliveryOrderController, 'createDeliveryOrder'],
    'GET /delivery-orders/{id}' => [$deliveryOrderController, 'getDeliveryOrder'],
    'PUT /delivery-orders/{id}' => [$deliveryOrderController, 'updateDeliveryOrder'],
    'DELETE /delivery-orders/{id}' => [$deliveryOrderController, 'deleteDeliveryOrder']
];
