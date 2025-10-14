<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/dbConn.php';

class UserDAO {

    public function addUser($username, $password, $email) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
        $stmt->close();
    }

    public function getUser($userID){
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = null;
        if($row = $result->fetch_assoc()){
            $user = new User();
            $user->load($row);
        }
        $stmt->close();
        return $user;
    }

    public function updateUser($user){
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE user SET username=?, password=?, email=?, points=?, status=? WHERE userID=?;");
        $stmt->bind_param("sssiis", 
            $user->getUsername(), 
            $user->getPassword(), 
            $user->getEmail(), 
            $user->getPoints(), 
            $user->getStatus(), 
            $user->getUserID()
        );
        $stmt->execute();
        $stmt->close();
    }

    public function authenticate($email, $passwd){
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $passwd);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = null;

        if ($row = $result->fetch_assoc()) {
            $user = new User();
            $user->load($row);
        }

        $stmt->close();

        return $user;
}

}

?>

