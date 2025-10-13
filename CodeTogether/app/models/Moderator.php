<?php
require_once 'Role.php';

class Moderator extends Role{
    public $moderatorActions;
    

    public function __construct($roleID, $moderatorActions){
        parent::__construct($roleID, "Moderator");

        $this->moderatorActions=$moderatorActions;
    }


    public function banUser($user): void{
        #bans user
    }

    public function removesPost($post): void{
        #removesPost
    }

    public function changeUserRole($user, $role): void{
        #changes user Role
    }

}