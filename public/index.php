<?php
/* Showing error */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . "/src/router.php";
require_once dirname(__DIR__) . "/src/config.php";
require_once dirname(__DIR__) . "/src/controllers/AuthController.php";

$router = new Router([
  "basePath" => "/online_judge/public",
  "viewDir" => dirname(__DIR__) . "/src/views"
]);

// Authentication
$authController = new AuthController($pdo);

$router->get("/signup", [$authController, "signupForm"]);
$router->post("/signup", [$authController, "signup"]);
$router->get("/login", [$authController, "loginForm"]);
$router->post("/login", [$authController, "login"]);


$router->get("/", "home");
$router->get('/user/$id', function ($id) {
  echo "User: $id";
});

// Error Pages
$router->setNotFound("not_found");

$router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
