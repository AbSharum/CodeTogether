<?php
class User implements JsonSerializable {
    private int $userID;
    private int $roleID;
    private $username;
    private $email;
    private $points;
    private $status;
    private $createdOn;
    private $latestUpdate;
    private $password;

    public function __construct($userID=null, $roleID=null, $username=null, $points=null, $status=null, $email=null, $password=null) {
        $this->userID = $userID;
        $this->roleID = $roleID;
        $this->username = $username;
        $this->points = $points;
        $this->status = $status;
        $this->email = $email;
        $this->password= $password;
    }

    public function load($row) {
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

    public function jsonSerialize(): mixed{ //PHP 8.1+
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

    public function getCreatedOn(): string{
        return $this->createdOn;
    }

    public function setLatestUpdate($latestUpdate): void{
        $this->latestUpdate=$latestUpdate;
    }

    public function getLatestUpdate(): string{
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
