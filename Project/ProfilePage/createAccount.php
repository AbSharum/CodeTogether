<?php

session_start();
require_once 'db_connect.php'; // need this to be verified too please. for database connection

$error_message = "";

    //Server side Validation...

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = trim($_POST[password']);
    $confirmPassword = trim($_POST[confirmPassword']);

    if($password !== $confirmPassword){
        $error_message = "Passwords do not match. Please try again.";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_message = "Invalid email format.";
    }else if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $password)){
        $error_message = "Password does not meet the complexity requirements.";
    }

    // db side Validation...

    if(empty($error_message)){
        // First, check if the email already exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $error_message = "An account with this email address already exists.";
        } else {
            // Email is unique, proceed to insert the new user
            // Securely hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare an INSERT statement
            $insert_stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $firstName, $lastName, $email, $hashed_password);

            // Execute the statement and check for success
            if($insert_stmt->execute()){
                // Redirect to the login page with a success message
                header("location: fancyLogin.php?registration=success");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later.";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
        <head>
            <title>Code Together Account Creation</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="fancy.css"> 
            <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class = "bg-dark text-light">
            <canvas id="matrix-canvas"></canvas>
            <div class="container d-flex align-items-center justify-content-center vh-100 position-relative" style="z-index: 1;">
                <div class="card p-4 text-bg-dark bg-opacity 75" style="max-width: 400px;">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Code Together Account Creation</h2>
                        <form action = "fancyLogin.php" method="POST"> 
                            <form id="registration"> 
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
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
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-success">Create Account</button>
                            </div>
                            </form>
                            <div class="d-grid gap-2">
                                <button type="return" class="btn btn-success" onclick="window.location.href='fancyLogin.php'">Return to Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <script src="createAccount.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>