<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminology Matching </title>
    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!--navigation icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5nI6Jj4QkI7U1vKjK+L0n4A0w4Z+T5E5R5B5B5Y5S5T5W5V5U5T5Q5V5W5X5Y5Z5"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--core css-->
    <link rel="stylesheet" href="/public/css/core/main.css">
    <link rel="stylesheet" href="/public/css/page/FlashCards.css">
</head>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<body class="min-h-screen p-4 sm:p-8 flex items-center justify-centerr">
    <canvas id="matrix-canvas"></canvas>

    <div id="app" class="w-full max-w-5xl bg-gray-900/90 p-6 sm:p-10 rounded-lg shadow-2xl shadow-green-500/50">
        <!-- Header -->
        <h1 class="text-4xl sm:text-5xl font-bold text-center mb-4 matrix-text tracking-wider">
            SYSTEM TERMINOLOGY: MATCH
        </h1>
        <p class="text-center text-green-400/70 mb-8 text-lg">
            Connect the Term to its correct Definition. Failure is not an option.
        </p>

        <!-- Score and Controls -->
        <div
            class="flex flex-col sm:flex-row justify-between items-center mb-10 p-4 border-b border-t border-green-700/50">
            <div class="matrix-text text-xl font-bold mb-3 sm:mb-0">
                Score: <span id="score">0</span> / <span id="total-matches">0</span>
            </div>
            <button id="restart-button"
                class="px-6 py-2 matrix-text bg-gray-800 rounded-lg shadow-lg hover:shadow-green-500/70 transition duration-300 active:scale-95"
                onclick="startGame()">
                <span class="font-bold">RELOAD PROGRAM</span>
            </button>
        </div>
        <!-- Game Area -->
        <div id="game-area" class="flex flex-col md:flex-row gap-8">
            <!-- Terms Column (Draggable Cards) -->
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl matrix-text mb-4 border-b border-green-800 pb-2">Terms</h2>
                <div id="terms-container" class="space-y-4">
                    <!-- Term cards will be inserted here -->
                </div>
            </div>

            <!-- Definitions Column (Drop Targets) -->
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl matrix-text mb-4 border-b border-green-800 pb-2">Definitions</h2>
                <div id="definitions-container" class="space-y-4">
                    <!-- Definition targets will be inserted here -->
                </div>
            </div>
        </div>

        <!-- Game Over Modal -->
        <div id="game-over-modal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
            <div
                class="bg-gray-900 p-8 rounded-lg matrix-text text-center border-2 border-green-500 shadow-xl shadow-green-500/70 max-w-md w-full">
                <h3 class="text-3xl font-bold mb-4">MATCHING COMPLETE</h3>
                <p class="text-xl mb-6">You have successfully matched all terms.</p>
                <p class="text-2xl mb-8 font-bold">Final Score: <span id="final-score">0</span></p>
                <button
                    class="px-8 py-3 matrix-text bg-gray-800 rounded-lg shadow-lg hover:shadow-green-500/70 transition duration-300 active:scale-95"
                    onclick="document.getElementById('game-over-modal').classList.add('hidden'); startGame();">
                    INITIATE NEW SEQUENCE
                </button>
            </div>
        </div>
    </div>

    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/page/FlashCards.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>