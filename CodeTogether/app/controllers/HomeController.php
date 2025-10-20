<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/PostDAO.php";

    class HomeController extends Controller {
        private PostDAO $postDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->postDao = new PostDAO();
                $posts = $this->postDao->getAllPosts();
                $this->renderView("home", $posts);
                return;
            }
        }

        public function renderView(string $view, $posts = []): void {
            include "./public/views/$view.php";
        }
    }
?>
