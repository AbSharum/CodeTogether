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

    public function setThreadID($threadID){
        $this->threadID=$threadID;
    }

    public function getThreadID(){
        return $this->threadID;
    }

    public function setTitle($title){
        $this->title=$title;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setCreatedOn($createdOn){
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(){
        return $this->createdOn;
    }
}
?>