<!DOCTYPE html>
<html lang="en">

<head>
    <title>404</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="/public/css/404Error.css">
</head>

<body class="bg-black text-white antialiased">
    <canvas id="matrix-canvas"></canvas>
    <div class="container">
        <div class="flex items-center justify-center min-h-screen relative z-10 p-4">
            <div
                class="card-matrix px-10 py-24 mx-auto text-center rounded-lg w-full max-w-2x1 transition-all duration-300">
                <div class="card-body">
                    <h1 class="text-9xl font-extrabold mb-6 text-matrix-green tracking-widest">404</h1>
                    <h2 class="text-3xl sm:text-4xl font-mono mb-4 text-faint-green animate-pulse">It is...Inevitable.
                    </h2>
                    <p class="text-base sm:text-lg font-mono mb-8 text-white-400">But that is how it is with you people.
                        You don't care how it works...<br>just that it works.<br> And HERE WE ARE... looking at this 404
                        error in disbelief.</p>
                </div>

                <div id="action-buttons" class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="window.location.href='/index.php?action=home'"
                        class="btn-blue-pill hover:scale-105">
                        Return the Source
                    </button>
                    <button onclick="alert('The Oracle says: I knew you would click here. Try the other button.')"
                        class="btn-red-pill hover:scale-105">
                        Ask the Oracle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/404Error.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>