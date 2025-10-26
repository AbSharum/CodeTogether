<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/PostDAO.php";
    include_once __DIR__ . "/../dao/UserDAO.php";

    class SearchController extends Controller {
        private PostDAO $postDao;
        private UserDAO $userDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->postDao = new PostDAO();
                $this->userDao = new UserDAO();

                #takes off any extra spaces
                $search=trim($_POST['search'] ?? '');

                $users = $this->userDao->searchUsersByName($search);
                $posts = $this->postDao->searchPostsByTerm($search);

                $this->renderView("search", [
                    'posts' => $posts,
                    'users' => $users
                ]);
                return;
            }
        }

        public function renderView(string $view, array $data = []): void {
            parent::renderView($view,$data);;
        }
    }
?>