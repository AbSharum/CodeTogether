<?php
    declare(strict_types=1);


    class LogoutController extends Controller {

        public function performAction(): void {
            session_destroy();
            $this->renderView("landing");
        }

        public function renderView(string $view, array $data = []): void {
            extract($data);
            include "./public/views/$view.php";
        }
    }
?>
