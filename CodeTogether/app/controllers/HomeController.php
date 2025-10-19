<?php
    declare(strict_types=1);

    class HomeController extends Controller {


        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->renderView("home");
                return;
            }
        }

        public function renderView(string $view, $data = []): void {
            include "./public/views/$view.php";
        }
    }
?>
