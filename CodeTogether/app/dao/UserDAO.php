<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/dbConn.php';

class UserDAO {

    public function addUser($username, $password, $email) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $username, $hashedPassword, $email);
        $stmt->execute();
        $stmt->close();
        $conn->close();
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
        $conn->close();
        return $user;
    }

    public function updateUser($user) {
        $conn = Database::getConnection();

        $stmt = $conn->prepare("SELECT password FROM user WHERE user_id = ?");
        $stmt->bind_param("i", $user->getUserID());
        $stmt->execute();
        $result = $stmt->get_result();
        $existing = $result->fetch_assoc();
        $stmt->close();

        $newPassword = $user->getPassword();

        if ($newPassword !== $existing['password'] && !password_get_info($newPassword)['algo']) {
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $stmt = $conn->prepare("UPDATE user SET username = ?, password = ?, email = ?, points = ?, status = ? WHERE user_id = ?");
        $stmt->bind_param("sssiis", 
            $user->getUsername(),
            $newPassword,
            $user->getEmail(),
            $user->getPoints(),
            $user->getStatus(),
            $user->getUserID()
        );
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }   


    public function authenticate($email, $passwd){
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = null;

        if ($row = $result->fetch_assoc()) {
            if (password_verify($passwd, $row['password'])) {
                $user = new User();
                $user->load($row);
            }
        }

        $stmt->close();
        $conn->close();

        return $user;
}

}

?>

