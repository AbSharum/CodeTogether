<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/PostDAO.php";
    include_once __DIR__ . "/../dao/UserDAO.php";


    class HomeController extends Controller {
        private PostDAO $postDao;
        private UserDAO $userDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->postDao = new PostDAO();
                $this->userDao = new UserDAO();
                $user = $this->userDao->getUserByName($_SESSION['username']);
                $posts = $this->postDao->getAllPosts();
                $data = [
                    'user' => $user,
                    'posts' => $posts
                ];
                $this->renderView("home", $data);
                return;
            }
        }

        public function renderView(string $view, $data = []): void {
            include "./public/views/$view.php";
        }
    }
?>
