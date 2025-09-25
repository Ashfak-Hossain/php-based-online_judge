<?php
require_once __DIR__ . '/../../config.php';

$user = $_SESSION['user'] ?? null;
?>
<nav class="bg-[#1f1f1f] border-b border-[#222] shadow z-50 sticky top-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-14">
      <!-- Logo -->
      <div class="flex-shrink-0 flex items-center">
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-2">
          <span class="text-xl font-bold text-white tracking-tight">CP</span>
          <span class="hidden sm:inline text-sm text-gray-400 font-semibold">Arena</span>
        </a>
      </div>

      <!-- Main Nav -->
      <div class="flex-1 flex items-center justify-center">
        <div class="flex space-x-4">
          <a href="<?= BASE_URL ?>/" class="flex items-center gap-1 text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
            <i data-lucide="home" class="w-5 h-5 text-gray-400 hover:text-white"></i>
            Home
          </a>
          <a href="<?= BASE_URL ?>/problems" class="flex items-center gap-1 text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
            <i data-lucide="file-text" class="w-5 h-5 text-gray-400 hover:text-white"></i>
            Problems
          </a>
        </div>
      </div>

      <!-- User/Login -->
      <div class="flex items-center space-x-2">
        <?php if ($user): ?>
          <a href="<?= BASE_URL ?>/profile" class="flex items-center gap-2 px-3 py-2 text-gray-200 hover:text-indigo-400 hover:underline focus:outline-none">
            <i data-lucide="user" class="w-6 h-6 text-gray-400 hover:text-indigo-400"></i>
            <span class="font-semibold text-white hidden sm:inline"><?= htmlspecialchars($user['username']) ?></span>
          </a>
          <a href="<?= BASE_URL ?>/logout" class="flex items-center gap-1 text-red-400 hover:text-red-500 hover:underline px-3 py-2 rounded-md text-sm font-medium ml-2">
            <i data-lucide="log-out" class="w-5 h-5 text-red-400 hover:text-red-500"></i>
            <span class="hidden sm:inline">Logout</span>
          </a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/login" class="flex items-center gap-1 text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
            <i data-lucide="log-in" class="w-5 h-5 text-gray-400 hover:text-white"></i>
            Sign In
          </a>
          <a href="<?= BASE_URL ?>/signup" class="flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-medium">
            <i data-lucide="user-plus" class="w-5 h-5 text-gray-400 hover:text-white"></i>
            Sign Up
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>