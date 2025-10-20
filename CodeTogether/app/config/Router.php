<?php
    declare(strict_types=1);
    include_once __DIR__ . "/Controller.php";

    class Router{
        public $controllers;

        public function __construct(){
            $this->showErrors(0);
            $this->controllers=[];
        }

        public function run(): void{
            $action="default";

            session_start();

            if(isset($_REQUEST['action'])){
                $action=$_REQUEST['action'];
            }

            $this->authcheck($action);
                        
            $controller = $this->controllers[$action];
            $controller->performAction();
        }

        public function addController(string $action,Controller $controller): void{
            $this->controllers[$action] = $controller;
        }

        public function authCheck(string $action): void {
            /*
             * Add here the action and the roles that are allowed to access the page 
             * related to the action 
             */
            $protectedRoutes = [
                'home' => ['student','teacher','moderator'],
                'accountSettings'=>['student','teacher','moderator'] 
            ];
        
            if (isset($protectedRoutes[$action])) {
                $requiredRoles = $protectedRoutes[$action];
                require_once __DIR__ . '/../config/authCheck.php';
            }
        }



        public function showErrors(int $debug){
            if($debug==1){
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL & ~E_NOTICE);
            }
        }
    }

?>