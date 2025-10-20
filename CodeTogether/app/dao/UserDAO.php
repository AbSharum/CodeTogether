<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../config/dbConn.php';


    class UserDAO {

        public function addUser(string $username, string $password,string $email, int $roleID):void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("INSERT INTO user (username, password, email,role_id) VALUES (?, ?, ?,?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssi", $username, $hashedPassword, $email, $roleID);
            $stmt->execute();
            $stmt->close();
            
        }

        public function getUserByID(int $userID):User|null{
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

        public function getUserByName(String $username):User|null{
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?;");
            $stmt->bind_param("s", $username);
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

        public function updateUser(User $user):void {
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
        }   

        public function checkExistingEmail(string $email):bool {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?;");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return !($result->num_rows === 0);

        }


        public function authenticate(string $identefier,string $passwd):User|null{
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM user WHERE (email = ? OR username = ?);");
            $stmt->bind_param("ss", $identefier,$identefier);
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
            

            return $user;
        }

    }
?>