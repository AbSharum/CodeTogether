<?php
declare(strict_types=1);
require_once 'Game.php';


class CompetitiveGame extends Game
{
    public string $teams;
    public string $coopCodeSubmission;

    public function __construct($gameID, $creatorID, $task, $programmingLanguage, $difficulty, $timeLimit, $pointsRewarded, $teams, $coopCodeSubmission)
    {
        parent::__construct($gameID, $creatorID, $task, $programmingLanguage, $difficulty, $timeLimit, $pointsRewarded);

        $this->coopCodeSubmission = $coopCodeSubmission;
        $this->teams = $teams;
    }


    public function submitTeamCode($code): void
    {
        #submits code
    }

}
?>