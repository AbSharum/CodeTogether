<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Access Denied | Code Together</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/core/main.css" />
    <link rel="stylesheet" href="/public/css/page/AccessDenied.css" />
</head>

<body>
    <canvas id="matrix-canvas"></canvas>

    <main class="page-denied">
        <h1 class="access-denied-text">ACCESS DENIED</h1>
        <p class="lead mb-5">You do not have permission to access this page.<br>
            Please return to a secure area of the system.</p>

        <button onclick="window.location.href='/index.php?action=home'" class="btn-return">
            Return to the Source
        </button>
    </main>

    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/core/status.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>