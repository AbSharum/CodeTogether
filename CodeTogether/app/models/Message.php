<?php
declare(strict_types=1);

class Message implements JsonSerializable
{
    private int $messageID;
    private int $threadID;
    private int $userID;
    private int $chatID;
    private string $content;
    private bool $isDeleted;
    private bool $isEdited;
    private DateTime $sentAt;

    public function __construct(int $messageID = -1, int $threadID = -1, int $userID = -1, string $content = '', bool $isDeleted = false, int $chatID = -1, bool $isEdited = false, ?DateTime $sentAt = null)
    {
        $this->messageID = $messageID;
        $this->threadID = $threadID;
        $this->userID = $userID;
        $this->content = $content;
        $this->isDeleted = $isDeleted;
        $this->chatID = $chatID;
        $this->isDeleted = $isDeleted;
        $this->isEdited = $isEdited;
        $this->sentAt = $sentAt;
    }

    public function load(array $row): void
    {
        $this->messageID = $row['message_id'];
        $this->threadID = $row['thread_id'];
        $this->userID = $row['user_id'];
        $this->chatID = $row['chat_id'];
        $this->content = $row['content'];
        $this->isDeleted = (bool) $row['is_deleted'];
        $this->isEdited = (bool) $row['is_edited'];
        $this->sentAt = new DateTime($row['sent_at']);
    }

    public function jsonSerialize(): array
    {
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

    public function setMessageID(int $messageID): void
    {
        $this->messageID = $messageID;
    }

    public function getMessageID(): int
    {
        return $this->messageID;
    }

    public function setThreadID(int $threadID): void
    {
        $this->threadID = $threadID;
    }

    public function getThreadID(): int
    {
        return $this->threadID;
    }

    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setChatID(int $chatID): void
    {
        $this->chatID = $chatID;
    }

    public function getChatID(): int
    {
        return $this->chatID;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsEdited(bool $isEdited): void
    {
        $this->isEdited = $isEdited;
    }

    public function getIsEdited(): bool
    {
        return $this->isEdited;
    }

    public function setSentAt(DateTime $sentAt): void
    {
        $this->sentAt = $sentAt;
    }

    public function getSentAt(): DateTime
    {
        return $this->sentAt;
    }

}
?>