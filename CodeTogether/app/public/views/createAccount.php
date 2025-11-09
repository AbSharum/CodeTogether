<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
    <title>Code Together Account Creation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="/public/css/core/main.css">
    <link rel="stylesheet" href="/public/css/page/createAccount.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>

    <main class="page-create">
        <div class="card create-card">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Code Together Account Creation</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=createAccount" method="POST" id="registration">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <label for="password" class="form-label muted">(Must include upper, lower, number, and
                            symbol)</label>
                        <input type="password" class="form-control" id="password" name="password"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" required>

                        <ul id="password-requirements" class="password-requirements mt-2">
                            <li data-req="lower">Lowercase letter</li>
                            <li data-req="upper">Uppercase letter</li>
                            <li data-req="number">Number</li>
                            <li data-req="special">Special character</li>
                            <li data-req="length">At least 8 characters</li>
                        </ul>
                    </div>


                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="" disabled selected>Select your role...</option>
                            <option value="1">Moderator</option>
                            <option value="2">Student</option>
                            <option value="3">Teacher</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="roleKey" class="form-label">Access Key (only for Moderator/Teacher)</label>
                        <input type="password" class="form-control" id="roleKey" name="roleKey"
                            placeholder="Enter key if required">
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Create Account</button>
                    </div>
                </form>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success"
                        onclick="window.location.href='index.php?action=login'">
                        Return to Login
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/core/status.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>