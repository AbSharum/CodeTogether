<?php
declare(strict_types=1);

include_once __DIR__ . '/../config/Controller.php';
include_once __DIR__ . '/../dao/UserDAO.php';

class UpdateStatusController extends Controller
{
    private UserDAO $userDao;
    public function performAction(): void
    {
        $this->userDao = new UserDAO();
        header('Content-Type: application/json');

        if (!isset($_SESSION['usercreds']['userID'])) {
            echo json_encode(['success' => false, 'error' => 'Not logged in']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid method']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['status'])) {
            echo json_encode(['success' => false, 'error' => 'Missing status']);
            return;
        }

        $status = strtolower(trim($input['status']));
        $userID = (int) $_SESSION['usercreds']['userID'];

        $allowed = ['online', 'away', 'offline'];
        if (!in_array($status, $allowed)) {
            echo json_encode(['success' => false, 'error' => 'Invalid status']);
            return;
        }

        $this->userDao->updateUserStatus($status, $userID);

        echo json_encode(['success' => true, 'status' => $status]);
    }
}
