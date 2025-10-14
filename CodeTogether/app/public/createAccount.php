<!DOCTYPE html>
<html lang="en">
        <head>
            <title>Code Together Account Creation</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="/public/fancy.css"> 
            <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class = "bg-dark text-light">
            <canvas id="matrix-canvas"></canvas>
            <div class="container d-flex align-items-center justify-content-center vh-100 position-relative" style="z-index: 1;">
                <div class="card p-4 text-bg-dark bg-opacity 75" style="max-width: 400px;">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Code Together Account Creation</h2>
                        <form action = "index.php?action=createAccount" method="POST" id="registration">  
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                    <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                <input type="checkbox" onclick="showPassAndConf()">Show Password<br> 
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" disabled selected> Select your role...</option>
                                    <option value="moderator">Moderator</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                            </div>
                                
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-success">Create Account</button>
                            </div>
                            </form>
                            <div class="d-grid gap-2">
                                <button type="return" class="btn btn-success" onclick="window.location.href='index.php?action=login'">Return to Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <script src="/public/createAccount.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
