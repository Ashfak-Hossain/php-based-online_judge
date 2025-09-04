<?php
require_once dirname(__DIR__) . "/src/router.php";

$router = new Router([
  "basePath" => "/online_judge/public",
  "viewDir" => dirname(__DIR__) . "/src/views"
]);

// Authentication
$router->get("/login", "auth/login");
$router->get("/signup", "auth/signup");


$router->get("/", "home");
$router->get('/user/$id', function ($id) {
  echo "User: $id";
});

// Error Pages
$router->setNotFound("not_found");

$router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
