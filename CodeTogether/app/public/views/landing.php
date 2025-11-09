<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome | Code Together</title>

  <!-- Bootstrap + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Global & Page-specific CSS -->
  <link rel="stylesheet" href="/public/css/core/main.css" />
  <link rel="stylesheet" href="/public/css/page/landing.css" />
</head>

<body>
  <canvas id="matrix-canvas"></canvas>
  <?php include __DIR__ . '/../includes/navbar.php'; ?>
  <main class="page-landing">
    <div class="container position-relative">
      <div class="card main-card p-4 text-center">
        <h2 class="card-title mb-4">What Do You Choose?</h2>
        <p class="quote mb-3">“The Matrix is everywhere. It is all around us. Even now, in this very room.”</p>
        <p>Welcome to <strong>Code Together</strong>! Here you will collaborate, compete, and connect with other people
          intrested in computer science.</p>
        <button class="btn btn-success mt-2" onclick="window.location.href='index.php?action=login'">
          Enter the Rabbit Hole
        </button>
      </div>

      <div class="feature-row">
        <div class="card info-card">
          <div class="feature-icon"><i class="fa-solid fa-users"></i></div>
          <h5>Community</h5>
          <p>Meet developers and grow together.</p>
        </div>
        <div class="card info-card">
          <div class="feature-icon"><i class="fa-solid fa-code"></i></div>
          <h5>Coding Activities</h5>
          <p>Challenge your friends, sharpen your skills, and climb the leaderboard together.</p>
        </div>
        <div class="card info-card">
          <div class="feature-icon"><i class="fa-solid fa-brain"></i></div>
          <h5>AI Companion</h5>
          <p>Get real-time help from an AI chatbot.</p>
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