<?php
require_once 'Role.php';

class CsProfessor extends Role{
    public $gamesCreated;
    public $classesTaught;
    

    public function __construct($roleID, $gamesCreated, $classesTaught){
        parent::__construct($roleID, "CsProfessor");

        $this->gamesCreated=$gamesCreated;
        $this->classesTaught=$classesTaught;

    }


    public function createGame(){
        #creates a game
    }

    public function teachClass(){
        #teaches a class
    }

}