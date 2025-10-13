<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/dbConn.php';

class UserDAO {

    public function addUser(User $user) {
        $conn = getConnection();
        if (!$conn) return;

        $stmt = $conn->prepare("INSERT INTO user (role_id, username, password, email, points, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissis", 
            $user->getRoleID(), 
            $user->getUsername(), 
            $user->getPassword(), 
            $user->getEmail(), 
            $user->getPoints(),
            $user->getStatus()
        );
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    public function getUser($userID){
        $conn=$this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?;"); 
        $stmt->bind_param("i",$userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $user = new User();
            $user->load($row);
        }    
        $stmt->close();
        $conn->close();
        return $user;
    }

    public function updateUser($user){
        $connection=$this->getConnection();
        $stmt = $connection->prepare("UPDATE user SET username=?, password=?, email=?, points=?, status=? WHERE userID = ?;");
        $stmt->bind_param("sssis", 
            $user->getUsername(), 
            $user->getPassword(), 
            $user->getEmail(), 
            $user->getPoints(), $
            $user->getPassword(), 
            $user->getStatus()
        );
        $stmt->execute();
        $stmt->close();
        $connection->close();
    }


    public function authenticate($email, $passwd){
        $conn=$this->getConnection();
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? and password = ?;");
        $stmt->bind_param("ss",
            $email,
            $passwd
        ); 
        $stmt->execute();
        $result = $stmt->get_result();
        $found=$result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $found;
    }
}
?>
