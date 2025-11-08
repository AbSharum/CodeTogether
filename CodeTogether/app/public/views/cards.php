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

    <div class="page-FlashCards container mx-auto px-4 max-w-7xl">
        <header class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold matrix-text mb-2">TERMINOLOGY MATCHING</h1>
            <p class="text-lg md:text-xl text-gray-400">Drag each **TERM** to its corresponding **DEFINITION**.</p>
            
            <div class="flex justify-center items-center space-x-8 mt-6 text-xl">
                <div class="matrix-text font-bold">
                    Score: <span id="current-score" class="text-2xl">0</span>
                </div>
                <div class="text-gray-400">
                    Total Terms: <span id="total-matches" class="text-xl">0</span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: Terms -->
            <div class="p-6 rounded-lg shadow-xl shadow-green-500/30 matrix-card">
                <h2 class="text-2xl font-bold matrix-text mb-6 border-b pb-2 border-green-500/50">Terms</h2>
                <div id="terms-container" class="space-y-4">
                    <!-- Term cards will be inserted here -->
                </div>
            </div>

            <!-- Right Column: Definitions -->
            <div class="p-6 rounded-lg shadow-xl shadow-green-500/30 matrix-card">
                <h2 class="text-2xl font-bold matrix-text mb-6 border-b pb-2 border-green-500/50">Definitions</h2>
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
                <p class="text-2xl mb-8 font-bold">Final Score: <span id="final-score">0/0</span></p>
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