<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!--navigation icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5nI6Jj4QkI7U1vKjK+L0n4A0w4Z+T5E5R5B5B5Y5S5T5W5V5U5T5Q5V5W5X5Y5Z5"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/public/css/fancy.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>

    <div class="container d-flex align-items-center justify-content-center vh-100 position-relative"
        style="z-index: 1;">
        <div class="card p-4 mx-4" style="max-width: 400px;">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <h2 class="card-title text-center mb-4">What Do You Choose</h2>
                <div class="mb-3">
                    "The Matrix is everywhere. It is all around us. Even now, in this very room.
                    You can see it when you look out your window or when you turn on your television.
                    It is the world that has been pulled over your eyes to blind you from the truth".
                </div>
                <div class="mb-3">
                    "Here you will meet friends both new and old. Chat with each other, make some posts about how coding
                    make
                    you want to bang your head. Challenge your friends in a code battle on who can write workable code
                    the cleanest
                    and the fastest to gain amazing points. Here at Code Together we are bringing people together to get
                    better at coding
                    and to make friends to become more social... to help break free from the matrix. So come let us show
                    you how far
                    the rabit hole goes."
                </div>
                <div class="mb-3">
                    <button class="LogInButton" onclick="window.location.href='index.php?action=login'">Rabbit
                        Hole</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/fancyLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>