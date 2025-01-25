<?php
require_once './controllers/Orders/DeliveryOrderController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$deliveryOrderController = new DeliveryOrderController($pdo);

// Define routes
return [
    // Get all delivery orders
    'GET /delivery_orders/' => [$deliveryOrderController, 'getAllRecords'],

    // Get a delivery order by ID
    'GET /delivery_orders/{id}/' => [$deliveryOrderController, 'getRecordById'],

'GET /delivery-orders\?indexNumber=[\w]+/$' => function () use ($deliveryOrderController) {
    // Access query parameters using $_GET
    $indexNumber = isset($_GET['indexNumber']) ? $_GET['indexNumber'] : null;

    // Validate parameters
    if (!$indexNumber) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters. indexNumber is required for this API']);
        return;
    }

    return $deliveryOrderController->getRecordByIndexNumber($indexNumber);
},

    // Get a delivery order by Tracking Number
'GET /delivery-orders\?trackingNumber=[\w]+/$' => function () use ($deliveryOrderController) {
    // Access query parameters using $_GET
    $trackingNumber = isset($_GET['trackingNumber']) ? $_GET['trackingNumber'] : null;

    // Validate parameters
    if (!$trackingNumber) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters. trackingNumber is required for this API']);
        return;
    }

    return $deliveryOrderController->getRecordByTrackingNumber($trackingNumber);
},



    // Create a new delivery order
    'POST /delivery_orders/' => [$deliveryOrderController, 'createRecord'],

    // Update a delivery order by ID
    'PUT /delivery_orders/{id}/' => [$deliveryOrderController, 'updateRecord'],

    // Delete a delivery order by ID
    'DELETE /delivery_orders/{id}/' => [$deliveryOrderController, 'deleteRecord'],
];
