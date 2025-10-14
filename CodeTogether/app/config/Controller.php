<?php
class Controller{
    public $model;

    public function performAction(){
        return;
    }

    public function renderView($view,$data=[]){
        
        include "./template/template.php";
    }

    public function getAuth(){
        return "PUBLIC";
    }
}
?>