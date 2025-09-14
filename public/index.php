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

$auth = new AuthMiddleware(BASE_URL);
$authGuest = new AuthMiddleware(BASE_URL, [], true);
$authAdmin = new AuthMiddleware(BASE_URL, ['admin']);
$authSuperAdmin = new AuthMiddleware(BASE_URL, ['super_admin']);

/* Authentication Routes */
$router->get("/signup", [$authController, "signupForm"], [$authGuest]);
$router->get("/login", [$authController, "loginForm"], [$authGuest]);

$router->post("/signup", [$authController, "signup"]);
$router->post("/login", [$authController, "login"]);


/* Problems management Routes */
$router->get("/admin/problems", [$problemController, "index"], [$authAdmin]);
$router->get("/admin/problems/create", [$problemController, "createForm"], [$authAdmin]);
$router->get("/admin/problems/edit/$slug", [$problemController, "editForm"], [$authAdmin]);

$router->post("/admin/problems/create", [$problemController, "create"], [$authAdmin]);
$router->post("/admin/problems/edit/$slug", [$problemController, "edit"], [$authAdmin]);
$router->post("/admin/problems/delete/$slug", [$problemController, "delete"], [$authAdmin]);


/* Home Route */
$router->get("/", "home", [$auth]);
$router->get('/user/$id', function ($id) {
  echo "User: $id";
}, [$auth]);

/* Error Pages */
$router->setNotFound("not_found");

$router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
