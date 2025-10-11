<?php
class FriendsList{
    public $friends;

    public function __construct($friends){
        $this->friends=$friends;
    }


    public function addFriend($user){
        $friends[]=$friends;
    }

    public function removeFriend($user){
        $index=array_search($user, $friends)
        unset($friends[$key]);
    }

    public function getFriends(){
        return $this->friends;
    }

}