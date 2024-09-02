<?php
// config/database.php
$host = '109.70.148.53';
$db   = 'pharmaco_pharmacollege';
$user = 'pharmaco_admin';
$pass = 'pharmaadmin';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


// Connect to Webserver

// $host = '109.70.148.53';
// $db   = 'pharmaco_pharmacollege';
// $user = 'pharmaco_admin';
// $pass = 'pharmaadmin';
// $charset = 'utf8mb4';
// $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=$charset";