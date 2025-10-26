<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Challenge Page</title>
    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!--navigation icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5nI6Jj4QkI7U1vKjK+L0n4A0w4Z+T5E5R5B5B5Y5S5T5W5V5U5T5Q5V5W5X5Y5Z5"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="game.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>
    <!--NavBar-->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top"
        style="background-color: black; border-bottom: 2px solid green;">
        <div class="container-fluid container-lg">
            <a class="navbar-brand fw-bold brand-green text-info" href="index.php?action=landing">Code Together</a>
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
    <!--end of navigation-->

<div class="container-challenge space-y-8">
        <!--the challenge box-->
    <div class="challenge-box"> 
        <div class="flex justify-center">   
            <div class="box w-full md:w-8/12 p-6">
                <h1 class="text-2xl font-bold text-teal-400 mb-2">The Challenge</h1>
                <p class="text-sm">Implement a function that will recursively add all elements of an integer array.</p>
                <p class="mt-4 text-xs text-gray-400">Word Count: 500 | Difficulty: beginner</p>
            </div> 
        </div>
    </div>
    

    <!-- 2. Control Row (Switch | Timer | Switch) equal width between them-->
    <div class="row justify-content-center align-items-center mb-5 gx-3">
    
        <!-- Left Switch Box -->
        <div class="col-4 d-flex justify-content-center">
            <button class="switchA w-75">Switch A</button><!--needs to be connected to the players in team A to be able to swap-->
        </div>

        <!-- Center Timer Box (2 Columns visual width) -->
        <div class="col-4 d-flex justify-content-center">
            <div id="countdown-timer" class="timer-box mx-auto">15:00</div>
        </div>

        <!-- Right Switch Box (2 Columns visual width) -->
        <div class="col-4 d-flex justify-content-center">
            <button class="switchB w-75">Switch B</button> <!--needs to be connected to the players in team B to be able to swap-->
        </div>
    </div>
    
     <!-- 3. Main Coding Row (12-Column Grid for Desktop) -->
    <div class="row justify-content-center align-items-stretch g-3">
        <div class="col-12 col-md-2 d-flex flex-column align-items-md-start align-items-center">
            <div class="teamA">
                <div class="box-a">
                    <h2 class="text-xl font-bold text-green-400 mb-4 text-center text-md-start">Team A</h2>
                    <!-- User Profiles -->
                    <div class="space-y-3 d-flex flex-column align-items-center align-items-md-start">
                        <div class="d-flex items-center space-x-3">
                            <img src="https://placehold.co/40x40/000000/FFFFFF?text=J" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=J'" alt="User Profile J">
                            <span class="text-sm">Jona H. (Captain)</span>
                        </div>
                        <div class="d-flex items-center space-x-3">
                            <img src="https://placehold.co/40x40/000000/FFFFFF?text=K" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=K'" alt="User Profile K">
                            <span class="text-sm">Kira M.</span>
                        </div>
                        <div class="d-flex items-center space-x-3">
                            <img src="https://placehold.co/40x40/000000/FFFFFF?text=A" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=A'" alt="User Profile A">
                            <span class="text-sm">Alex R.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team A Code Editor (3 Columns) -->
        <div class="col-12 col-md-4">
            <div class="code-box">
                <textarea class="bg-transparent text-sm w-100 h-100 border-0" placeholder="// Team A Code Here..."></textarea>
            </div>
        </div>
   
        <!-- Winner Box (2 Columns) -->
        
     <!-- Team B Code Editor (4 Columns) -->
        <div class="col-12 col-md-4">
            <div class="code-box">
                <textarea class="bg-transparent text-sm w-100 h-100 border-0" placeholder="// Team B Code Here..."></textarea>
            </div>
        </div>

        <!-- Team B Info (2 Columns) -->
        <div class="col-12 col-md-2 d-flex flex-column align-items-md-end align-items-center">
            <div class="teamB">
                <div class="box-b">
                    <h2 class="text-xl font-bold text-red-300 mb-4 text-center text-md-end">Team B</h2>

                    <!-- User Profiles -->
                    <div class="space-y-3 d-flex flex-column align-items-center align-items-md-end">
                        <div class="d-flex items-center space-x-3">
                            <span class="text-sm text-md-end">Sam L. (Captain)</span>
                            <img src="https://placehold.co/40x40/000000/FFFFFF?text=S" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=S'" alt="User Profile S">
                        </div>
                        <div class="d-flex items-center space-x-3">
                            <span class="text-sm text-md-end">Ben V.</span>
                            <img src="https://placehold.co/40x40/000000/FFFFFF?text=B" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=B'" alt="User Profile B">
                        </div>
                        <div class="d-flex items-center space-x-3">
                            <span class="text-sm text-md-end">Mia G.</span>
                            <img src="https://placehold.co/40x40/000000/FFFFFF?text=M" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=M'" alt="User Profile M">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- 4. Moderator Box and Winner Box (now in a row below the main content) -->
    <div class="row justify-content-center align-items-center mt-5 mb-5 g-3">
        <div class="col-12 col-md-6 d-flex justify-content-center">
            <div class="box w-75 p-3 flex items-center justify-center space-x-4 bg-blue-900/40 rounded-3xl d-flex align-items-center">
                <img src="https://placehold.co/50x50/000000/FFFFFF?text=MOD" class="profile-pic !w-12 !h-12 !border-red-400" onerror="this.src='https://placehold.co/50x50/000000/FFFFFF?text=MOD'" alt="Moderator Profile">
                <div>
                    <span class="font-bold text-lg text-blue-300 block">Moderator</span>
                    <span class="text-sm text-blue-200">Control Panel Active</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 d-flex justify-content-center">
            <div class="box w-75 p-3 flex flex-col items-center justify-center text-center bg-yellow-900/40 rounded-3xl h-100">
                <span class="text-3xl font-extrabold text-yellow-300">WINNER</span>
                <span class="text-xs mt-2 text-yellow-200">Final results displayed here.</span>
            </div>
        </div>
    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        xintegrity="sha384-I7E8VVD/ismYTF4yFOWMaa4G8Hh8MfWfQ9SFJdFjO3/B5Gowu/Q7X9+l+O/Y5z4z0J"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        xintegrity="sha384-0pUGZvbkm6XF6gxjEnlwpMCEoV3f73SjJ+J8C6W6D2Kx5lM7B8K2FfR7R7E7Q"
        crossorigin="anonymous"></script>
    <script src="games.js"></script>
</body>
</html>
