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

    public function setRoleID($roleID): void{
        $this->roleID=$roleID;
    }

    public function getRoleID(): int{
        return $this->roleID;
    }

    public function setRoleName($roleName): void{
        $this->roleName=$roleName;
    }

    public function getRoleName(): string{
        return $this->roleName;
    }

    public function setPrivileges($privileges): void{
        $this->privileges=$privileges;
    }

    public function getPrivileges(): string{
        return $this->privileges;
    }
}
?>