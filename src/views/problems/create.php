<?php
$tags = include __DIR__ . '/../../helpers/tags.php';
$formAction = BASE_URL . '/admin/problems/create';
?>

<div class="border border-b border-dashed p-4 rounded bg-transparent">
  <form action="<?= $formAction ?>" method="POST" class="space-y-8" data-module="problem-create">

    <div class="border-b border-gray-300 pb-6">
      <h2 class="text-xl font-semibold text-gray-900">
        Create Problem
      </h2>
      <p class="mt-1 text-sm text-gray-600">Please fill out the form below to create a new problem.</p>
    </div>

    <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
      <!-- Title -->
      <div>
        <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
        <input type="text" id="title" name="title" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Difficulty -->
      <div>
        <label for="difficulty" class="block text-sm font-medium text-gray-900">Difficulty</label>
        <select id="difficulty" name="difficulty"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        </select>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Tags -->
      <div>
        <label for="tags" class="block text-sm font-medium text-gray-900">Tags</label>
        <select name="tags[]" id="tags" multiple
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-32 overflow-y-auto"
          size="5">
          <?php foreach ($tags as $tag): ?>
            <option value="<?= htmlspecialchars($tag) ?>"><?= htmlspecialchars($tag) ?></option>
          <?php endforeach; ?>
        </select>
        <p class="error-text text-red-500 text-xs mt-1"></p>
        <p class="mt-1 text-xs text-gray-400">Hold Ctrl (Windows) or Cmd (Mac) to select multiple tags.</p>
      </div>

      <!-- Time limit -->
      <div>
        <label for="time_limit" class="block text-sm font-medium text-gray-900">Time Limit (ms)</label>
        <input id="time_limit" name="time_limit" type="number" min="100" max="10000"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="2000" />
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Memory Limit -->
      <div>
        <label for="memory_limit" class="block text-sm font-medium text-gray-900">Memory Limit (MB)</label>
        <input id="memory_limit" name="memory_limit" type="number" min="16" max="4096"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="256" />
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-y-6 gap-x-6">
      <!-- Statement -->
      <div>
        <label for="statement" class="block text-sm font-medium text-gray-900">Statement</label>
        <textarea id="statement" name="statement" rows="5" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Input format -->
      <div>
        <label for="input_format" class="block text-sm font-medium text-gray-900">Input Format</label>
        <textarea id="input_format" name="input_format" rows="5" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Output format -->
      <div>
        <label for="output_format" class="block text-sm font-medium text-gray-900">Output Format</label>
        <textarea id="output_format" name="output_format" rows="2" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Constraints -->
      <div>
        <label for="constraints" class="block text-sm font-medium text-gray-900">Constraints</label>
        <textarea id="constraints" name="constraints" rows="2"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <!-- Example input -->
      <div>
        <label for="example_input" class="block text-sm font-medium text-gray-900">Example Input</label>
        <textarea id="example_input" name="example_input" rows="2"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>


      <!-- Example output -->
      <div>
        <label for="example_output" class="block text-sm font-medium text-gray-900">Example Output</label>
        <textarea id="example_output" name="example_output" rows="2"
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>
    </div>

    <!-- Test Cases Section -->
    <div class="border-t border-gray-300 pt-8 mt-8">
      <h3 class="text-lg font-semibold text-gray-900 mb-2">Test Cases</h3>
      <p class="text-sm text-gray-600 mb-4">Add the test cases for this problem.</p>
      <div id="test-cases-list" class="space-y-8">
        <!-- Test case items  -->
      </div>
      <button type="button" id="add-testcase-btn"
        class="mt-4 inline-flex items-center rounded-md bg-indigo-100 px-3 py-1.5 text-sm font-medium text-indigo-700 hover:bg-indigo-200 border border-indigo-300 transition-colors">
        + Add Test Case
      </button>
    </div>

    <!-- Submit button -->
    <div class="pt-3">
      <button type="submit"
        class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Create Problem
      </button>
    </div>
  </form>
</div>
</form>
</div>

<script>
  const testCasesList = document.getElementById('test-cases-list');
  const addBtn = document.getElementById('add-testcase-btn');
  let testCaseIdx = 0;

  function createTestCase(idx) {
    const wrapper = document.createElement('div');
    wrapper.className = "p-4 border border-gray-200 rounded bg-gray-50";
    wrapper.innerHTML = `
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-900" for="testcases[${idx}][input]">Input</label>
        <textarea name="testcases[${idx}][input]" rows="2" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-900" for="testcases[${idx}][output]">Output</label>
        <textarea name="testcases[${idx}][output]" rows="2" required
          class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
      </div>
    </div>
    <button type="button" class="remove-testcase-btn mt-4 text-xs text-red-600 hover:underline">Remove</button>
  `;
    // Remove button
    wrapper.querySelector('.remove-testcase-btn').onclick = function() {
      wrapper.remove();
    };
    return wrapper;
  }

  function addTestCase() {
    const tc = createTestCase(testCaseIdx++);
    testCasesList.appendChild(tc);
  }

  addBtn.addEventListener('click', addTestCase);
  addTestCase();
</script>