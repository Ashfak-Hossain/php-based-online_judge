<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In</h2>

    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php
    if (!empty($_SESSION['toast'])) {
      require_once __DIR__ . "/../../helpers/toast.php";
      $toast = $_SESSION['toast'];
      showToast($toast['message'], $toast['type']);
      unset($_SESSION['toast']);
    }
    ?>

    <form method="POST" action="<?= BASE_URL ?>/login" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input
          type="email"
          name="email"
          value="<?= htmlspecialchars($emailValue ?? '') ?>"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
          placeholder="your@email.com"
          required />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <input
            id="passwordInput"
            type="password"
            name="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all pr-10 text-black"
            placeholder="••••••••"
            required />
          <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
            <i data-lucide="eye"></i>
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <!-- <label class="flex items-center">
          <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label> -->
        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a>
      </div>

      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
        Sign In
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      Don't have an account?
      <a href="<?= BASE_URL ?>/signup" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign up</a>
    </div>
  </div>
  <script>
    document.getElementById("togglePassword").addEventListener("click", function() {
      const pwdInput = document.getElementById("passwordInput");
      if (pwdInput.type === "password") {
        pwdInput.type = "text";
        this.innerHTML = '<i data-lucide="eye-off"></i>';
      } else {
        pwdInput.type = "password";
        this.innerHTML = '<i data-lucide="eye"></i>';
      }
      // won't work without added in the last
      lucide.createIcons();
    });
  </script>
</div>