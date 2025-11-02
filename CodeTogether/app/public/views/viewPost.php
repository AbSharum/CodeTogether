<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($user->getUserName()) ?>'s Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/public/css/core/main.css">
  <link rel="stylesheet" href="/public/css/page/profile.css">
</head>

<body>
  <canvas id="matrix-canvas"></canvas>

  <?php include __DIR__ . '/../includes/navbar.php'; ?>
  <script src="/public/js/ai.js"></script>
  <script src="/public/js/profile.js"></script>

  <main class="page-profile">
    <div class="main container py-5">
      <div class="row justify-content-center">

        <!-- Middle column: posts -->
        <section class="col-lg-6 mb-4">
              <?php include __DIR__ . '/../includes/postVisual.php'; ?>
        </section>
      </div>
    </div>
  </main>
  <script src="/public/js/core/theme.js"></script>
  <script src="/public/js/core/rain.js"></script>
  <script src="/public/js/page/post.js"></script>

  <!--Need this for the bootstrap plus Popper for drop downs and other cool things.-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>

</html>