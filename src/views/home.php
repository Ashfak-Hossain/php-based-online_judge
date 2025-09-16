<?php
require_once __DIR__ . '/../config.php';

$user = $_SESSION['user'] ?? null;
?>

<h1>Home</h1>
<?php if ($user): ?>
  <p>Welcome back, <?= htmlspecialchars($user['username']) ?>!</p>
<?php else: ?>
  <p>Please <a href="<?= BASE_URL ?>/login">log in</a> to access your account.</p>
<?php endif; ?>