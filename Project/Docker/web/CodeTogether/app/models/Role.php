<?php
class Role{
    public $roleID;
    public $roleName;

    public function __construct($roleID, $roleName){
        $this->roleID=$roleID;
        $this->roleName=$roleName;
    }


    public function getPrivledges(){
        #return privledges
    }

    public function getRoleName(){
        #return role name
    }

}