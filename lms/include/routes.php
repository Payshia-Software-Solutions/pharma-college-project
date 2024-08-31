<?php
// public/index.php
require './router.php';
require './routes/web.php';
require './controllers/HomeController.php';
require './controllers/UserController.php';
require './controllers/PostController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($uri);
