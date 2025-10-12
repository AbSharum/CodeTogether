<?php
require_once 'Role.php';

class Moderator extends Role{
    public $moderatorActions;
    

    public function __construct($roleID, $moderatorActions){
        parent::__construct($roleID, "Moderator");

        $this->moderatorActions=$moderatorActions;
    }


    public function banUser($user){
        #bans user
    }

    public function removesPost($post){
        #removesPost
    }

    public function changeUserRole($user, $role){
        #changes user Role
    }

}