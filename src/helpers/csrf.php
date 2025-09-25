<?php
function verifyCsrfToken()
{
  $token = $_POST["csrf"] ?? $_SERVER["HTTP_X_CSRF_TOKEN"] ?? '';
  if (!hash_equals($_SESSION["csrf"] ?? "", $token)) {
    http_response_code(403);
    die("CSRF token validation failed");
  }
}
