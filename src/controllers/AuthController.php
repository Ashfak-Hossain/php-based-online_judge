<?php
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../helpers/toast.php";

class AuthController
{
  private $userModel;

  public function __construct($pdo)
  {
    $this->userModel = new User($pdo);
  }

  public function signupForm()
  {
    $title = "Sign Up";
    $content = __DIR__ . "/../views/auth/signup.php";
    require __DIR__ . "/../views/layouts/auth.php";
  }

  public function loginForm()
  {
    $title = "Log In";
    $content = __DIR__ . "/../views/auth/login.php";
    require __DIR__ . "/../views/layouts/auth.php";
  }

  public function login($request)
  {
    $error = "";
    $email = $request["post"]["email"] ?? "";
    $password = $request["post"]["password"] ?? "";

    $user = $this->userModel->verifyPasswordByEmail($email, $password);
    if ($user) {
      session_regenerate_id(true);
      $_SESSION["user"] = [
        "id" => $user["id"],
        "username" => $user["username"],
        "email" => $user["email"],
        "role" => $user["role"],
      ];
      $_SESSION["toast"] = ["message" => "Logged in successfully.", "type" => "success"];
      header("Location:" . BASE_URL);
      exit;
    }

    $error = "Invalid email or password.";
    $title = "Log In";
    $emailValue = $email;
    $passwordValue = $password;
    $content = __DIR__ . "/../views/auth/login.php";
    require __DIR__ . "/../views/layouts/auth.php";
  }

  public function signup($request)
  {
    $errors = [];
    $username = $request["post"]["username"] ?? "";
    $email = $request["post"]["email"] ?? "";
    $password = $request["post"]["password"] ?? "";

    if ($this->userModel->findByUsername($username)) {
      $errors["username"] = "Username already exists";
    }
    if ($this->userModel->findByEmail($email)) {
      $errors["email"] = "Email already used";
    }

    //! For development purpose only
    // $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/';
    // if (!preg_match($passwordPattern, $password)) {
    //   $errors["password"] = "Password must be at least 6 char long including upper, lower, number and special character at least once";
    // }

    if (!empty($errors)) {
      $title = "Sign Up";
      $content = __DIR__ . "/../views/auth/signup.php";
      require __DIR__ . "/../views/layouts/auth.php";
      return;
    }

    // create user
    $this->userModel->create($username, $email, $password);
    $_SESSION["toast"] = ["message" => "Account created successfully. Please log in.", "type" => "success"];
    header("Location:" . BASE_URL . "/login");
    exit;
  }
}
