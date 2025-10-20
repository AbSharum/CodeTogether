<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../models/Role.php';
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../config/dbConn.php';


    class RoleDAO {

        public function getUserRole(User $user):Role|null{
            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM role WHERE role_id = ?;");
            $stmt->bind_param("i", $user->getRoleID());
            $stmt->execute();
            $result = $stmt->get_result();
            $Role = null;
            if($row = $result->fetch_assoc()){
                $Role = new Role();
                $Role->load($row);
            }
            $stmt->close();
            
            return $Role;
        }

    }
?>