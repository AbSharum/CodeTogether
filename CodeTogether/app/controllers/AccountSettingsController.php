<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/UserDAO.php";

class AccountSettingsController extends Controller
{
    private UserDAO $userDao;

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('accountSettings');
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
        ;
    }
}
?>