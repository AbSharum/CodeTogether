<?php
    declare(strict_types=1);

    class FriendsList implements JsonSerializable{
        private int $userID1;
        private int $userID2;
        private string $status;
        private DateTime $createdOn;
    
        public function __construct(int $userID1=-1, int $userID2=-1, string $status='', ?DateTime $createdOn=null) {
            $this->userID1 = $userID1;
            $this->userID2 = $userID2;
            $this->status = $status;
            $this->createdOn= $createdOn;
        }
    
        public function load(array $row): void {
            $this->userID1 = $row['user_id_1'];
            $this->userID2 = $row['user_id_2'];
            $this->status = $row['status'];
            $this->createdOn= $row['created_on'];
        }
    
        public function jsonSerialize(): array{
            return array(
                'userID1' => $this->userID1,
                'userID2' => $this->userID2,
                'status' => $this->status,
                'createdOn' => $this->createdOn
            );
        }
    
        public function setUserID1(int $userID1): void{
            $this->userID1=$userID1;
        }
    
        public function getUserID1(): int{
            return $this->userID1;
        }
    
        public function setUserID2(int $userID2): void{
            $this->userID2=$userID2;
        }
    
        public function getUserID2(): int{
            return $this->userID2;
        }
    
        public function setStatus(string $status): void{
            $this->status=$status;
        }
    
        public function getStatus(): string{
            return $this->status;
        }
    
        public function setCreatedOn(DateTime $createdOn): void{
            $this->createdOn=$createdOn;
        }
    
        public function getCreatedOn(): DateTime{
            return $this->createdOn;
        }
    }
?>
