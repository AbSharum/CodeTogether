<?php
require_once 'Role.php';

class CsStudent extends Role{
    public $gamesCompleted;
    public $gamesRank;
    public $gamePoints;

    public function __construct($roleID, $gamesCompleted, $gamesRank, $gamePoints){
        parent::__construct($roleID, "CsStudent");

        $this->gamesCompleted=$gamesCompleted;
        $this->gamesRank=$gamesRank;
        $this->gamePoints=$gamePoints;

    }


    public function playGame(): void{
        #plays a game
    }

    public function viewRankings(): void{
        #view rankings
    }

}