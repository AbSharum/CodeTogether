<?php
declare(strict_types=1);

include_once __DIR__ . '/../dao/UserDAO.php';

class AddPointsController extends Controller
{
    private UserDAO $userDao;

    public function performAction(): void
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userDao = new UserDAO();
            $input = json_decode(file_get_contents('php://input'), true);

            $userID = $_SESSION['usercreds']['userID'] ?? 0;
            $points = (int) ($input['points'] ?? 0);

            if ($userID > 0 && $points > 0) {
                $success = $this->userDao->addPoints($userID, $points);

                echo json_encode(['success' => $success]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid user or points']);
            }
        }
    }
}
