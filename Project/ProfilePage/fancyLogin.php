<?php
session_start();

require_once 'db_connect.php'; // not sure what this needs to be.
$serverName = " "; //needs servername entered.
$username = "username";
$password = "password";

$conn = new mysqli($serverName,$username,$password);
if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}
echo "Connected Successfully"; // remove before deployment only for testing

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberme = isset($_POST['rememberme']);

    //authenticate user against the database

    $stmt = $conn->prepare("SELECT id,password FROM users WHERE email = ?"); //  change naming here if needed for database;
    if($stmt){
        $stmt->bind_param("s",email);
        $stmt ->execute();
        $result == $stmt->get_result();

        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            if(password_verify($password,$user['password'])){
                $_SESSION['user_id'] = $user['id'];

                if($rememberme){ //setting the user info to be stored into a yummi cookie so user will be remembered if desired to be.
                    $token = bin2hex(random_bytes(32));
                    $experiation_time = time() + (86400 * 30); //seconds in a day times 30 days
                    $stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss",$user['id'],$token,date('Y-m-d H:i:s',$experiation_time));
                    $stmt->execute();

                    // setting the cookie.
                    setcookie("remeber_me_token", $token,$experiation_time,"/");
                }
                header("location: home.php"); //redirect to home.php page can change the name its just here for now
                exit();
            }else{
                $login_err = "Invalid login credentials."; // handles invalid login info
            }
        }else{
            $login_err = "Invalid login credentials.";
        }
        $stmt->close();
    }
    conn->close();        
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Code Together Account Login</title>
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
                <h2 class="card-title text-center mb-4">Code Together Login</h2>
                <form action = "profile.html" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <input type="checkbox" onclick="showPass()">Show Password<br>
                        <input type="checkbox" id="rememberMe" name="rememberMe" value = "1">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
                    
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </form>
                
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-success" onclick="window.location.href='createAccount.html'">Create Account</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="fancyLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>