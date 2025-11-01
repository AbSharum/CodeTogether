<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!--navigation icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5nI6Jj4QkI7U1vKjK+L0n4A0w4Z+T5E5R5B5B5Y5S5T5W5V5U5T5Q5V5W5X5Y5Z5"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/public/css/accountSettings.css"> <!--change for file path-->
</head>

<body class="bg-dark text-light">
    <canvas id="matrix-canvas"></canvas>
    <!--NavBar-->
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <!--end of navigation-->

    <div class="container d-flex align-items-center justify-content-center vh-100 position-relative">
        <div class="card p-4 mx-4" style="max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Code Together Account Settings</h2>
                <form action="#" method="POST" id="registration">
                    <!--may need to change im not sure how u peeps are running that side-->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <!--modal for username change-->
                    <!--needs php-->
                    <a href="#" id="changeUsername" class="form-label">Change Username</a><br>
                    <div id="UsernameModal" class="modal">
                        <div class="UsernameModal-content">
                            <span class="uClose">&times;</span>
                            <p>"Deja Vu is usually a glitch in the Matrix.</p><br>
                            <p>It Happens When they change something."</p>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <input type="checkbox" onclick="changeUsername()">Confirm Change
                            <!--needs js for username change and db change-->
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                            required>
                    </div>
                    <!--modal for email change-->
                    <!--needs php-->
                    <a href="#" id="changeEmail" class="form-label">Change Email</a><br>
                    <div id="emailModal" class="modal">
                        <div class="emailModal-content">
                            <span class="eClose">&times;</span>
                            <p>"Deja Vu is usually a glitch in the Matrix.</p><br>
                            <p>It Happens When they change something."</p>
                            <input type="text" class="form-control" id="email" name="email" required>
                            <input type="checkbox" onclick="changeEmail()">Confirm Change
                            <!--needs js for username change and db change-->
                        </div>
                    </div>
                    <!--modal for password change-->
                    <!--needs php-->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                            required>
                    </div>
                    <a href="#" id="changePassword" class="form-label">Change Password</a><br><br>
                    <div id="passwordModal" class="modal">
                        <div class="passwordModal-content">
                            <span class="pClose">&times;</span>
                            <p>"Deja Vu is usually a glitch in the Matrix.</p><br>
                            <p>It Happens When they change something."</p>
                            <input type="text" class="form-control" id="changePassword" name="changePassword" required>
                            <input type="checkbox" onclick="changePassword()">Confirm Change
                            <!--needs js for username change and db change-->
                        </div>
                    </div>
                    <input type="checkbox" onclick="showPassAndConf()">Show Password<br><br>
                    <!--modal for delete account-->
                    <!--needs php-->
                    <div class="deleteContainer">
                        <a href="#" id="delete" class="form-label">Delete Account</a>
                    </div>
                    <div id="deleteModal" class="modal">
                        <div class="deleteModal-content">
                            <span class="dClose">&times;</span>
                            <p>If you are ready to deactivate...</p>
                            <input type="checkbox" onclick="deleteAccount()">Confirm Delete
                            <!--needs js for account deletion and db deletion-->
                        </div>
                    </div>
                    <div class="text-center mt-3" style="color: #0f0; font-size: 0.8rem; clear: both;">
                        Matrix Rain: Toggle On/Off
                        <label class="rainToggle">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/public/js/accountSettings.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        xintegrity="sha384-I7E8VVD/ismYTF4yFOWMaa4G8Hh8MfWfQ9SFJdFjO3/B5Gowu/Q7X9+l+O/Y5z4z0J"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        xintegrity="sha384-0pUGZvbkm6XF6gxjEnlwpMCEoV3f73SjJ+J8C6W6D2Kx5lM7B8K2FfR7R7E7Q"
        crossorigin="anonymous"></script>
</body>
</html>