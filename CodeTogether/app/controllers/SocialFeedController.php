<?php
    declare(strict_types=1);

    class SocialFeedController extends Controller {


        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->renderView("social-feed");
                return;
            }
        }

        public function renderView(string $view, $data = []): void {
            include "./public/$view.php";
        }
    }
?>
