<?php
class AuthMiddleware
{
  private string $baseUrl;
  private array $allowedRoles;
  private bool $guestOnly;

  public function __construct(string $baseUrl, array $allowedRoles = [], bool $guestOnly = false)
  {
    $this->baseUrl = $baseUrl;
    $this->allowedRoles = $allowedRoles;
    $this->guestOnly = $guestOnly;
  }

  public function handle($request, callable $next)
  {
    $user = $request['session']['user'] ?? null;
    if ($this->guestOnly) {
      if ($user) {
        header("Location: " . $this->baseUrl . "/");
        exit();
      }
      return $next($request);
    }

    if (empty($user)) {
      header("Location: " . $this->baseUrl . "/login");
      exit();
    }

    if (!empty($this->allowedRoles)) {
      $userRole = $user['role'];
      if (!in_array($userRole, $this->allowedRoles, true)) {
        http_response_code(403);
        echo "403 Forbidden: Access Denied";
        exit();
      }
    }
    return $next($request);
  }
}
