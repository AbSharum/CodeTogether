<?php
    declare(strict_types=1);

    class User implements JsonSerializable {
        private int $userID;
        private int $roleID;
        private string $username;
        private string $email;
        private int $points;
        private string $status;
        private DateTime $createdOn;
        private DateTime $latestUpdate;
        private string $password;

        public function __construct(int $userID=-1, int $roleID=-1, string $username='',int $points=-1, string $status='',string $email='',string $password='') {
            $this->userID = $userID;
            $this->roleID = $roleID;
            $this->username = $username;
            $this->points = $points;
            $this->status = $status;
            $this->email = $email;
            $this->password= $password;
        }


        public function load($row): void {
            $this->userID = $row['user_id'];
            $this->roleID = $row['role_id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->points = $row['points'];
            $this->status = $row['status'];
            $this->createdOn = $row['created_on'];
            $this->latestUpdate = $row['latest_update'];
            $this->password = $row['password'];
        }

        public function jsonSerialize(): array{
                return array(
                    'userID' => $this->userID,
                    'roleID' => $this->roleID,
                    'username' => $this->username,
                    'email' => $this->email,
                    'points' => $this->points,
                    'status' => $this->status,
                    'createdOn' => $this->createdOn,
                    'latestUpdate' => $this->latestUpdate,
                    'password' => $this->password
                );
        }

        public function setUserID($userID): void{
            $this->userID=$userID;
        }

        public function getUserID(): int{
            return $this->userID;
        }

        public function setRoleID($roleID): void{
            $this->roleID=$roleID;
        }

        public function getRoleID(): int{
            return $this->roleID;
        }

        public function setUsername($username): void{
            $this->username=$username;
        }

        public function getUsername(): string{
            return $this->username;
        }

        public function setEmail($email): void{
            $this->email=$email;
        }

        public function getEmail(): string{
            return $this->email;
        }

        public function setPoints($points): void{
            $this->points=$points;
        }

        public function getPoints(): int{
            return $this->points;
        }

        public function setStatus($status): void{
            $this->status=$status;
        }

        public function getStatus(): string{
            return $this->status;
        }

        public function setCreatedOn($createdOn): void{
            $this->createdOn=$createdOn;
        }

        public function getCreatedOn(): DateTime{
            return $this->createdOn;
        }

        public function setLatestUpdate($latestUpdate): void{
            $this->latestUpdate=$latestUpdate;
        }

        public function getLatestUpdate(): DateTime{
            return $this->latestUpdate;
        }

        public function setPassword($password): void{
            $this->password=$password;
        }

        public function getPassword(): string{
            return $this->password;
        }

    }
?>
