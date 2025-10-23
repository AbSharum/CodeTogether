<?php
    declare(strict_types=1);
    class Chat implements JsonSerializable{
        private int $chatID;
        private string $chatType;
        private ?DateTime $lastMessageAt;
        private ?DateTime $createdOn;

        public function __construct(int $chatID=-1, string $chatType='', ?DateTime $lastMessageAt=null, ?DateTime $createdOn=null) {
            $this->chatID = $chatID;
            $this->chatType = $chatType;
            $this->lastMessageAt = $lastMessageAt ?? new DateTime();
            $this->createdOn= $createdOn ?? new DateTime();
        }

        public function load(array $row): void {
            $this->chatID = $row['chat_id'];
            $this->chatType = $row['chat_type'];
            $this->lastMessageAt = $row['last_message_at'];
            $this->createdOn= new DateTime($row['created_on']);
        }

        public function jsonSerialize(): array{
            return array(
                'chatID' => $this->chatID,
                'chatType' => $this->chatType,
                'lastMessageAt' => $this->lastMessageAt,
                'createdOn' => $this->createdOn
            );
        }

        public function setChatID(int $chatID): void{
            $this->chatID=$chatID;
        }

        public function getChatID(): int{
            return $this->chatID;
        }

        public function setChatType(string $chatType): void{
            $this->chatType=$chatType;
        }

        public function getChatType(): string{
            return $this->chatType;
        }

        public function setLastMessageAt(DateTime $lastMessageAt): void{
            $this->lastMessageAt=$lastMessageAt;
        }

        public function getLastMessageAt(): DateTime{
            return $this->lastMessageAt;
        }

        public function setCreatedOn(DateTime $createdOn): void{
            $this->createdOn=$createdOn;
        }

        public function getCreatedOn(): DateTime{
            return $this->createdOn;
        }
    }
?>
