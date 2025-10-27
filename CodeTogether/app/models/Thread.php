<?php
declare(strict_types=1);

class Thread implements JsonSerializable
{
    private int $threadID;
    private string $title;
    private ?DateTime $createdOn;

    public function __construct(int $threadID = -1, string $title = '', ?DateTime $createdOn = null)
    {
        $this->threadID = $threadID;
        $this->title = $title;
        $this->createdOn = $createdOn ?? new DateTime();
    }

    public function load(array $row): void
    {
        $this->threadID = $row['thread_id'];
        $this->title = $row['title'];
        $this->createdOn = new DateTime($row['created_on']);
    }

    public function jsonSerialize(): array
    {
        return array(
            'threadID' => $this->threadID,
            'title' => $this->title,
            'createdOn' => $this->createdOn,
        );
    }

    public function setThreadID(int $threadID): void
    {
        $this->threadID = $threadID;
    }

    public function getThreadID(): int
    {
        return $this->threadID;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
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