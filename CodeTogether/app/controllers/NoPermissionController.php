<?php
declare(strict_types=1);

class NoPermissionController extends Controller
{
    private UserDAO $userDao;

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('noPermission');
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
        ;
    }
}
?>