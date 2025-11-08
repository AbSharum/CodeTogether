<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

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
    <link rel="stylesheet" href="/public/css/core/main.css">
    <link rel="stylesheet" href="/public/css/page/game.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>
    <!--NavBar-->
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <!--end of navigation-->
    <main class="page-game">
        <div class="container-fluid container-lg py-5">
            <!--the challenge box-->
            <div class="challenge-box">
                <div class="row justify-content-center">
                    <div class="col-12 col-mid-10 p-2">
                        <h1 class="text-2xl font-bold text-teal-400 mb-2">The Challenge</h1>
                        <p class="text-lg">Implement a function that will recursively add all elements of an integer
                            array.
                        </p>
                        <p class="mt-4 text-xs text-secondary">Word Count: 500 | Difficulty: beginner</p>
                    </div>
                </div>
            </div>


            <!-- 2. Control Row (Switch | Timer | Switch) equal width between them-->
            <div class="row justify-content-center align-items-center mb-5 gx-3">

                <!-- Left Switch Box -->
                <div class="col-4  col-md-3 d-flex justify-content-center">
                    <button class="switchA w-75">Switch
                        A</button><!--needs to be connected to the players in team A to be able to swap-->
                </div>

                <!-- Center Timer Box (2 Columns visual width) -->
                <div class="col-4 col-md-4 d-flex justify-content-center">
                    <div id="countdown-timer" class="timer-box mx-auto">15:00</div>
                </div>

                <!-- Right Switch Box (2 Columns visual width) -->
                <div class="col-4 col-md-4 d-flex justify-content-center">
                    <button class="switchB w-75">Switch B</button>
                    <!--needs to be connected to the players in team B to be able to swap-->
                </div>
            </div>

            <!-- 3. Main Coding Row (12-Column Grid for Desktop) -->
            <div class="row justify-content-center align-items-stretch g-3">
                <!--Team A info-->
                <div class="col-12 col-md-2 d-flex flex-column align-items-md-start align-items-center">
                    <div class="team-info-box teamA-style w-100">
                        <h2 class="text-xl font-bold text-primary mb-4 text-center text-md-start">Team A</h2>
                        <!-- User Profiles -->
                        <div class="space-y-3 d-flex flex-column align-items-start align-items-md-start">
                            <div class="d-flex align-items-center space-x-3 mb-2">
                                <img src="https://placehold.co/40x40/000000/FFFFFF?text=J" class="profile-pic"
                                    onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=J'"
                                    alt="User Profile J"> <!--needs db info -->
                                <span class="text-sm">Jona H. (Captain)</span>
                            </div>
                            <div class="d-flex align-items-center space-x-3 mb-2">
                                <img src="https://placehold.co/40x40/000000/FFFFFF?text=K" class="profile-pic"
                                    onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=K'"
                                    alt="User Profile K"> <!--needs db info -->
                                <span class="text-sm">Kira M.</span>
                            </div>
                            <div class="d-flex align-items-center space-x-3 mb-2">
                                <img src="https://placehold.co/40x40/000000/FFFFFF?text=A" class="profile-pic"
                                    onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=A'"
                                    alt="User Profile A"> <!--needs db info -->
                                <span class="text-sm">Alex R.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Team A Code Editor (3 Columns) -->
                <div class="col-12 col-md-4">
                    <div class="code-box">
                        <textarea placeholder="// Team A Code Here..."></textarea>
                    </div>
                </div>
                <!-- Team B Code Editor (4 Columns) -->
                <div class="col-12 col-md-4">
                    <div class="code-box">
                        <textarea placeholder="// Team B Code Here..."></textarea>
                    </div>
                </div>

                <!-- Team B Info (2 Columns) -->
                <div class="col-12 col-md-2 d-flex flex-column align-items-md-end align-items-center">
                    <div class="team-info-box teamB-style w-100">
                        <h2 class="text-xl font-bold text-danger mb-4 text-center text-md-end">Team B</h2>
                        <!-- User Profiles -->
                        <div class="space-y-3 d-flex flex-column align-items-end align-items-md-end">
                            <div class="d-flex align-items-center space-x-3 mb-2">
                                <span class="text-sm text-md-end me-2">Sam L. (Captain)</span>
                                <img src="https://placehold.co/40x40/000000/FFFFFF?text=S" class="profile-pic"
                                    onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=S'"
                                    alt="User Profile S">
                            </div>
                            <div class="d-flex align-items-center space-x-3 mb-2">
                                <span class="text-sm text-md-end me-2">Ben V.</span>
                                <img src="https://placehold.co/40x40/000000/FFFFFF?text=B" class="profile-pic"
                                    onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=B'"
                                    alt="User Profile B">
                            </div>
                            <div class="d-flex align-items-center space-x-3 mb-2">
                                <span class="text-sm text-md-end me-2">Mia G.</span>
                                <img src="https://placehold.co/40x40/000000/FFFFFF?text=M" class="profile-pic"
                                    onerror="this.src='https://placehold.co/40x40/000000/FFFFFF?text=M'"
                                    alt="User Profile M">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Moderator Box and Winner Box (now in a row below the main content) -->
            <!-- will need db info and php here too for moderator -->
            <!-- moderator has control only for the timer to start. must click the timer to begin countdown-->
            <div class="row justify-content-center mt-5 mb-4 g-3">
                <div class="col-12 d-flex justify-content-center">
                    <div class="box w-100 p-3 d-flex align-items-center rounded-3xl"
                        style="background-color: rgba(0, 0, 100, 0.4); max-width: 400px;">
                        <img src=" https://placehold.co/50x50/000000/FFFFFF?text=MOD" class="profile-pic"
                            style="width: 50px; height: 50px; border-color: #0307ff;" alt="Moderator Profile">
                        <div class="ms-3">
                            <span class="font-bold text-lg text-info d-block">Moderator</span>
                            <span class="text-sm text-light">Control Panel Active</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--Winner modal box-->
            <div id="winnerModal" class="modal fade" tabindex="-1" aria-labelledby="winnerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content winner-popup-content">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title w-100 text-center font-extrabold text-white" id="winnerModalLabel">
                                CHALLENGE COMPLETE!</h5>
                        </div>
                        <div class="modal-body pt-0 text-center">
                            <h1 id="winningTeamName" class="display-3 font-extrabold text-uppercase">Team A Wins!</h1>
                            <p class="text-light mt-3">Congratulations on completing the code challenge.</p>
                        </div>
                        <div class="modal-footer border-0 pt-0 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary text-light"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        xintegrity="sha384-I7E8VVD/ismYTF4yFOWMaa4G8Hh8MfWfQ9SFJdFjO3/B5Gowu/Q7X9+l+O/Y5z4z0J"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        xintegrity="sha384-0pUGZvbkm6XF6gxjEnlwpMCEoV3f73SjJ+J8C6W6D2Kx5lM7B8K2FfR7R7E7Q"
        crossorigin="anonymous"></script>
    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/page/games.js"></script>

</body>

</html>