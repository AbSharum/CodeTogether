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
    <link rel="stylesheet" href="/public/css/home.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>
    <!--NavBar-->
    <?php include __DIR__ .'/../includes/navbar.php'; ?>
    <!--end of navigation-->

    <div class="container-layout space-y-6">
        <!--the challenge box-->
        <div class="flex justify-center">
           <div class="box w-full md:w-8/12 p-6 bg-gray-700/30">
            <h1 class="text-2xl font-bold text-teal-400 mb-2">The Challenge:</h1>
            <p class="text-sm">Implement a function that will recursively add all elements of an integer array.</p>
            <p class="mt-4 text-xs text-gray-400">Word Count: 500 | Difficulty: beginner</p>
        </div> 
    </div>

    <!-- 2. Control Row (Switch | Timer | Switch) -->
    <div class="flex justify-center space-x-4 md:space-x-8">
        <!-- Left Switch Box (2 Columns visual width) -->
        <div class="switch-box w-2">
            <span class="switch">Switch</span> <!--needs to be connected to the players in team A to be able to swap-->
        </div>

        <!-- Center Timer Box (2 Columns visual width) -->
        <div class="timer w-2">
            <span class="countdown">04:30</span>
        </div>

        <!-- Right Switch Box (2 Columns visual width) -->
        <div class="switch-box w-2">
            <span class="switch">Switch</span> <!--needs to be connected to the players in team B to be able to swap-->
        </div>
    </div>
    
     <!-- 3. Main Coding Row (12-Column Grid for Desktop) -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">

        <!-- Team A Info (2 Columns) -->
        <div class="teamA">
            <div class="boxA">
                <h2 class="text-xl font-bold text-green-300 mb-4">Team A</h2>

                <!-- User Profiles -->
                <div class="space-y-3">
                    <div class="flex items-left space-x-3">
                        <img src="https://placehold.co/40x40/000000/FFFFFF?text=J" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=J'" alt="User Profile J">
                        <span class="text-sm">Jona H. (Captain)</span>
                    </div>
                    <div class="flex items-left space-x-3">
                        <img src="https://placehold.co/40x40/000000/FFFFFF?text=K" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=K'" alt="User Profile K">
                        <span class="text-sm">Kira M.</span>
                    </div>
                    <div class="flex items-left space-x-3">
                        <img src="https://placehold.co/40x40/000000/FFFFFF?text=A" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=A'" alt="User Profile A">
                        <span class="text-sm">Alex R.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team A Code Editor (3 Columns) -->
        <div class="col-span-1 md:col-span-3">
            <div class="code-box">
                <textarea class="w-full h-full bg-transparent text-sm focus:outline-none resize-none" placeholder="// Team A Code Here..."></textarea>
            </div>
        </div>

        <!-- Winner Box (2 Columns) -->
        

        <!-- Team B Code Editor (3 Columns) -->
        <div class="col-span-1 md:col-span-3">
            <div class="box code-box bg-gray-800/80">
                <textarea class="w-full h-full bg-transparent text-sm focus:outline-none resize-none" placeholder="// Team B Code Here..."></textarea>
            </div>
        </div>

        <!-- Team B Info (2 Columns) -->
        <div class="col-span-1 md:col-span-2 space-y-4">
            <div class="box bg-red-900/40 p-3">
                <h2 class="text-xl font-bold text-red-300 mb-4">Team B</h2>

                <!-- User Profiles -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 justify-end md:justify-start">
                        <span class="text-sm font-medium">Sam L. (Captain)</span>
                        <img src="https://placehold.co/40x40/000000/FFFFFF?text=S" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=S'" alt="User Profile S">
                    </div>
                    <div class="flex items-center space-x-3 justify-end md:justify-start">
                        <span class="text-sm">Ben V.</span>
                        <img src="https://placehold.co/40x40/000000/FFFFFF?text=B" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=B'" alt="User Profile B">
                    </div>
                    <div class="flex items-center space-x-3 justify-end md:justify-start">
                        <span class="text-sm">Mia G.</span>
                        <img src="https://placehold.co/40x40/000000/FFFFFF?text=M" class="profile-pic" onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=M'" alt="User Profile M">
                    </div>
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
            <script src="/public/js/game.js"></script>
</body>
</html>
