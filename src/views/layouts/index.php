<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Online Judge' ?></title>

  <!-- Tailwind -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

  <!-- toastify -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
  <?php include __DIR__ . "/../components/nav.php"; ?>

  <?php if ($user && ($user["role"] !== "user")): ?>
    <?php include  __DIR__ . "/../components/adminHeading.php"; ?>
  <?php endif; ?>

  <main class="flex-grow py-6">
    <?php include $content; ?>
  </main>

  <!-- Toastify JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      lucide.createIcons();
    });
  </script>
</body>

</html>