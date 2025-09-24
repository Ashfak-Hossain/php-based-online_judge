<?php

use App\models\Problem;

require_once __DIR__ . "/../models/problem.php";
require_once __DIR__ . "/../helpers/makeSlug.php";

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
    var_dump($problems);
  }

  public function create($request)
  {
    $post = $request["post"];
    $title = trim($post["title"] ?? "");
    $slug = createSlug($title);
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


//  { [0]
// => array(16) { ["id"]
// => int(27) ["slug"]
// => string(6) "-itles" ["title"]
// => string(6) "Titles" ["statement"]
// => string(9) "Statement" ["input_format"]
// => string(5) "Input" ["output_format"]
// => string(6) "output" ["constraints"]
// => string(4) "cons" ["example_input"]
// => string(2) "ex" ["example_output"]
// => string(2) "ex" ["difficulty"]
// => string(4) "easy" ["time_limit"]
// => int(2000) ["memory_limit"]
// => int(256) ["created_at"]
// => string(19) "2025-09-25 02:50:57" ["updated_at"]
// => string(19) "2025-09-25 02:50:57" ["created_by"]
// => string(6) "ashfak" ["tags"]
// => array(0) { } } [1]
// => array(16) { ["id"]
// => int(26) ["slug"]
// => string(5) "-itle" ["title"]
// => string(5) "Title" ["statement"]
// => string(9) "Statement" ["input_format"]
// => string(19) "1 123 1231 23123" ["output_format"]
// => string(20) "12313 1231 2312 3" ["constraints"]
// => string(6) "123123" ["example_input"]
// => string(19) "123123 123 12 31" ["example_output"]
// => string(18) "1231231 31 23 1" ["difficulty"]
// => string(4) "easy" ["time_limit"]
// => int(2000) ["memory_limit"]
// => int(256) ["created_at"]
// => string(19) "2025-09-24 21:39:39" ["updated_at"]
// => string(19) "2025-09-24 21:39:39" ["created_by"]
// => string(6) "ashfak" ["tags"]
// => array(3) { [0]
// => string(2) "dp" [1]
// => string(6) "greedy" [2]
// => string(5) "graph" } } }