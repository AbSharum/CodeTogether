<?php
class Post implements JsonSerializable{
    private int $postID;
    private int $userID;
    private int $threadID;
    private $contents;
    private $likes;
    private $caption;
    private $visibility;
    private $isDeleted;
    private $createdOn;
    private $latestUpdate;

    public function __construct($postID, $userID, $threadID, $contents, $caption, $visibility) {
        $this->postID = $postID;
        $this->userID = $userID;
        $this->threadID = $threadID;
        $this->contents = $contents;
        $this->caption = $caption;
        $this->visibility = $visibility;
        $this->likes = 0;
        $this->isDeleted = false;
    }

    public function load($row) {
        $this->postID = $row['post_id'];
        $this->userID = $row['user_id'];
        $this->threadID = $row['thread_id'];
        $this->contents = $row['contents'];
        $this->likes = $row['likes'];
        $this->caption = $row['caption'];
        $this->visibility = $row['visibility'];
        $this->isDeleted = $row['is_deleted'];
        $this->createdOn = $row['created_on'];
        $this->latestUpdate = $row['latest_update'];
    }

    public function deletePost(){
        #deletes post
    }

    public function jsonSerialize(): mixed {
            return array(
                'postID' => $this->postID,
                'userID' => $this->userID,
                'threadID' => $this->threadID,
                'contents' => $this->contents,
                'likes' => $this->likes,
                'caption' => $this->caption,
                'visibility' => $this->visibility,
                'isDeleted' => $this->isDeleted,
                'createdOn' => $this->createdOn,
                'latestUpdate' => $this->latestUpdate
            );
    }

    public function setPostID($postID): void{
        $this->postID=$postID;
    }

    public function getPostID(): int{
        return $this->postID;
    }

    public function setUserID($userID): void{
        $this->userID=$userID;
    }

    public function getuserID(): int{
        return $this->userID;
    }

    public function setThreadID($threadID): void{
        $this->threadID=$threadID;
    }

    public function getThreadID(): int{
        return $this->threadID;
    }

    public function setContents($contents): void{
        $this->contents=$contents;
    }

    public function getContents(): string{
        return $this->contents;
    }

    public function setLikes($likes): void{
        $this->likes=$likes;
    }

    public function getLikes(): int{
        return $this->likes;
    }

    public function setCaption($caption): void{
        $this->caption=$caption;
    }

    public function getCaption(): string{
        return $this->caption;
    }

    public function setVisibility($visibility): void{
        $this->visibility=$visibility;
    }

    public function getVisibility(): string{
        return $this->visibility;
    }

    public function setIsDeleted($isDeleted): void{
        $this->isDeleted=$isDeleted;
        
    }

    public function getIsDeleted(): bool{
        return $this->isDeleted;
    }

    public function setCreatedOn($createdOn): void{
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(): string{
        return $this->createdOn;
    }

    public function setLatestUpdate($latestUpdate): void{
        $this->latestUpdate=$latestUpdate;
    }

    public function getLatestUpdate(): string{
        return $this->latestUpdate;
    }

    
}
?>
