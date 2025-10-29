<?php
declare(strict_types=1);

class Message implements JsonSerializable
{
    private int $messageID;
    private ?int $threadID;
    private int $userID;
    private int $chatID;
    private string $content;
    private bool $isDeleted;
    private bool $isEdited;
    private ?DateTime $sentAt;
    private ?string $username;

    public function __construct(int $messageID = -1, ?int $threadID = null, int $userID = -1, int $chatID = -1, string $content = '', bool $isDeleted = false, bool $isEdited = false, ?DateTime $sentAt = null, ?string $username = null)
    {
        $this->messageID = $messageID;
        $this->threadID = $threadID;
        $this->userID = $userID;
        $this->chatID = $chatID;
        $this->content = $content;
        $this->isDeleted = $isDeleted;
        $this->isEdited = $isEdited;
        $this->sentAt = $sentAt ?? new DateTime();
        $this->username = $username;
    }

    public function load(array $row): void
    {
        $this->messageID = isset($row['message_id']) ? (int) $row['message_id'] : -1;
        $this->threadID = isset($row['thread_id']) ? (int) $row['thread_id'] : null;
        $this->userID = isset($row['user_id']) ? (int) $row['user_id'] : -1;
        $this->chatID = isset($row['chat_id']) ? (int) $row['chat_id'] : -1;
        $this->content = $row['content'] ?? '';
        $this->isDeleted = (bool) ($row['is_deleted'] ?? false);
        $this->isEdited = (bool) ($row['is_edited'] ?? false);
        $this->sentAt = isset($row['sent_at']) ? new DateTime($row['sent_at']) : new DateTime();
        $this->username = $row['username'] ?? null;
    }

    public function jsonSerialize(): array
    {
        return [
            'messageID' => $this->messageID,
            'threadID' => $this->threadID,
            'userID' => $this->userID,
            'chatID' => $this->chatID,
            'content' => $this->content,
            'isDeleted' => $this->isDeleted,
            'isEdited' => $this->isEdited,
            'sentAt' => $this->sentAt?->format('Y-m-d H:i:A'),
            'username' => $this->username,
        ];
    }


    public function setMessageID(int $id): void
    {
        $this->messageID = $id;
    }
    public function getMessageID(): int
    {
        return $this->messageID;
    }

    public function setThreadID(?int $id): void
    {
        $this->threadID = $id;
    }
    public function getThreadID(): ?int
    {
        return $this->threadID;
    }

    public function setUserID(int $id): void
    {
        $this->userID = $id;
    }
    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setChatID(int $id): void
    {
        $this->chatID = $id;
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

    public function setIsDeleted(bool $deleted): void
    {
        $this->isDeleted = $deleted;
    }
    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsEdited(bool $edited): void
    {
        $this->isEdited = $edited;
    }
    public function getIsEdited(): bool
    {
        return $this->isEdited;
    }

    public function setSentAt(DateTime $date): void
    {
        $this->sentAt = $date;
    }
    public function getSentAt(): DateTime
    {
        return $this->sentAt ?? new DateTime();
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
}
?>