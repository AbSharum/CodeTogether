<?php
    declare(strict_types=1);

    class NotFoundController extends Controller {


        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->renderView("404");
                return;
            }
        }

        public function renderView(string $view, $data=[]): void {
            include "./public/views/$view.php";
        }
    }
?>
