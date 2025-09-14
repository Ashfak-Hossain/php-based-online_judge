<?php
class Problem
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll()
  {
    $query = $this->pdo->prepare("SELECT * FROM problems ORDER BY created_at DESC");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getBySlug($slug)
  {
    $query = $this->pdo->prepare("SELECT * FROM problems WHERE slug = ?");
    $query->execute([$slug]);
    return $query->fetch(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $query = $this->pdo->prepare("SELECT * FROM problems WHERE id = ?");
    $query->execute([$id]);
    return $query->fetch(PDO::FETCH_ASSOC);
  }

  public function create($data)
  {
    $query = $this->pdo->prepare("INSERT INTO problems (slug, title, statement, input_format, output_format, constraints, example_input, example_output, difficulty, time_limit, memory_limit, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->execute([
      $data["slug"],
      $data["title"],
      $data["statement"],
      $data["input_format"],
      $data["output_format"],
      $data["constraints"],
      $data["example_input"],
      $data["example_output"],
      $data["difficulty"] ?? 'easy',
      $data["time_limit"] ?? 2000,
      $data["memory_limit"] ?? 256,
      $data["created_by"] ?? null
    ]);
    return $this->pdo->lastInsertId();
  }

  public function update($id, $data)
  {
    $query = $this->pdo->prepare("UPDATE problems SET slug = ?, title = ?, statement = ?, input_format = ?, output_format = ?, constraints = ?, example_input = ?, example_output = ?, difficulty = ?, time_limit = ?, memory_limit = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    return $query->execute([
      $data["slug"],
      $data["title"],
      $data["statement"],
      $data["input_format"],
      $data["output_format"],
      $data["constraints"],
      $data["example_input"],
      $data["example_output"],
      $data["difficulty"] ?? 'easy',
      $data["time_limit"] ?? 2000,
      $data["memory_limit"] ?? 256,
      $id
    ]);
  }

  public function delete($id)
  {
    $query = $this->pdo->prepare("DELETE FROM problems WHERE id = ?");
    return $query->execute([$id]);
  }
}
