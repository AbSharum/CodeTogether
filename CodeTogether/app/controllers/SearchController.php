<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/PostDAO.php";
    include_once __DIR__ . "/../dao/UserDAO.php";
    include_once __DIR__ . "/../dao/FriendListDAO.php";

    class SearchController extends Controller {
        private PostDAO $postDao;
        private UserDAO $userDao;
        private FriendListDAO $friendDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->postDao = new PostDAO();
                $this->userDao = new UserDAO();
                $this->friendDao= new FriendListDAO();

                # Take off any extra spaces
                $search = trim($_POST['search'] ?? '');
                $userID = $_SESSION['usercreds']['userID'];

                // Sends friend request if task is assigned
                if (isset($_POST['friendId']) && $_POST['friendId'] !== '') {
                    $friendID = (int)$_POST['friendId'];
                    $this->friendDao->sendFriendRequest($userID, $friendID);
                }

                $friends = $this->friendDao->getFriends($userID) ?? [];
                $friendsUsers = $this->userDao->getFriendUsers($friends);

                $users = $this->userDao->searchUsersByName($search);
                $posts = $this->postDao->searchPostsByTerm($search);

                // Remove users that are already friends from users
                $friendIds = array_map(fn($user) => $user->getUserId(), $friendsUsers);
                $users = array_filter($users, fn($user) => !in_array($user->getUserId(), $friendIds));

                // Render view
                $this->renderView("search", [
                    'posts' => $posts,
                    'users' => $users,
                    'friendsUsers' => $friendsUsers,
                    'search' => $search,
                    'userID' => $userID
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