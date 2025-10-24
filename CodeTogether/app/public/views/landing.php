<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Home Page</title>
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
    <!--NavBar-->
    <?php include __DIR__ .'/../includes/navbar.php'; ?>
    <!--end of navigation-->

    <div class="container d-flex align-items-center justify-content-center vh-100 position-relative"
        style="z-index: 1;">
        <div class="card p-4 mx-4" style="max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">What Do You Choose</h2>
                <div class="mb-3">
                    "The Matrix is everywhere. It is all around us. Even now, in this very room.
                     You can see it when you look out your window or when you turn on your television. 
                     It is the world that has been pulled over your eyes to blind you from the truth". 
                </div>
                <div class="mb-3">
                    "You take the blue pill, the story ends, you leave this site and go do whatever you
                     want to do. You take the red pill, you move through the site, and I show you how
                     deep the rabbit hole goes."" 
                </div>
                <div class="mb-3">
                    <button class="LogInButton">Rabbit Hole</button>
                    <button class="DoNothingButton">Leave</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/public/js/fancyLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>