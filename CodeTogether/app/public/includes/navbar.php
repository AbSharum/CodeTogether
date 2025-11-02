<!--Loading Screen. Threw it here since we are most likely going to have the navbar on everypage anyways.-->
<?php include __DIR__ . '/loadingScreen.php'; ?>


<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top"
        style="background-color: black; border-bottom: 2px solid green;">
        <div class="container-fluid container-lg">
            <a class="navbar-brand justify-content-start fw-bold brand-green text-info" href="index.php?action=profile">Code Together</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                <form class="d-flex w-50 w-lg-auto me-lg-3" style="max-width: 200px;" role="search" action="index.php?action=search" method="POST">
                    <input class="form-control me-2 w-100"
                        type="search"
                        name="search"
                        placeholder="Search..."
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                    
                    <li class="nav-item" id="home-nav-item">
                        <a class="nav-link text-white nav-fade" href="index.php?action=home"><i class="fas fa-home me-1"></i>
                            Home</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item dropdown" aria-current="page">
                        <a class="nav-link text-white nav-fade dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-gamepad me-1"></i> Games
                        </a>
                        <ul class="dropdown-menu custom-dropdown">
                            <li><a class="dropdown-item custom-dropdown-item active" aria-current="page" href="#">Game Page (Current)</a></li>
                            <li><a class="dropdown-item custom-dropdown-item" href="#">FlashCards</a></li>
                            <li><a class="dropdown-item custom-dropdown-item" href="#">Code Challenges</a></li>
                            <li><a class="dropdown-item custom-dropdown-item" href="#">RunTime Analysis</a></li>
                        </ul>
                    </li>
                    <li class="nav-item" id="message-nav-item">
                        <a class="nav-link text-white nav-fade" href="index.php?action=messages"><i
                                class="fas fa-envelope me-1"></i> Messages</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="game-nav-item">
                        <a class="nav-link text-white nav-fade" href="index.php?action=profile"><i
                                class="fas fa-solid fa-user"></i> Profile Page</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="accountSettings-nav-item">
                        <a class="nav-link text-white nav-fade" href="index.php?action=accountSettings"><i
                                class="fas fa-cog me-1"></i> Account Settings</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="login-nav-item">
                        <a class="nav-link text-white nav-fade" href="index.php?action=login"><i class="fa fa-sign-in" style="color: blue"></i> Login</a> <!--need to actually log user out-->
                    </li>
                    <li class="nav-item" id="logout-nav-item">
                        <a class="nav-link text-white nav-fade" href="index.php?action=logout"><i class="fa fa-sign-out" style="color: red"></i>Logout</a> <!--need to actually log user out-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>