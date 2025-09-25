<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
  <div class="mb-8">
    <h1 class="text-4xl font-semibold text-gray-900 mb-2"><?= htmlspecialchars($problem['title']) ?></h1>
    <div class="flex flex-wrap items-center space-x-3 mt-2">
      <!-- Difficulty Badge -->
      <?php
      $difficultyColors = [
        'easy' => 'bg-green-100 text-green-800',
        'medium' => 'bg-yellow-100 text-yellow-800',
        'hard' => 'bg-red-100 text-red-800'
      ];
      $difficultyClass = $difficultyColors[strtolower($problem['difficulty'])] ?? 'bg-gray-100 text-gray-800';
      ?>
      <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $difficultyClass ?>">
        <?= ucfirst($problem['difficulty']) ?>
      </span>

      <!-- Tags -->
      <?php $tags = $problem['tags'] ?? []; ?>
      <?php if (!empty($tags)): ?>
        <?php foreach ($tags as $tag): ?>
          <span class="px-2 py-0.5 bg-gray-200 text-gray-800 rounded-full text-xs font-medium hover:bg-gray-300 transition duration-150">
            <?= htmlspecialchars($tag) ?>
          </span>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="space-y-8">
    <div>
      <h2 class="text-2xl font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">Problem Statement</h2>
      <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($problem['statement']) ?></div>
    </div>

    <?php if (!empty($problem['input_format'])): ?>
      <div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Input</h3>
        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($problem['input_format']) ?></p>
      </div>
    <?php endif; ?>

    <?php if (!empty($problem['output_format'])): ?>
      <div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Output</h3>
        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($problem['output_format']) ?></p>
      </div>
    <?php endif; ?>

    <?php if (!empty($problem['constraints'])): ?>
      <div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Constraints</h3>
        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($problem['constraints']) ?></p>
      </div>
    <?php endif; ?>

    <?php if (!empty($problem['example_input']) || !empty($problem['example_output'])): ?>
      <div>
        <h2 class="text-2xl font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">Example</h2>
        <div class="grid md:grid-cols-2 gap-4 mt-4">
          <?php if (!empty($problem['example_input'])): ?>
            <div>
              <h4 class="text-sm font-semibold text-gray-600 mb-1">Input</h4>
              <pre class="bg-gray-50 border border-gray-200 rounded-md p-4 font-mono text-sm"><code><?= htmlspecialchars($problem['example_input']) ?></code></pre>
            </div>
          <?php endif; ?>
          <?php if (!empty($problem['example_output'])): ?>
            <div>
              <h4 class="text-sm font-semibold text-gray-600 mb-1">Output</h4>
              <pre class="bg-gray-50 border border-gray-200 rounded-md p-4 font-mono text-sm"><code><?= htmlspecialchars($problem['example_output']) ?></code></pre>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="border-t border-gray-200 my-10"></div>

  <div>
    <h2 class="text-2xl font-semibold mb-2">Submit Your Solution</h2>
    <form id="problem-submit-form" data-problem-id="<?= $problem['id'] ?>" class="space-y-4">
      <div>
        <label for="language" class="block font-medium mb-1">Language</label>
        <select name="language" id="language" class="w-full border rounded p-2">
          <option value="cpp">C++</option>
          <!-- <option value="python">Python</option> -->
          <!-- <option value="java">Java</option> -->
        </select>
      </div>

      <div>
        <label for="code" class="block font-medium mb-1">Your Code</label>
        <textarea name="code" id="code" rows="10" class="w-full border rounded p-2 font-mono"></textarea>
        <p class="error-text text-red-500 text-xs mt-1"></p>
      </div>

      <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Submit
      </button>
    </form>
  </div>
</div>