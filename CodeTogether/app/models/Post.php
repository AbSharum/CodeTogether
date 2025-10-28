<?php
declare(strict_types=1);

class Post implements JsonSerializable
{
    private int $postID;
    private int $userID;
    private string $username;
    private int $threadID;
    private string $contents;
    private int $likes;
    private string $caption;
    private string $visibility;
    private string $filePath;
    private bool $isDeleted;
    private ?DateTime $createdOn;
    private ?DateTime $latestUpdate;

    public function __construct(int $postID = -1, int $userID = -1, string $username = '', int $threadID = -1, string $contents = '', string $caption = '', string $visibility = '', bool $is_deleted = false, ?DateTime $createdOn = null, ?DateTime $latestUpdate = null, string $filepath = '')
    {
        $this->postID = $postID;
        $this->userID = $userID;
        $this->username = $username;
        $this->threadID = $threadID;
        $this->contents = $contents;
        $this->filePath = $filepath;
        $this->caption = $caption;
        $this->visibility = $visibility;
        $this->likes = 0;
        $this->isDeleted = $is_deleted;
        $this->createdOn = $createdOn ?? new DateTime();
        $this->latestUpdate = $latestUpdate ?? new DateTime();
    }

    public function load(array $row): void
    {
        $this->postID = $row['post_id'];
        $this->userID = $row['user_id'];
        $this->username = $row['username'];
        $this->threadID = $row['thread_id'];
        $this->contents = $row['contents'];
        $this->filePath = $row['file_path'] ?? '';
        $this->likes = $row['likes'];
        $this->caption = $row['caption'];
        $this->visibility = $row['visibility'];
        $this->isDeleted = (bool) $row['is_deleted'];
        $this->createdOn = new DateTime($row['created_on']);
        $this->latestUpdate = new DateTime($row['latest_update']);
    }

    public function deletePost(): void
    {
        #deletes post
    }

    public function jsonSerialize(): mixed
    {
        return array(
            'postID' => $this->postID,
            'userID' => $this->userID,
            'threadID' => $this->threadID,
            'contents' => $this->contents,
            'filePath' => $this->filePath,
            'likes' => $this->likes,
            'caption' => $this->caption,
            'visibility' => $this->visibility,
            'isDeleted' => $this->isDeleted,
            'createdOn' => $this->createdOn,
            'latestUpdate' => $this->latestUpdate
        );
    }

    public function getFilePath(): string{
        return $this->filePath;
    }

    public function setFilePath(string $filePath):void {
        $this->filePath = $filePath;
    }

    public function setPostID(int $postID): void
    {
        $this->postID = $postID;
    }

    public function getPostID(): int
    {
        return $this->postID;
    }

    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    public function getuserID(): int
    {
        return $this->userID;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setThreadID(int $threadID): void
    {
        $this->threadID = $threadID;
    }

    public function getThreadID(): int
    {
        return $this->threadID;
    }

    public function setContents(string $contents): void
    {
        $this->contents = $contents;
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;

    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setCreatedOn(DateTime $createdOn): void
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    public function setLatestUpdate(DateTime $latestUpdate): void
    {
        $this->latestUpdate = $latestUpdate;
    }

    public function getLatestUpdate(): DateTime
    {
        return $this->latestUpdate;
    }
}
?>