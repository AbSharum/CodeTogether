<?php
class FriendsList implements JsonSerializable{
    private $userID1;
    private $userID2;
    private $status;
    private $createdOn;

    public function __construct($userID1, $userID2, $status, $createdOn) {
        $this->userID1 = $userID1;
        $this->userID2 = $userID2;
        $this->status = $status;
        $this->createdOn= $createdOn;
    }

    public function load($row) {
        $this->userID1 = $row['user_id_1'];
        $this->userID2 = $row['user_id_2'];
        $this->status = $row['status'];
        $this->createdOn= $row['created_on'];
    }

    public function jsonSerialize(){
        return array(
            'userID1' => $this->userID1,
            'userID2' => $this->userID2,
            'status' => $this->status,
            'createdOn' => $this->createdOn
        );
    }

    public function setUserID1($userID1): void{
        $this->userID1=$userID1;
    }

    public function getUserID1(): int{
        return $this->userID1;
    }

    public function setUserID2($userID2): void{
        $this->userID2=$userID2;
    }

    public function getUserID2(): int{
        return $this->userID2;
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
}
?>