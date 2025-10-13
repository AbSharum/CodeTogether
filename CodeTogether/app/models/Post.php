<?php
class Post implements JsonSerializable{
    private $postID;
    private $userID;
    private $threadID;
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

    public function jsonSerialize(){
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

    public function setPostID($postID){
        $this->postID=$postID;
    }

    public function getPostID(){
        return $this->postID;
    }

    public function setUserID($userID){
        $this->userID=$userID;
    }

    public function getuserID(){
        return $this->userID;
    }

    public function setThreadID($threadID){
        $this->threadID=$threadID;
    }

    public function getThreadID(){
        return $this->threadID;
    }

    public function setContents($contents){
        $this->contents=$contents;
    }

    public function getContents(){
        return $this->contents;
    }

    public function setLikes($likes){
        $this->likes=$likes;
    }

    public function getLikes(){
        return $this->likes;
    }

    public function setCaption($caption){
        $this->caption=$caption;
    }

    public function getCaption(){
        return $this->caption;
    }

    public function setVisibility($visibility){
        $this->visibility=$visibility;
    }

    public function getVisibility(){
        return $this->visibility;
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

    public function setLatestUpdate($latestUpdate){
        $this->latestUpdate=$latestUpdate;
    }

    public function getLatestUpdate(){
        return $this->latestUpdate;
    }

    
}
?>
