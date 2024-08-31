<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "uni_erp";
$database_error = "";

/* Attempt to connect to MySQL database */
$ad_conn = mysqli_connect($server, $username, $password, $database);

// Check connection

if ($ad_conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else {
    $database_error = "Connected to the Server";
}


$server = "localhost";
$username = "root";
$password = "";
$database = "pharmaco_pharmacollege";
$database_error = "";

/* Attempt to connect to MySQL database */
$link = mysqli_connect($server, $username, $password, $database);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else {
    $database_error = "Connected to the Server";
}



// PDO
$pdo = new PDO('mysql:host=' . $server . ';dbname=' . $database,  $username, $password);

// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Establish LMS Connection
$server = "localhost";
$username = "root";
$password = "";
$database = "pharmaco_posinspirelk";
$database_error = "";

/* Attempt to connect to MySQL database */
$pos_link = mysqli_connect($server, $username, $password, $database);

// Check connection

if ($pos_link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else {
    $database_error = "Connected to the Server";
}

mysqli_set_charset($link, "utf8");
date_default_timezone_set("Asia/Colombo");

$SiteTitle = "Ceylon Pharma College";
