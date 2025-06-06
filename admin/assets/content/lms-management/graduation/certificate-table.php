<?php
require __DIR__ . '/../../../../vendor/autoload.php';
define('PARENT_SEAT_RATE', 500);

// For use env file data & HTTP client
use Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 4))->load();
$client = HttpClient::create();

$LoggedUser = $_POST['LoggedUser'];
$UserLevel = $_POST['UserLevel'];

if (strtolower($UserLevel) != 'admin') die('Access denied');

$courseCode = $_POST['courseCode'] ?? null;
$showSession = $_POST['showSession'] ?? null;

$packageBookings = $client->request('GET', $_ENV['SERVER_URL'] . '/convocation-registrations')->toArray();
