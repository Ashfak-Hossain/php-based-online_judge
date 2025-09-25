<?php

namespace App\models;

use Exception;
use PDO;

class Problem
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll()
  {
    $query = $this->pdo->prepare("SELECT p.*, u.username AS created_by FROM problems p LEFT JOIN users u ON p.created_by = u.id ORDER BY created_at DESC");
    $query->execute();
    $problems = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!$problems) return [];

    $problemIds = array_column($problems, 'id');
    $placeholders = implode(',', array_fill(0, count($problemIds), '?'));

    $tagQuery = $this->pdo->prepare("SELECT pt.problem_id, t.name FROM problem_tags pt JOIN tags t ON pt.tag_id = t.id WHERE pt.problem_id IN ($placeholders)");
    $tagQuery->execute($problemIds);
    $tagsData = $tagQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tagsData as $row) {
      $tagsByProblem[$row['problem_id']][] = $row['name'];
    }

    foreach ($problems as &$problem) {
      $problem['tags'] = $tagsByProblem[$problem['id']] ?? [];
    }

    return $problems;
  }

  public function getBySlug($slug)
  {
    $query = $this->pdo->prepare("SELECT * FROM problems WHERE slug = ?");
    $query->execute([$slug]);
    return $query->fetch(PDO::FETCH_ASSOC);
  }

  public function getByTitle($title)
  {
    $query = $this->pdo->prepare("SELECT * FROM problems WHERE title = ?");
    $query->execute([$title]);
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
    $check = $this->getByTitle($data["title"]);
    if ($check) {
      throw new Exception("A problem with this title already exists");
    }
    $query = $this->pdo->prepare("INSERT INTO problems (slug, title, statement, input_format, output_format, constraints, example_input, example_output, difficulty, time_limit, memory_limit, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$query->execute([
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
    ])) {
      throw new Exception("Failed to create problem");
    };
    return $this->pdo->lastInsertId();
  }

  public function update($id, $data)
  {
    $query = $this->pdo->prepare("UPDATE problems SET slug = ?, title = ?, statement = ?, input_format = ?, output_format = ?, constraints = ?, example_input = ?, example_output = ?, difficulty = ?, time_limit = ?, memory_limit = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    if (!$query->execute([
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
    ])) {
      throw new Exception("Failed to update problem");
    };
    return true;
  }

  public function delete($id)
  {
    $query = $this->pdo->prepare("DELETE FROM problems WHERE id = ?");
    if (!$query->execute([$id])) {
      throw new Exception("Failed to delete problem");
    }
    return true;
  }

  public function findOrCreateTag($tagName)
  {
    $query = $this->pdo->prepare("SELECT id FROM tags WHERE name = ?");
    $query->execute([$tagName]);
    $id = $query->fetchColumn();
    if ($id) return $id;
    $insert = $this->pdo->prepare("INSERT INTO tags (name) VALUES (?)");
    if (!$insert->execute([$tagName])) {
      throw new Exception("Failed to create new tag");
    }
    return $this->pdo->lastInsertId();
  }

  public function attachTag($problemId, $tagId)
  {
    $query = $this->pdo->prepare("INSERT IGNORE INTO problem_tags (problem_id, tag_id) VALUES (?, ?)");
    if (!$query->execute([$problemId, $tagId])) {
      throw new Exception("Failed to attach tag to problem");
    }
  }

  public function beginTransaction()
  {
    $this->pdo->beginTransaction();
  }

  public function commit()
  {
    $this->pdo->commit();
  }

  public function rollBack()
  {
    $this->pdo->rollBack();
  }
}
