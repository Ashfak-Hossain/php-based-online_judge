<?php

require_once __DIR__ . "/../models/problem.php";

use App\models\Problem;

class SubmissionController
{
  private $submissionModel;

  public function __construct($submissionModel)
  {
    $this->submissionModel = $submissionModel;
  }

  public function store($request)
  {
    header('Content-Type: application/json');

    $userId = $_SESSION['user']['id'];
    $slug = $request['params']['slug'] ?? null;
    $post = $request['post'] ?? [];

    $code = trim($post['code'] ?? '');
    $language = trim($post['language'] ?? '');

    if (!$slug || !$code || !$language) {
      echo json_encode([
        'success' => false,
        'message' => 'Problem slug, code, and language are required.'
      ]);
      exit;
    }

    $problemModel = new Problem($this->submissionModel->pdo);
    $problem = $problemModel->getBySlug($slug);

    try {
      $submissionId = $this->submissionModel->create([
        'user_id' => $userId,
        'problem_id' => $problem['id'],
        'code' => $code,
        'language' => $language,
        'status' => 'pending'
      ]);

      echo json_encode([
        'success' => true,
        'message' => 'Submission received successfully.',
        'submissionId' => $submissionId
      ]);
    } catch (Exception $e) {
      echo json_encode([
        'success' => false,
        'message' => 'Failed to create submission: ' . $e->getMessage()
      ]);
    }
  }
}
