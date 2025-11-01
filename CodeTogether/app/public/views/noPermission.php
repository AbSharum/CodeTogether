<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Home Page</title>
    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/AccessDenied.css">
</head>

<body class="bg-dark text-light">

    <canvas id="matrix-canvas"></canvas>
    <div class="d-flex flex-column align-items-center justify-content-center vh-100 position-relative text-center">
        <h1 class="access-denied-text mb-5">
            ACCESS DENIED
        </h1>

        <button onclick="window.location.href='/index.php?action=home'"
            class="btn btn-outline-info btn-lg rounded-pill px-5 py-2 hover:scale-105">
            Return to the Source
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        xintegrity="sha384-0pUGZvbkm6XF6gxjEnlwpMCEoV3f73SjJ+J8C6W6D2Kx5lM7B8K2FfR7R7E7Q"
        crossorigin="anonymous"></script>
    <script src="/public/js/AccessDenied.js"></script>
</body>
</html>