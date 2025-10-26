<nav class="navbar navbar-expand-lg navbar-dark sticky-top"
        style="background-color: black; border-bottom: 2px solid green;">
        <div class="container-fluid container-lg">
            <a class="navbar-brand fw-bold brand-green text-info" href="index.php?action=landing">Code Together</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <form class="d-flex w-100 w-lg-auto me-lg-3" style="max-width: 300px;" role="search" action="index.php?action=search" method="POST">
                    <input class="form-control me-2 w-100"
                        type="search"
                        name="search"
                        placeholder="Search..."
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                    <ul class="navbar-nav">
                    <li class="nav-item" id="home-nav-item">
                        <a class="nav-link text-white" href="index.php?action=home"><i class="fas fa-home me-1"></i>
                            Home</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="game-nav-item">
                        <a class="nav-link text-white" href="/public/views/game.html"><i
                                class="fas fa-gamepad me-1"></i> Game Page</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="message-nav-item">
                        <a class="nav-link text-white" href="index.php?action=messages"><i
                                class="fas fa-envelope me-1"></i> Messages</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="accountSettings-nav-item">
                        <a class="nav-link text-white" href="index.php?action=accountSettings"><i
                                class="fas fa-cog me-1"></i> Account Settings</a> <!--need to verify correct paths -->
                    </li>
                    <li class="nav-item" id="login-nav-item">
                        <a class="nav-link text-white" href="index.php?action=login"><i class="fa fa-sign-in" style="color: blue"></i> Login</a> <!--need to actually log user out-->
                    </li>
                    <li class="nav-item" id="logout-nav-item">
                        <a class="nav-link text-white" href="index.php?action=logout"><i class="fa fa-sign-out" style="color: red"></i>Logout</a> <!--need to actually log user out-->
                    </li>
                </ul>
            </div>
        </div>
    </nav>