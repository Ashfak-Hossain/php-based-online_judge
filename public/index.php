<?php
/* Showing error */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once dirname(__DIR__) . "/src/router.php";
require_once dirname(__DIR__) . "/src/config.php";
require_once dirname(__DIR__) . "/src/controllers/AuthController.php";
require_once dirname(__DIR__) . "/src/middleware/AuthMiddleware.php";

$router = new Router([
  "basePath" => BASE_URL,
  "viewDir" => dirname(__DIR__) . "/src/views"
]);

$authController = new AuthController($pdo);

$authSuperAdmin = new AuthMiddleware(BASE_URL, ['super_admin']);
$adminAuth = new AuthMiddleware(BASE_URL, ['admin']);
$guestAuth = new AuthMiddleware(BASE_URL, [], true);
$auth = new AuthMiddleware(BASE_URL);

$router->get("/signup", [$authController, "signupForm"], [$guestAuth]);
$router->post("/signup", [$authController, "signup"]);
$router->get("/login", [$authController, "loginForm"], [$guestAuth]);
$router->post("/login", [$authController, "login"]);


$router->get("/", "home", [$adminAuth]);
$router->get('/user/$id', function ($id) {
  echo "User: $id";
}, [$auth]);

// Error Pages
$router->setNotFound("not_found");

$router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
