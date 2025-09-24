<?php

use App\models\Problem;

require_once __DIR__ . "/../models/problem.php";

class ProblemController
{
  private $problemModel;

  public function __construct($pdo)
  {
    $this->problemModel = new Problem($pdo);
  }

  public function createForm()
  {
    $title = "Create Problem";
    $content = __DIR__ . "/../views/problems/create.php";
    require __DIR__ . "/../views/layouts/index.php";
  }

  public function index()
  {
    $problems = $this->problemModel->getAll();
    $content = __DIR__ . "/../views/problems/index.php";
    require __DIR__ . "/../views/layouts/index.php";
  }

  public function create($request)
  {
    $post = $request["post"];
    $title = trim($post["title"] ?? "");
    $slug = $title ? strtolower(preg_replace("/[^a-z0-9-]+/", "-", $title)) : "";
    $statement = trim($post["statement"] ?? "");
    $difficulty = trim($post["difficulty"] ?? "easy");
    $timeLimit = trim($post["time_limit"] ?? "2000");
    $memoryLimit = trim($post["memory_limit"] ?? "256");
    $inputFormat = trim($post["input_format"] ?? "");
    $outputFormat = trim($post["output_format"] ?? "");
    $constraints = trim($post["constraints"] ?? "");
    $exampleInput = trim($post["example_input"] ?? "");
    $exampleOutput = trim($post["example_output"] ?? "");
    $tags = $post["tags"] ?? [];

    $errors = [];
    if ($title === "") $errors["title"] = "Title is required.";
    if ($slug === "") $errors["slug"] = "Slug is required.";
    if ($statement === "") $errors["statement"] = "Statement is required.";

    if ($this->problemModel->getByTitle($title)) $errors["title"] = "Title already exists.";
    if ($this->problemModel->getBySlug($slug)) $errors["slug"] = "Slug already exists.";

    if (!empty($errors)) {
      header("Content-Type: application/json");
      echo json_encode([
        "success" => false,
        "errors" => $errors
      ]);
      exit;
    }

    try {
      $this->problemModel->beginTransaction();

      $problemId = $this->problemModel->create([
        "slug" => $slug,
        "title" => $title,
        "statement" => $statement,
        "input_format" => $inputFormat,
        "output_format" => $outputFormat,
        "constraints" => $constraints,
        "example_input" => $exampleInput,
        "example_output" => $exampleOutput,
        "difficulty" => $difficulty,
        "time_limit" => $timeLimit,
        "memory_limit" => $memoryLimit,
        "created_by" => $_SESSION["user"]["id"]
      ]);

      foreach ($tags as $tag) {
        $tag = strtolower(trim($tag));
        $tagId = $this->problemModel->findOrCreateTag($tag);
        $this->problemModel->attachTag($problemId, $tagId);
      }

      $this->problemModel->commit();

      header("Content-Type: application/json");
      echo json_encode([
        "success" => true,
        "message" => "Problem created successfully",
        "problemId" => $problemId
      ]);
      exit;
    } catch (Exception $e) {
      $this->problemModel->rollBack();

      header("Content-Type: application/json");
      echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
      ]);
      exit;
    }
  }
}
