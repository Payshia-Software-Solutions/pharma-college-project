<?php
// config/database.php

$host = "91.204.209.19";
$db_name = "payshiac_d_pos";
$username = "payshiac";
$password = "1999tr@thilina";
$GLOBALS['pdo'] = null;

try {
    $GLOBALS['pdo'] = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $GLOBALS['pdo']->exec("set names utf8");
} catch(PDOException $exception) {
    echo json_encode([
        "message" => "Connection error: " . $exception->getMessage()
    ]);
    exit();
}
