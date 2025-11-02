<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 | Code Together</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/public/css/core/main.css" />
  <link rel="stylesheet" href="/public/css/page/404Error.css" />
</head>

<body>
  <canvas id="matrix-canvas"></canvas>

  <main class="page-404">
    <div class="card matrix-card text-center mx-auto">
      <div class="card-body">
        <h1 class="display-1 fw-bold mb-3 text-matrix-green">404</h1>
        <h2 class="h4 mb-3 animate-pulse">Page Not Found</h2>
        <p class="lead mb-4">
          The page you're looking for doesn't exist, has been moved, or has chosen to hide within the Matrix.<br>
          Don't worry, even the best developers occasionally lose their way.
        </p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
          <button onclick="window.location.href='/index.php?action=home'" class="btn-blue-pill">
            Return to home
          </button>
          <button onclick="window.location.href='/index.php?action=landing'" class="btn-red-pill">
            Return to landing
          </button>
        </div>
      </div>
    </div>
  </main>

  <script src="/public/js/core/theme.js"></script>
  <script src="/public/js/core/rain.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>