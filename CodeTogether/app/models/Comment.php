<?php
    declare(strict_types=1);

    class Comment implements JsonSerializable{
        private int $commentID;
        private int $userID;
        private int $postID;
        private string $contents;
        private bool $isDeleted;
        private DateTime $createdOn;

        public function __construct(int $commentID=-1, int $userID=-1, int $postID=-1, bool $isDeleted=false, ?DateTime $createdOn = null, string $contents = '') {
            $this->commentID = $commentID;
            $this->userID = $userID;
            $this->postID = $postID;
            $this->isDeleted = $isDeleted;
            $this->createdOn = $createdOn;
            $this->contents = $contents;
            $this->createdOn = $createdOn;
        }

        public function load($row): void {
            $this->commentID = $row['comment_id'];
            $this->userID = $row['user_id'];
            $this->postID = $row['post_id'];
            $this->contents = $row['contents'];
            $this->isDeleted = $row['is_deleted'];
            $this->createdOn = $row['created_on'];
        }

        public function jsonSerialize(): array{
            return array(
                'commentID' => $this->commentID,
                'userID' => $this->userID,
                'postID' => $this->postID,
                'contents' => $this->contents,
                'isDeleted' => $this->isDeleted,
                'createdOn' => $this->createdOn
            );
        }

        public function setCommentID($commentID): void{
            $this->commentID=$commentID;
        }

        public function getCommentID(): int{
            return $this->commentID;
        }

        public function setUserID($userID): void{
            $this->userID=$userID;
        }

        public function getUserID(): int{
            return $this->userID;
        }

        public function setPostID($postID): void{
            $this->postID=$postID;
        }

        public function getPostID(): int{
            return $this->postID;
        }

        public function setContents($contents): void{
            $this->contents=$contents;
        }

        public function getContents(): string{
            return $this->contents;
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

    }
?>
