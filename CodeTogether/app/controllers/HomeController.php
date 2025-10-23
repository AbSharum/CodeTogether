<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/PostDAO.php";
    include_once __DIR__ . "/../dao/FriendListDAO.php";
    include_once __DIR__ . "/../dao/UserDAO.php";

    class HomeController extends Controller {
        private PostDAO $postDao;
        private FriendListDAO $friendDao;
        private UserDAO $userDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->postDao = new PostDAO();
                $this->friendDao = new FriendListDAO();
                $this->userDao = new UserDAO();

                $userID = $_SESSION['userID'];
                $user = $this->userDao->getUserByID($userID);
                $friends = $this->friendDao->getFriends($userID);
                $friendPosts = $this->postDao->getPostsByFriends($friends);
                $posts = $this->postDao->getPostsByUser($userID);
                $friendsUser = $this->userDao->getFriendUsers($friends);




                $this->renderView("home", [
                    'friendPosts' => $friendPosts,
                    'userPosts' => $posts,
                    'friends' => $friends,
                    'friendsUser' => $friendsUser,
                    'user' => $user
                ]);
                return;
            }
        }

        public function renderView(string $view, array $data = []): void {
            extract($data);
            include "./public/views/$view.php";
        }
    }
?>
