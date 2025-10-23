<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/MessageDAO.php";

    class MessagesController extends Controller {
        private MessageDAO $MessageDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->renderView('messages');
            }
        }

        public function renderView(string $view, array $data = []): void {
            include "./public/views/$view.php";
        }
    }
?>
