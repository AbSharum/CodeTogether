<?php

class Repost extends Role{
    public $originalPostID;
    public $repostText;

    public function __construct($postID, $postAuthorID, $content, $datePosted, $hashTag, $tags, $comments, $attachment){
        parent::__construct($roleID, "Moderator");
        $this->postID=$postID;
        $this->postAuthorID=$postAuthorID;
        $this->$content=$content;
        $this->datePosted=$datePosted;
        $this->hashTag=$hashTag;
        $this->tags=$tags;
        $this->$comments=$comments;
        $this->$attachment=$attachment;
    }


    public function share($post): void{
        #shares the repost
    }
}