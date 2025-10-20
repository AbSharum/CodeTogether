<?php
    declare(strict_types=1);

    class Game implements JsonSerializable{
        private int $gameID;
        private string $description;
        private int $points;
        // This integer will be in seconds we will need to do conversions at runtime
        private int $timeLimit;
        private string $difficulty;
        private DateTime $createdOn;
        private DateTime $latestUpdate;

        public function __construct(int $gameID=-1,string $description='',int $points=-1,string $difficulty='',?DateTime $createdOn=null,int $timeLimit=-1,?DateTime $latestUpdate=null) {
            $this->gameID = $gameID;
            $this->description = $description;
            $this->points = $points;
            $this->difficulty = $difficulty;
            $this->createdOn = $createdOn;
            $this->timeLimit = $timeLimit;
            $this->createdOn = $createdOn;
            $this->latestUpdate= $latestUpdate;
        }

        public function load(array $row): void {
            $this->gameID = $row['game_id'];
            $this->description = $row['description'];
            $this->points = $row['points'];
            $this->timeLimit = $row['time_limit'];
            $this->difficulty = $row['difficulty'];
            $this->createdOn = $row['created_on'];
            $this->latestUpdate = $row['latest_update'];
        }

        public function jsonSerialize(): array{
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

        public function setGameID(int $gameID): void{
            $this->gameID=$gameID;
        }

        public function getGameID(): int{
            return $this->gameID;
        }

        public function setDescription(string $description): void{
            $this->description=$description;
        }

        public function getDescription(): string{
            return $this->description;
        }

        public function setPoints(int $points): void{
            $this->points=$points;
        }

        public function getPoints(): int{
            return $this->points;
        }

        public function setTimeLimit(int $timeLimit): void{
            $this->timeLimit=$timeLimit;
        }

        public function getTimeLimit(): int{
            return $this->timeLimit;
        }

        public function setDifficulty(string $difficulty): void{
            $this->difficulty=$difficulty;
        }

        public function getDifficulty(): string{
            return $this->difficulty;
        }

        public function setCreatedOn(DateTime $createdOn): void{
            $this->createdOn=$createdOn;
        }

        public function getCreatedOn(): DateTime{
            return $this->createdOn;
        }

        public function setLatestUpdate(DateTime $latestUpdate): vo
