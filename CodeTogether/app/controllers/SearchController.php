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

                // Take off any extra spaces
                $search = trim($_POST['search'] ?? '');
                $userID = $_SESSION['usercreds']['userID'];

                // Sends friend request if task is assigned
                $task = $_POST['task'] ?? null;
                $friendID = isset($_POST['friendId']) ? (int)$_POST['friendId'] : null;

                if ($friendID && $task) {
                    switch ($task) {
                        case 'request':
                            $this->friendDao->sendFriendRequest($userID, $friendID);
                            break;
                        
                        case 'block':
                            $this->friendDao->blockUser($userID, $friendID);
                            break;

                        case 'unblock':
                            $this->friendDao->unblockUser($userID, $friendID);
                            break;
                        
                        case 'accept':
                            $this->friendDao->acceptFriendRequest($userID, $friendID);
                            break;

                        case 'remove':
                            $this->friendDao->removeFriend($userID, $friendID);
                            break;    
                        
                        case 'reject':
                            $this->friendDao->removeFriend($userID, $friendID);
                            break;
                    }
                }


                $relations = $this->friendDao->getAllRelationships($userID);
                $users = $this->userDao->searchUsersByName($search);
                $posts = $this->postDao->searchPostsByTerm($search);

                foreach ($users as $user) {
                    $tempUserID = $user->getUserId();
                    if (isset($relations[$tempUserID])) {
                        $user->setStatus($relations[$tempUserID]['status']);
                        $user->setRequestInitiatorID($relations[$tempUserID]['initiated_by']);
                    } else {
                        $user->setStatus('not-friends');
                        $user->setRequestInitiatorID(-1);
                    }
                }


                // Render view
                $this->renderView("search", [
                    'posts' => $posts,
                    'users' => $users,
                    'search' => $search,
                    'userID' => $userID
                ]);
                return;
            }
        }

        public function renderView(string $view, array $data = []): void {
            parent::renderView($view,$data);;
        }
    }
?>