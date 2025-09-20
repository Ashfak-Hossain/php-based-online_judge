<?php
/* Showing error */
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

require_once dirname(__DIR__) . "/src/router.php";
require_once dirname(__DIR__) . "/src/config.php";
require_once dirname(__DIR__) . "/src/controllers/AuthController.php";
require_once dirname(__DIR__) . "/src/middleware/AuthMiddleware.php";
require_once dirname(__DIR__) . "/src/controllers/problemController.php";

$router = new Router([
  "basePath" => BASE_URL,
  "viewDir" => dirname(__DIR__) . "/src/views"
]);

/* Controllers */
$authController = new AuthController($pdo);
$problemController = new ProblemController($pdo);

/* Middlewares */
$auth = new AuthMiddleware(BASE_URL);
$authGuest = new AuthMiddleware(BASE_URL, [], true);
$authAdmin = new AuthMiddleware(BASE_URL, ["admin", "super_admin"]);
$authSuperAdmin = new AuthMiddleware(BASE_URL, ["super_admin"]);

/* Authentication Routes */
$router->get("/logout", [$authController, "logout"], [$auth]);
$router->get("/login", [$authController, "loginForm"], [$authGuest]);
$router->get("/signup", [$authController, "signupForm"], [$authGuest]);

$router->post("/login", [$authController, "login"]);
$router->post("/signup", [$authController, "signup"]);


/* Problems management Routes */
// $router->get("/admin/problems", [$problemController, "index"], [$authAdmin]);
$router->get("/admin/problems/create", [$problemController, "createForm"], [$authAdmin]);
// $router->get("/admin/problems/edit/$slug", [$problemController, "editForm"], [$authAdmin]);

$router->post("/admin/problems/create", [$problemController, "create"], [$authAdmin]);
// $router->post("/admin/problems/edit/$slug", [$problemController, "edit"], [$authAdmin]);
// $router->post("/admin/problems/delete/$slug", [$problemController, "delete"], [$authAdmin]);


/* Home Route */
$router->get("/", "home", [$auth]);

/* Error Pages */
$router->setNotFound("not_found");

$router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
