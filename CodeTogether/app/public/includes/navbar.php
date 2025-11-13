<?php
  $rain = isset($_SESSION['rain_enabled']) ? (bool) $_SESSION['rain_enabled'] : false;
  $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'dark';

  //Brings in the loading screen
  include __DIR__ . '/loadingScreen.php';
?>

<link rel="stylesheet" href="/public/css/container/navbar.css">
<link rel="stylesheet" href="/public/css/core/main.css">
<nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-matrix">
  <div class="container-fluid container-lg">
    <a class="navbar-brand fw-bold nav-fade justify-content-start" href="index.php?action=landing"><i class="fa-solid fa-code"></i> Code
      Together</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-lg-center w-100 gap-2">
        <li class="nav-item flex-grow-1">
          <form class="d-flex w-100" role="search" action="index.php?action=search" method="POST">
            <input class="form-control me-2" type="search" name="search" placeholder="Search..." aria-label="Search">
            <button class="btn btn-outline-success" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </li>
        <li class="nav-item"><a class="nav-link  nav-fade" href="index.php?action=home"><i
              class="fas fa-home me-1"></i>Home</a></li>
        <li class="nav-item dropdown" aria-current="page">
          <a class="nav-link  nav-fade dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fas fa-gamepad me-1"></i> Games
          </a>
          <ul class="dropdown-menu custom-dropdown">
            <li><a class="dropdown-item custom-dropdown-item active" aria-current="page"
                href="index.php?action=game">Code Battle</a></li>
            <li><a class="dropdown-item custom-dropdown-item" href="index.php?action=cards">FlashCards</a></li>
            <!-- more game links will go here -->
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link  nav-fade" href="index.php?action=messages"><i
              class="fas fa-envelope me-1"></i>Messages</a></li>
        <li class="nav-item"><a class="nav-link  nav-fade" href="index.php?action=profile"><i
              class="fas fa-user me-1"></i>Profile</a></li>
        <li class="nav-item"><a class="nav-link  nav-fade" href="index.php?action=accountSettings"><i
              class="fas fa-cog me-1"></i>Settings</a></li>
        <li class="nav-item"><a class="nav-link  nav-fade" href="index.php?action=login"><i class="fa fa-sign-in"
              style="color: blue"></i> Login</a></li>
        <li class="nav-item"><a class="nav-link  nav-fade" href="index.php?action=logout"><i class="fa fa-sign-out"
              style="color: red"></i> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<script>
  window.rainEnabled = <?php echo $rain ? 'true' : 'false'; ?>;
  (function () { document.documentElement.setAttribute('data-theme', <?php echo json_encode($theme); ?>); })();
</script>
