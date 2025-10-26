<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/MessageDAO.php";
    include_once __DIR__ . "/../dao/PostDAO.php";
    include_once __DIR__ . "/../dao/FriendListDAO.php";
    include_once __DIR__ . "/../dao/UserDAO.php";

    class MessagesController extends Controller {
        private MessageDAO $MessageDao;
        private PostDAO $postDao;
        private FriendListDAO $friendDao;
        private UserDAO $userDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->friendDao = new FriendListDAO();
                $this->userDao = new UserDAO();

                $userID = $_SESSION['usercreds']['userID'];
                $user = $this->userDao->getUserByID($userID);
                $friends = $this->friendDao->getFriends($userID);
                $friendsUser = $this->userDao->getFriendUsers($friends);




                $this->renderView("messages", [
                    'friends' => $friends,
                    'friendsUser' => $friendsUser,
                    'user' => $user
                ]);
                return;
            }
        }

        public function renderView(string $view, array $data = []): void {
            include "./public/views/$view.php";
        }
    }
?>
