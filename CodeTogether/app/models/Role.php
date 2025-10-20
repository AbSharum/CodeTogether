<?php
    declare(strict_types=1);

    class Role implements JsonSerializable{
        private int $roleID;
        private string $roleName;
        private string $privileges;

        public function __construct(int $roleID=-1, string $roleName='', string $privileges='') {
            $this->roleID = $roleID;
            $this->roleName = $roleName;
            $this->privileges = $privileges;
        }

        public function load(array $row): void {
            $this->roleID = $row['role_id'];
            $this->roleName = $row['role_name'];
            $this->privileges = $row['privileges'];
        }

        public function jsonSerialize(): array{
                return array(
                    'roleID' => $this->roleID,
                    'roleName' => $this->roleName,
                    'privileges' => $this->privileges,
                );
        }

        public function setRoleID(int $roleID): void{
            $this->roleID=$roleID;
        }

        public function getRoleID(): int{
            return $this->roleID;
        }

        public function setRoleName(string $roleName): void{
            $this->roleName=$roleName;
        }

        public function getRoleName(): string{
            return $this->roleName;
        }

        public function setPrivileges(string $privileges): void{
            $this->privileges=$privileges;
        }

        public function getPrivileges(): string{
            return $this->privileges;
        }
    }
?>
