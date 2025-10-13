<?php
class Thread implements JsonSerializable{
    private $threadID;
    private $title;
    private $createdOn;

    public function __construct($threadID, $title, $createdOn) {
        $this->threadID = $threadID;
        $this->title = $title;
        $this->createdOn = $createdOn;
    }

    public function load($row) {
        $this->threadID = $row['thread_id'];
        $this->title = $row['title'];
        $this->createdOn = $row['created_on'];
    }

    public function jsonSerialize(){
            return array(
                'threadID' => $this->threadID,
                'title' => $this->title,
                'createdOn' => $this->createdOn,
            );
    }

    public function setThreadID($threadID): void{
        $this->threadID=$threadID;
    }

    public function getThreadID(): int{
        return $this->threadID;
    }

    public function setTitle($title): void{
        $this->title=$title;
    }

    public function getTitle(): string{
        return $this->title;
    }

    public function setCreatedOn($createdOn): void{
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(): string{
        return $this->createdOn;
    }
}
?>