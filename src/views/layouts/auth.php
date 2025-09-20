<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="base-url" content="<?= BASE_URL ?>" />
  <meta name="csrf-token" content="<?= $_SESSION['csrf'] ?? "" ?>" />

  <title><?= $title ?? 'Online Judge' ?></title>

  <!-- Tailwind -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <!-- toastify -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
  <main class="flex-grow container mx-auto px-4 py-6">
    <?php include $content; ?>
  </main>

  <!-- Toastify JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- Main js -->
  <script type="module" src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>

</html>