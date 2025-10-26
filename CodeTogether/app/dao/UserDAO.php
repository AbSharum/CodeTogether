<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../config/DbConn.php';
    require_once __DIR__ . '/../config/EventDispatcher.php';

    class UserDAO {

        public function addUser(string $username, string $password,string $email, int $roleID):void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("INSERT INTO user (username, password, email,role_id) VALUES (?, ?, ?,?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssi", $username, $hashedPassword, $email, $roleID);
            $validStmt = $stmt->execute();

            if ($validStmt) {
                EventDispatcher::broadcast([
                    'event'=>'newUser',
                    'data'=>['username'=>$username,'email'=>$email]
                ]);
            }
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

        public function getFriendUsers(array $friends):array{
            if (empty($friends)) return [];

            $ids = [];
            foreach ($friends as $friend) $ids[] = $friend->getFriendID(); 
            $inClause = "('" . implode("','", $ids) . "')";

            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM user WHERE user_id in $inClause order by username asc;");
            $stmt->execute();
            $result = $stmt->get_result();
            $users = [];
            while($row = $result->fetch_assoc()){
                $user = new User();
                $user->load($row);
                $users[] = $user;
            }
            $stmt->close();
            
            return $users;
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

        public function updateUserStatus(String $status,int $userID) {
            $conn = Database::getConnection();

            $stmt = $conn->prepare("UPDATE user SET status = ? WHERE user_id = ?;");
            $stmt->bind_param("si", $status,$userID);
            $validStmt = $stmt->execute();
            if ($validStmt) {
                EventDispatcher::broadcast([
                    'event'=>'statusChange',
                    'data'=>['userID'=>$userID,'status'=>$status]
                ]);
            }
            $stmt->close();
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
            $stmt = $conn->prepare("SELECT count(*) as cnt FROM user WHERE email = ?;");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result['cnt'] > 0;
        }

        public function checkExistingUser(string $user):bool {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT count(*) as cnt FROM user WHERE username = ?;");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result['cnt'] > 0;

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


        public function searchUsersByName(string $searchTerm): array {
            $conn = Database::getConnection();

            $stmt = $conn->prepare("SELECT * FROM user WHERE username LIKE CONCAT('%', ?, '%');");
            $stmt->bind_param("s", $searchTerm);
            $stmt->execute();

            $result = $stmt->get_result();
            $users = [];

            
            while ($row = $result->fetch_assoc()) {
                $user = new User();
                $user->load($row);
                $users[] = $user;
            }

            $stmt->close();

            return $users;
        }
    }
?>