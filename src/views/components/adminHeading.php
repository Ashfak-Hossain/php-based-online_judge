<div class="lg:flex lg:items-center lg:justify-between border border-dashed border-gray-400 px-6 py-4 rounded mx-3 my-6 bg-transparent">
  <div class="min-w-0 flex-1">
    <h2 class="text-2xl font-bold text-gray-800 sm:text-3xl sm:tracking-tight">Admin Panel</h2>
    <div class="mt-2 flex flex-wrap gap-4">
      <a href="<?= BASE_URL ?>/admin/problems" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Manage Problems</a>
      <a href="<?= BASE_URL ?>/admin/users" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Manage Users</a>
      <a href="<?= BASE_URL ?>/admin/submissions" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Submissions</a>
    </div>
  </div>
  <div class="mt-4 lg:mt-0 lg:ml-4 flex gap-2">
    <a href="<?= BASE_URL ?>/admin/problems/create" class="inline-flex items-center rounded-md border border-indigo-300 px-3 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50">
      <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="mr-1.5 -ml-0.5 size-5 text-indigo-700">
        <path d="M10 5v10m5-5H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      New Problem
    </a>
  </div>
</div>