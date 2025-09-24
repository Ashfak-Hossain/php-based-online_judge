<div class="p-6 bg-white rounded-lg shadow">
  <h1 class="text-2xl font-semibold mb-4">Problems</h1>
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ID</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Title</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Difficulty</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tags</th>
          <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Created By</th>
          <th class="px-4 py-2 text-right text-sm font-medium text-gray-600">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white">
        <?php foreach ($problems as $problem): ?>
          <tr>
            <td class="px-4 py-2 text-sm text-gray-800"><?= $problem['id'] ?></td>
            <td class="px-4 py-2 text-sm text-blue-600 font-medium">
              <?= htmlspecialchars($problem['title']) ?>
            </td>
            <td class="px-4 py-2 text-sm">
              <?php if ($problem['difficulty'] === 'easy'): ?>
                <span class="px-2 py-1 text-green-800 bg-green-100 rounded-full text-xs">Easy</span>
              <?php elseif ($problem['difficulty'] === 'medium'): ?>
                <span class="px-2 py-1 text-yellow-800 bg-yellow-100 rounded-full text-xs">Medium</span>
              <?php else: ?>
                <span class="px-2 py-1 text-red-800 bg-red-100 rounded-full text-xs">Hard</span>
              <?php endif; ?>
            </td>
            <td class="px-4 py-2 text-sm">
              <?php foreach ($problem['tags'] as $tag): ?>
                <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded mr-1">
                  <?= htmlspecialchars($tag) ?>
                </span>
              <?php endforeach; ?>
            </td>
            <td class="px-4 py-2 text-sm text-gray-600"><?= htmlspecialchars($problem['created_by']) ?></td>
            <td class="px-4 py-2 text-sm text-right">
              <a href="<?= BASE_URL ?>/admin/problems/<?= $problem['id'] ?>/edit" class="text-blue-600 hover:underline mr-3">Edit</a>
              <form action="<?= BASE_URL ?>/admin/problems/<?= $problem['id'] ?>/delete" method="POST" class="inline">
                <button type="submit" class="text-red-600 hover:underline">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>