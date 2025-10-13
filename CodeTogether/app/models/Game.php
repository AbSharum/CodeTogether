<?php
class Game implements JsonSerializable{
    private $gameID;
    private $description;
    private $points;
    private $timeLimit;
    private $difficulty;
    private $createdOn;
    private $latestUpdate;

    public function __construct($gameID, $description, $points, $difficulty, $createdOn, $timeLimit, $latestUpdate) {
        $this->gameID = $gameID;
        $this->description = $description;
        $this->points = $points;
        $this->difficulty = $difficulty;
        $this->createdOn = $createdOn;
        $this->timeLimit = $timeLimit;
        $this->createdOn = $createdOn;
        $this->latestUpdate= $latestUpdate;
    }

    public function load($row) {
        $this->gameID = $row['game_id'];
        $this->description = $row['description'];
        $this->points = $row['points'];
        $this->timeLimit = $row['time_limit'];
        $this->difficulty = $row['difficulty'];
        $this->createdOn = $row['created_on'];
        $this->latestUpdate = $row['latest_update'];
    }

    public function jsonSerialize(){
        return array(
            'gameID' => $this->gameID,
            'description' => $this->description,
            'points' => $this->points,
            'timeLimit' => $this->timeLimit,
            'difficulty' => $this->difficulty,
            'createdOn' => $this->createdOn,
            'latestUpdate' => $this->latestUpdate,
        );
    }

    public function setGameID($gameID){
        $this->gameID=$gameID;
    }

    public function getGameID(){
        return $this->gameID;
    }

    public function setDescription($description){
        $this->description=$description;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setPoints($points){
        $this->points=$points;
    }

    public function getPoints(){
        return $this->points;
    }

    public function setTimeLimit($timeLimit){
        $this->timeLimit=$timeLimit;
    }

    public function getTimeLimit(){
        return $this->timeLimit;
    }

    public function setDifficulty($difficulty){
        $this->difficulty=$difficulty;
    }

    public function getDifficulty(){
        return $this->difficulty;
    }

    public function setCreatedOn($createdOn){
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(){
        return $this->createdOn;
    }

    public function setLatestUpdate($latestUpdate){
        $this->latestUpdate=$latestUpdate;
    }

    public function getLatestUpdate(){
        return $this->latestUpdate;
    }
    
}
?>
