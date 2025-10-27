<?php
declare(strict_types=1);
require_once 'Game.php';


class DailyGame extends Game
{
    public $codeSubmission;
    public $userComments;

    public function __construct($gameID, $creatorID, $task, $programmingLanguage, $difficulty, $timeLimit, $pointsRewarded, $codeSubmission, $userComments)
    {
        parent::__construct($gameID, $creatorID, $task, $programmingLanguage, $difficulty, $timeLimit, $pointsRewarded);

        $this->codeSubmission = $codeSubmission;
        $this->userComments = $userComments;

    }


    public function submitCode($code): void
    {
        #submits code
    }

}
?>