<?php
require_once __DIR__ . "/../models/User.php";

class AuthController
{
  private $userModel;

  public function __construct($pdo)
  {
    $this->userModel = new User($pdo);
  }

  public function signupForm()
  {
    require __DIR__ . "/../views/auth/signup.php";
  }

  public function loginForm()
  {
    require __DIR__ . "/../views/auth/login.php";
  }

  public function login()
  {
    session_start();
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $user = $this->userModel->verifyPassword($username, $password);
    if ($user) {
      session_regenerate_id(true);
      $_SESSION["user"] = [
        "id" => $user["id"],
        "username" => $user["username"],
        "role" => $user["role"],
      ];
      header("Location: /online_judge/public/");
      exit;
    }

    $error = "Invalid username or password.";
    require __DIR__ . "/../views/auth/login.php";
  }

  public function signup()
  {
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $errors = [];

    if ($this->userModel->findByUsername($username)) {
      $errors["username"] = "Username already exists";
    }
    if ($this->userModel->findByEmail($email)) {
      $errors["email"] = "Email already used";
    }

    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/';
    if (!preg_match($passwordPattern, $password)) {
      $errors["password"] = "Password must be at least 6 char long including upper, lower, number and special character at least once";
    }

    if (!empty($errors)) {
      require __DIR__ . "/../views/auth/signup.php";
      return;
    }

    $this->userModel->create($username, $email, $password);
    header("Location: /online_judge/public/login");
    exit;
  }
}
