<?php
declare(strict_types=1);

class Friend implements JsonSerializable
{
    private int $friendID;
    private string $status;
    private ?DateTime $createdOn;

    public function __construct(int $friendID = -1, string $status = '', ?DateTime $createdOn = null)
    {
        $this->friendID = $friendID;
        $this->status = $status;
        $this->createdOn = $createdOn ?? new DateTime();
    }

    public function load(array $row): void
    {
        $this->friendID = $row['friend_id'];
        $this->status = $row['status'];
        $this->createdOn = new DateTime($row['created_on']);
    }

    public function jsonSerialize(): array
    {
        return array(
            'friend_id' => $this->friendID,
            'status' => $this->status,
            'createdOn' => $this->createdOn
        );
    }

    public function setFriendID(int $friendID): void
    {
        $this->friendID = $friendID;
    }

    public function getFriendID(): int
    {
        return $this->friendID;
    }


    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setCreatedOn(DateTime $createdOn): void
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }
}
?>