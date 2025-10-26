<?php
    declare(strict_types=1);

    include_once __DIR__ . "/../dao/UserDAO.php";
    include_once __DIR__ . "/../dao/PostDAO.php";
    include_once __DIR__ . "/../dao/FriendListDAO.php";

    class ProfileController extends Controller {
        private UserDAO $userDao;
        private PostDAO $postDao;
        private FriendListDAO $friendDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->userDao = new UserDAO();
                $this->postDao = new PostDAO();
                $this->friendDao = new FriendListDAO();


                $userID = isset($_GET['user_id']) ? (int)$_GET['user_id'] : ($_SESSION['usercreds']['userID'] ?? 0);
                if ($userID <= 0) {
                    http_response_code(400);
                    echo "Invalid or missing user ID.";
                    return;
                }


                $user = $this->userDao->getUserByID($userID);
                if (!$user) {
                    http_response_code(404);
                    echo "User not found.";
                    return;
                }


                $posts = $this->postDao->getPostsByUser($userID);
                //$followers = $this->friendDao->getFollowers($userID);
                //$following = $this->friendDao->getFollowing($userID);
                $friends = $this->friendDao->getFriends($userID);
                $friendsUser = $this->userDao->getFriendUsers($friends);

                $this->renderView("profile", [
                    'user' => $user,
                    'posts' => $posts,
                    //'followers' => $followers,
                    //'following' => $following,
                    'friends' => $friends,
                    'friendsUser' => $friendsUser
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
