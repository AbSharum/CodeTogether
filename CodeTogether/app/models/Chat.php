<?php
declare(strict_types=1);
class Chat implements JsonSerializable{
    private $chatID;
    private $chatType;
    private $lastMessageAt;
    private $createdOn;

    public function __construct($chatID, $chatType, $lastMessageAt, $createdOn) {
        $this->chatID = $chatID;
        $this->chatType = $chatType;
        $this->lastMessageAt = $lastMessageAt;
        $this->createdOn= $createdOn;
    }

    public function load($row) {
        $this->chatID = $row['chat_id'];
        $this->chatType = $row['chat_type'];
        $this->lastMessageAt = $row['last_message_at'];
        $this->createdOn= $row['created_on'];
    }

    public function jsonSerialize(): array{
        return array(
            'chatID' => $this->chatID,
            'chatType' => $this->chatType,
            'lastMessageAt' => $this->lastMessageAt,
            'createdOn' => $this->createdOn
        );
    }

    public function setChatID($chatID){
        $this->chatID=$chatID;
    }

    public function getChatID(): int{
        return $this->chatID;
    }

    public function setChatType($chatType){
        $this->chatType=$chatType;
    }

    public function getChatType(): string{
        return $this->chatType;
    }

    public function setLastMessageAt($lastMessageAt){
        $this->lastMessageAt=$lastMessageAt;
    }

    public function getLastMessageAt(): string{
        return $this->lastMessageAt;
    }

    public function setCreatedOn($createdOn){
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(): string{
        return $this->createdOn;
    }
}
?>