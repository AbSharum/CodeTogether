<?php
    include_once __DIR__ . "/Controller.php";

    class Router{
        public $controllers;

        public function __construct(){
            $this->showErrors(0);
            $this->controllers=[];
        }

        public function run(){
            $action="default";

            session_start();

            if(isset($_REQUEST['action'])){
                $action=$_REQUEST['action'];
            }

            $this->authcheck($action);
                        
            $controller = $this->controllers[$action];
            $controller->performAction();
        }

        public function addController($action,$controller){
            $this->controllers[$action] = $controller;
        }

        public function authCheck($action){
            return;
        }

        public function showErrors($debug){
            if($debug==1){
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL & ~E_NOTICE);
            }
        }
    }

?>