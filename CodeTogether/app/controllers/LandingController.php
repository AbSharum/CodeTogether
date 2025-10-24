<?php
    declare(strict_types=1);

    class LandingController extends Controller {

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->renderView('landing');
            }
        }

        public function renderView(string $view, array $data = []): void {
            include "./public/views/$view.php";
        }
    }
?>
