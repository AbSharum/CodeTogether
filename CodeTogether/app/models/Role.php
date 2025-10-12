<?php
class Role implements JsonSerializable{
    private $roleID;
    private $roleName;
    private $privileges;

    public function __construct($roleID, $roleName, $privileges) {
        $this->roleID = $roleID;
        $this->roleName = $roleName;
        $this->privileges = $privileges;
    }

    public function load($row) {
        $this->roleID = $row['role_id'];
        $this->roleName = $row['role_name'];
        $this->privileges = $row['privileges'];
    }

    public function jsonSerialize(){
            return array(
                'roleID' => $this->roleID,
                'roleName' => $this->roleName,
                'privileges' => $this->privileges,
            );
    }

    public function setRoleID($roleID){
        $this->roleID=$roleID;
    }

    public function getRoleID(){
        return $this->roleID;
    }

    public function setRoleName($roleName){
        $this->roleName=$roleName;
    }

    public function getRoleName(){
        return $this->roleName;
    }

    public function setPrivileges($privileges){
        $this->privileges=$privileges;
    }

    public function getPrivileges(){
        return $this->privileges;
    }
}
?>