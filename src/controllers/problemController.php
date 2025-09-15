<?php

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
    $data = $request["post"];
    $errors = [];
    if (empty($data["title"])) $errors[] = "Title is required";
    if (empty($data["statement"])) $errors[] = "Statement is required";
    if (empty($data["slug"])) $errors[] = "Slug is required";
  }
}
