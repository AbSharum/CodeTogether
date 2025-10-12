<?php
class User{
    public $userID;
    public $roleID;
    public $name;
    public $age;
    public $postsMade;
    public $languagesLearning;
    public $friendsList;

    public function __construct($userID, $roleID, $name, $age, $postsMade, $languagesLearning, $friendsList){
        $this->userID=$userID;
        $this->roleID=$roleID;
        $this->name=$name;
        $this->age=$age;
        $this->postsMade=$postsMade;
        $this->languagesLearning=$languagesLearning;
        $this->friendsList=$friendsList;
    }


    public function makePost($content){
        #create post
    }

    public function commentOnPost($postID, $comment){
        #create comment
    }

    public function addLanguage($language){
        $languagesLearning[]=$language;
    }
}