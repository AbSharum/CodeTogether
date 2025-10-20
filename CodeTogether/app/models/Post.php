<?php
    declare(strict_types=1);

    class Post implements JsonSerializable{
        private int $postID;
        private int $userID;
        private string $username;
        private int $threadID;
        private string $contents;
        private int $likes;
        private string $caption;
        private string $visibility;
        private bool $isDeleted;
        private DateTime $createdOn;
        private DateTime $latestUpdate;

        public function __construct(int $postID=-1,int $userID=-1, string $username='', int $threadID=-1,string $contents='',string $caption='',string $visibility='') {
            $this->postID = $postID;
            $this->userID = $userID;
            $this->username = $username;
            $this->threadID = $threadID;
            $this->contents = $contents;
            $this->caption = $caption;
            $this->visibility = $visibility;
            $this->likes = 0;
            $this->isDeleted = false;
        }

        public function load($row):void {
            $this->postID = $row['post_id'];
            $this->userID = $row['user_id'];
            $this->username= $row['username'];
            $this->threadID = $row['thread_id'];
            $this->contents = $row['contents'];
            $this->likes = $row['likes'];
            $this->caption = $row['caption'];
            $this->visibility = $row['visibility'];
            $this->isDeleted = (bool)$row['is_deleted'];
            $this->createdOn = new DateTime($row['created_on']);
            $this->latestUpdate = new DateTime($row['latest_update']);
        }

        public function deletePost():void{
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

        public function setUsername($username): void{
            $this->username=$username;
        }

        public function getUsername(): string{
            return $this->username;
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

        public function getCreatedOn(): DateTime{
            return $this->createdOn;
        }

        public function setLatestUpdate($latestUpdate): void{
            $this->latestUpdate=$latestUpdate;
        }

        public function getLatestUpdate(): DateTime{
            return $this->latestUpdate;
        }


    }
?>
