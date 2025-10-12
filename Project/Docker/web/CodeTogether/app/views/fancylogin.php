<?php
session_start();

require_once 'db_connect.php'; // change this for whatever the database page will be called

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberme = isset($_POST['rememberme']);

    //authenticate user against the database

    $stmt = $conn->prepare("SELECT id,password From users WHERE email = ?"); //  change naming here if needed for database;
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
            echo "Invalid login credentials."; // handles invalid login info
        }
    }
}
?>