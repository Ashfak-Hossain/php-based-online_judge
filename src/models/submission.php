<?php

class Submission
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }


  public function create(array $data)
  {
    $statement = $this->pdo->prepare("INSERT INTO submissions (user_id, problem_id, code, language, status) VALUES (?, ?, ?, ?, ?)");

    if (!$statement->execute([
      $data['user_id'],
      $data['problem_id'],
      $data['code'],
      $data['language'],
      $data['status'] ?? 'pending'
    ])) {
      throw new Exception("Failed to create submission");
    }

    return $this->pdo->lastInsertId();
  }

  public function getByProblem($problemId)
  {
    $statement = $this->pdo->prepare("SELECT s.*, u.username FROM submissions s JOIN users u ON s.user_id = u.id WHERE s.problem_id = ? ORDER BY s.created_at DESC");
    $statement->execute([$problemId]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getByUser($userId)
  {
    $statement = $this->pdo->prepare("SELECT s.*, p.title AS problem_title FROM submissions s JOIN problems p ON s.problem_id = p.id WHERE s.user_id = ? ORDER BY s.created_at DESC");
    $statement->execute([$userId]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $statement = $this->pdo->prepare("SELECT * FROM submissions WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  public function updateStatus($id, $status)
  {
    $statement = $this->pdo->prepare("UPDATE submissions SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    if (!$statement->execute([$status, $id])) {
      throw new Exception("Failed to update submission status");
    }
    return true;
  }
}
