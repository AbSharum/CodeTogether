<?php
class User implements JsonSerializable {
    private $userID;
    private $roleID;
    private $username;
    private $email;
    private $points;
    private $status;
    private $createdOn;
    private $latestUpdate;
    private $password;

    public function __construct($userID, $roleID, $username, $points, $status, $email, $password) {
        $this->userID = $userID;
        $this->roleID = $roleID;
        $this->username = $username;
        $this->points = $points;
        $this->status = $status;
        $this->email = $email;
        $this->isDeleted = $isDeleted;
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

    public function jsonSerialize(){
            return array(
                'userID' => $this->userID,
                'roleID' => $this->roleID,
                'username' => $this->username;
                'email' => $this->email;
                'points' => $this->points;
                'status' => $this->status;
                'createdOn' => $this->createdOn;
                'latestUpdate' => $this->latestUpdate;
                'password' => $this->password;
            );
    }

    public function setUserID($userID){
        $this->userID=$userID;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function setRoleID($roleID){
        $this->roleID=$roleID;
    }

    public function getRoleID(){
        return $this->roleID;
    }

    public function setUsername($username){
        $this->username=$username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPoints($points){
        $this->points=$points;
    }

    public function getPoints(){
        return $this->points;
    }

    public function setStatus($status){
        $this->status=$status;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setCreatedOn($createdOn){
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(){
        return $this->createdOn;
    }

    public function setLatestUpdate($latestUpdate){
        $this->latestUpdate=$latestUpdate;
    }

    public function getLatestUpdate(){
        return $this->latestUpdate;
    }

    public function setPassword($password){
        $this->password=$password;
    }

    public function getPassword(){
        return $this->password;
    }
    
}
?>
