<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<div class="border border-dashed border-gray-400 rounded bg-transparent my-6 p-4 lg:flex lg:items-center lg:justify-between">
  <div class="min-w-0 flex-1">
    <h2 class="text-2xl font-bold text-gray-800 sm:text-3xl sm:tracking-tight">Admin Panel</h2>
    <nav class="mt-2 flex flex-wrap gap-2">
      <?php
      $links = [
        ['Problems', BASE_URL . '/admin/problems'],
        ['Users', BASE_URL . '/admin/users'],
        ['Submissions', BASE_URL . '/admin/submissions'],
        ['Add Problem', BASE_URL . '/admin/problems/create'],
      ];
      foreach ($links as [$label, $url]) {
        $isActive = $currentPath === parse_url($url, PHP_URL_PATH);
        echo '<a href="' . $url . '" class="px-2 py-1 rounded text-sm font-medium transition text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' .
          ($isActive ? ' underline underline-offset-4 text-indigo-700' : '') .
          '">' . $label . '</a>';
      }
      ?>
    </nav>
  </div>
</div>