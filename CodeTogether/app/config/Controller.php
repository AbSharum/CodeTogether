<?php
    declare(strict_types=1);
    class Controller{
        public $model;

        public function performAction(): void{
            return;
        }

        public function renderView(string $view,$data=[]): void{

            include "./template/template.php";
        }

        public function getAuth(): string{
            return "PUBLIC";
        }
    }
?>