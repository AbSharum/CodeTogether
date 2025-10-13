<?php
class Comment implements JsonSerializable{
    private $commentID;
    private $userID;
    private $postID;
    private $contents;
    private $isDeleted;
    private $createdOn;

    public function __construct($commentID, $userID, $postID, $isDeleted, $createdOn, $contents) {
        $this->commentID = $commentID;
        $this->userID = $userID;
        $this->postID = $postID;
        $this->isDeleted = $isDeleted;
        $this->createdOn = $createdOn;
        $this->contents = $contents;
        $this->createdOn = $createdOn;
    }

    public function load($row) {
        $this->commentID = $row['comment_id'];
        $this->userID = $row['user_id'];
        $this->postID = $row['post_id'];
        $this->contents = $row['contents'];
        $this->isDeleted = $row['is_deleted'];
        $this->createdOn = $row['created_on'];
    }

    public function jsonSerialize(){
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

    public function getCommentID(): String{
        return $this->commentID;
    }

    public function setUserID($userID){
        $this->userID=$userID;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function setPostID($postID){
        $this->postID=$postID;
    }

    public function getPostID(){
        return $this->postID;
    }

    public function setContents($contents){
        $this->contents=$contents;
    }

    public function getContents(){
        return $this->contents;
    }

    public function setIsDeleted($isDeleted){
        $this->isDeleted=$isDeleted;
    }

    public function getIsDeleted(){
        return $this->isDeleted;
    }

    public function setCreatedOn($createdOn){
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(){
        return $this->createdOn;
    }
    
}
?>
