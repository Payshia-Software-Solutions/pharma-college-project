<?php

require_once './controllers/DeliverySettingController.php';

$pdo = $GLOBALS['pdo'];
$deliverySettingController = new DeliverySettingController($pdo);

return [
    'GET /delivery-settings/' => function () use ($deliverySettingController) {
        $deliverySettingController->getAll();
    },

    'GET /delivery-settings/{id}/' => function ($id) use ($deliverySettingController) {
        $deliverySettingController->getById($id);
    },

    'POST /delivery-settings/' => function () use ($deliverySettingController) {
        $deliverySettingController->create();
    },

    'PUT /delivery-settings/{id}/' => function ($id) use ($deliverySettingController) {
        $deliverySettingController->update($id);
    },

    'DELETE /delivery-settings/{id}/' => function ($id) use ($deliverySettingController) {
        $deliverySettingController->delete($id);
    },
    'GET /delivery-settings/course/{courseId}/' => function ($courseId) use ($deliverySettingController) {
        $deliverySettingController->getByCourseId($courseId);
    },

];
