<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Settings</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="/public/css/core/main.css" />
  <link rel="stylesheet" href="/public/css/page/accountSettings.css" />
</head>

<body>
  <canvas id="matrix-canvas"></canvas>
  <?php include __DIR__ . '/../includes/navbar.php'; ?>

  <main class="page-account">
    <div class="card account-card">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Code Together Account Settings</h2>

        <?php if (!empty($data['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($data['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form action="index.php?action=accountSettings" method="POST" class="mb-3">
          <input type="hidden" name="update" value="username">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username"
            value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>
          <button type="submit" class="btn btn-success w-100 mt-2">
            <i class="fas fa-user-pen me-2"></i> Save Username
          </button>
        </form>

        <form action="index.php?action=accountSettings" method="POST" class="mb-3">
          <input type="hidden" name="update" value="email">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email"
            value="<?= htmlspecialchars($data['email'] ?? '') ?>" required>
          <button type="submit" class="btn btn-success w-100 mt-2">
            <i class="fas fa-envelope me-2"></i> Save Email
          </button>
        </form>

        <form action="index.php?action=accountSettings" method="POST" class="mb-3">
          <input type="hidden" name="update" value="password">
          <label for="password" class="form-label">Password</label>
          <label for="password" class="form-label muted">(Must include upper, lower, number, and
            symbol)</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password"
            required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" required>
          <button type="submit" class="btn btn-success w-100 mt-2">
            <i class="fas fa-lock me-2"></i> Update Password
          </button>
        </form>

        <form action="index.php?action=accountSettings" method="POST">
          <input type="hidden" name="update" value="preferences">
          <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="rain" name="rain" <?= (!empty($data['rain_enabled']) && $data['rain_enabled']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="rain">Enable Matrix Rain</label>
          </div>
          <div class="mt-3">
            <label class="form-label">Theme</label>
            <select name="theme" class="form-select">
              <?php $t = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'dark'; ?>
              <option value="dark" <?= $t === 'dark' ? 'selected' : '' ?>>Dark</option>
              <option value="light" <?= $t === 'light' ? 'selected' : '' ?>>Light</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success w-100 mt-3">Save Preferences</button>
        </form>
      </div>
    </div>
  </main>

  <script src="/public/js/core/theme.js"></script>
  <script src="/public/js/core/rain.js"></script>
  <script src="/public/js/core/status.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>