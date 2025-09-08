<h2>Sign Up</h2>
<form method="POST" action="<?= BASE_URL ?>/signup">
  <div>
    <label>Username:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
    <?php if (!empty($errors['username'])): ?>
      <p style="color:red;"><?= htmlspecialchars($errors['username']) ?></p>
    <?php endif; ?>
  </div>

  <div>
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
    <?php if (!empty($errors['email'])): ?>
      <p style="color:red;"><?= htmlspecialchars($errors['email']) ?></p>
    <?php endif; ?>
  </div>

  <div>
    <label>Password:</label>
    <input type="password" name="password" required>
    <?php if (!empty($errors['password'])): ?>
      <p style="color:red;"><?= htmlspecialchars($errors['password']) ?></p>
    <?php endif; ?>
  </div>

  <button type="submit">Sign Up</button>
</form>

<p>Already have an account? <a href="<?= BASE_URL ?>/login">Login</a></p>