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

    public function setGameID($gameID): void{
        $this->gameID=$gameID;
    }

    public function getGameID(): int{
        return $this->gameID;
    }

    public function setDescription($description): void{
        $this->description=$description;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setPoints($points): void{
        $this->points=$points;
    }

    public function getPoints(): int{
        return $this->points;
    }

    public function setTimeLimit($timeLimit): void{
        $this->timeLimit=$timeLimit;
    }

    public function getTimeLimit(): int{
        return $this->timeLimit;
    }

    public function setDifficulty($difficulty): void{
        $this->difficulty=$difficulty;
    }

    public function getDifficulty(): string{
        return $this->difficulty;
    }

    public function setCreatedOn($createdOn): void{
        $this->createdOn=$createdOn;
    }

    public function getCreatedOn(): string{
        return $this->createdOn;
    }

    public function setLatestUpdate($latestUpdate): void{
        $this->latestUpdate=$latestUpdate;
    }

    public function getLatestUpdate(): string{
        return $this->latestUpdate;
    }
    
}
?>
