<?php

class User
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function create(string $username, string $email, string $password)
  {
    $hashedPass = password_hash($password, PASSWORD_BCRYPT);
    $q = $this->pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    return $q->execute([$username, $email, $hashedPass]);
  }

  public function findByUsername(string $username)
  {
    $q = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
    $q->execute([$username]);
    return $q->fetch(PDO::FETCH_ASSOC);
  }

  public function findByEmail(string $email)
  {
    $q = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $q->execute([$email]);
    return $q->fetch(PDO::FETCH_ASSOC);
  }

  public function verifyPasswordByEmail(string $email, string $password)
  {
    $user = $this->findByEmail($email);
    if ($user && password_verify($password, $user['password_hash'])) {
      return $user;
    }
  }
}
