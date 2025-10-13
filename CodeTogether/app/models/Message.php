<?php
class Message implements JsonSerializable{
    private $messageID;
    private $threadID;
    private $userID;
    private $chatID;
    private $content;
    private $isDeleted;
    private $isEdited;
    private $sentAt;

    public function __construct($messageID, $threadID, $userID, $content, $isDeleted, $chatID, $isEdited, $sentAt) {
        $this->messageID = $messageID;
        $this->threadID = $threadID;
        $this->userID = $userID;
        $this->content = $content;
        $this->isDeleted = $isDeleted;
        $this->chatID = $chatID;
        $this->isDeleted = $isDeleted;
        $this->isEdited= $isEdited;
        $this->sentAt= $sentAt;
    }

    public function load($row) {
        $this->messageID = $row['message_id'];
        $this->threadID = $row['thread_id'];
        $this->userID = $row['user_id'];
        $this->chatID = $row['chat_id'];
        $this->content = $row['content'];
        $this->isDeleted = $row['is_deleted'];
        $this->isEdited = $row['is_edited'];
        $this->sentAt = $row['sent_at'];
    }

    public function jsonSerialize(){
        return array(
            'messageID' => $this->messageID,
            'threadID' => $this->threadID,
            'userID' => $this->userID,
            'chatID' => $this->chatID,
            'content' => $this->content,
            'isDeleted' => $this->isDeleted,
            'isEdited' => $this->isEdited,
            'sentAt' => $this->sentAt
        );
    }

    public function setMessageID($messageID){
        $this->messageID=$messageID;
    }

    public function getMessageID(){
        return $this->messageID;
    }

    public function setThreadID($threadID){
        $this->threadID=$threadID;
    }

    public function getThreadID(){
        return $this->threadID;
    }

    public function setUserID($userID){
        $this->userID=$userID;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function setChatID($chatID){
        $this->chatID=$chatID;
    }

    public function getChatID(){
        return $this->chatID;
    }

    public function setContent($content){
        $this->content=$content;
    }

    public function getContent(){
        return $this->content;
    }

    public function setIsDeleted($isDeleted){
        $this->isDeleted=$isDeleted;
    }

    public function getIsDeleted(){
        return $this->isDeleted;
    }

    public function setIsEdited($isEdited){
        $this->isEdited=$isEdited;
    }

    public function getIsEdited(){
        return $this->isEdited;
    }

    public function setSentAt($sentAt){
        $this->sentAt=$sentAt;
    }

    public function getSentAt(){
        return $this->sentAt;
    }
    
}
?>
