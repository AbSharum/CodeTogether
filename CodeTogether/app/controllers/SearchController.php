<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/UserDAO.php";
include_once __DIR__ . "/../dao/FriendListDAO.php";

class SearchController extends Controller
{
    private PostDAO $postDao;
    private UserDAO $userDao;
    private FriendListDAO $friendDao;

    public function performAction(): void
    {
        $this->postDao = new PostDAO();
        $this->userDao = new UserDAO();
        $this->friendDao = new FriendListDAO();

        $userID = $_SESSION['usercreds']['userID'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = $_POST['task'] ?? null;
            $friendID = isset($_POST['friendId']) ? (int)$_POST['friendId'] : null;
            $search = trim($_POST['search'] ?? '');

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

            
            $redirect = $_POST['redirect'] ??  "index.php?action=search&search=".$search;
            header("Location: $redirect");
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        $relations = $this->friendDao->getAllRelationships($userID);
        $users = $this->userDao->searchUsersByName($search);
        $posts = $this->postDao->searchPostsByTerm($search);
        $likedPosts = $this->postDao->getLikedPostIdsByUser($userID);

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

        $this->renderView("search", [
            'posts' => $posts,
            'users' => $users,
            'search' => $search,
            'userID' => $userID,
            'likedPosts' => $likedPosts
        ]);
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>
