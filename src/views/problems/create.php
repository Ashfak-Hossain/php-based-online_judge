<?php
$tags = include __DIR__ . '/../../helpers/tags.php';
?>

<div class="border border-b border-dashed p-4 rounded bg-transparent">
  <form action="" method="POST" class="space-y-8">

    <div class="border-b border-gray-300 pb-6">
      <h2 class="text-xl font-semibold text-gray-900">
        Create Problem
      </h2>
      <p class="mt-1 text-sm text-gray-600">Please fill out the form below to create a new problem.</p>
    </div>

    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
      <div>
        <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
        <input type="text" id="title" name="title" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>

      <div>
        <label for="difficulty" class="block text-sm font-medium text-gray-900">Difficulty</label>
        <select id="difficulty" name="difficulty"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        </select>
      </div>

      <div>
        <label for="tags" class="block text-sm font-medium text-gray-900">Tags</label>
        <select name="tags[]" id="tags" multiple
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-32 overflow-y-auto"
          size="5">
          <?php foreach ($tags as $tag): ?>
            <option value="<?= htmlspecialchars($tag) ?>"><?= htmlspecialchars($tag) ?></option>
          <?php endforeach; ?>
        </select>
        <p class="mt-1 text-xs text-gray-400">Hold Ctrl (Windows) or Cmd (Mac) to select multiple tags.</p>
      </div>

      <div>
        <label for="time_limit" class="block text-sm font-medium text-gray-900">Time Limit (ms)</label>
        <input id="time_limit" name="time_limit" type="number" min="100" max="10000"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="2000" />
      </div>

      <div>
        <label for="memory_limit" class="block text-sm font-medium text-gray-900">Memory Limit (MB)</label>
        <input id="memory_limit" name="memory_limit" type="number" min="16" max="4096"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="256" />
      </div>
    </div>

    <div class="grid grid-cols-1 gap-y-6">
      <div>
        <label for="statement" class="block text-sm font-medium text-gray-900">Statement</label>
        <textarea id="statement" name="statement" rows="5" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
      <div>
        <label for="input_format" class="block text-sm font-medium text-gray-900">Input Format</label>
        <textarea id="input_format" name="input_format" rows="2" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
      <div>
        <label for="output_format" class="block text-sm font-medium text-gray-900">Output Format</label>
        <textarea id="output_format" name="output_format" rows="2" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
      <div>
        <label for="constraints" class="block text-sm font-medium text-gray-900">Constraints</label>
        <textarea id="constraints" name="constraints" rows="2"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
      <div>
        <label for="example_input" class="block text-sm font-medium text-gray-900">Example Input</label>
        <textarea id="example_input" name="example_input" rows="2"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
      <div>
        <label for="example_output" class="block text-sm font-medium text-gray-900">Example Output</label>
        <textarea id="example_output" name="example_output" rows="2"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
    </div>
    <div class="pt-3">
      <button type="submit"
        class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Create Problem
      </button>
    </div>
  </form>
</div>