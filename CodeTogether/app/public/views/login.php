<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Code Together</title>

    <!-- Bootstrap & Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="stylesheet" href="/public/css/core/main.css">
    <link rel="stylesheet" href="/public/css/page/login.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>

    <main class="page-login">
        <div class="container">
            <div class="card login-card p-4 mx-auto">
                <h2 class="card-title mb-4 text-center">Code Together Login</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=login" method="POST">
                    <div class="mb-3">
                        <label for="identifier" class="form-label">Username or Email</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>

                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="showPassword"
                                    onclick="togglePassword()">
                                <label class="form-check-label" for="showPassword">Show Password</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Access System</button>
                    </div>
                </form>

                <div class="d-grid gap-2 mb-3">
                    <button type="button" class="btn btn-success"
                        onclick="window.location.href='index.php?action=createAccount'">Create Account</button>
                </div>

                <div class="login-links">
                    <a href="index.php?action=privacyPolicy">Privacy Policy</a>
                    <a href="index.php?action=terms">Terms and Conditions</a>
                </div>
            </div>
        </div>
    </main>


    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/page/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>