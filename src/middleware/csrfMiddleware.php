<?php
require_once __DIR__ . "/../helpers/csrf.php";

class CsrfMiddleware
{
  public function __construct() {}

  public function handle($request, callable $next)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      verifyCsrfToken();
    }
    return $next($request);
  }
}
