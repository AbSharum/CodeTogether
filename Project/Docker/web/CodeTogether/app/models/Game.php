<?php
class Game{
    public $gameID;
    public $creatorID;
    public $task;
    public $programmingLanguage;
    public $difficulty;
    public $timeLimit;
    public $pointsRewarded;

    public function __construct($gameID, $creatorID, $task, $programmingLanguage, $difficulty, $timeLimit, $pointsRewarded){
        $this->gameID=$gameID;
        $this->creatorID=$creatorID;
        $this->task=$task;
        $this->programmingLanguage=$programmingLanguage;
        $this->difficulty=$difficulty;
        $this->timeLimit=$timeLimit;
        $this->pointsRewarded=$pointsRewarded;
    }


    public function startGame(){
        #starts game
    }

    public function awardPoints($user){
        #awards points
    }

}