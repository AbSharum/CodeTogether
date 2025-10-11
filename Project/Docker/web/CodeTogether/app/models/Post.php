<?php

class Post{
    public $postID;
    public $postAuthorID;
    public $content;
    public $datePosted;
    public $hashTag;
    public $tags;
    public $comments;
    public $attachment;

    public function __construct($postID, $postAuthorID, $content, $datePosted, $hashTag, $tags, $comments, $attachment){
        $this->postID=$postID;
        $this->postAuthorID=$postAuthorID;
        $this->$content=$content;
        $this->datePosted=$datePosted;
        $this->hashTag=$hashTag;
        $this->tags=$tags;
        $this->$comments=$comments;
        $this->$attachment=$attachment

    }


    public function editContent($content){
        $this->content=$content;
    }

    public function deletePost(){
        #deletes post
    }

}