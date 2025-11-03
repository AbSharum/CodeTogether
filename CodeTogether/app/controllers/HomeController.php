<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/FriendListDAO.php";
include_once __DIR__ . "/../dao/UserDAO.php";
include_once __DIR__ . "/../dao/CommentDAO.php";

class HomeController extends Controller
{
    private PostDAO $postDao;
    private FriendListDAO $friendDao;
    private UserDAO $userDao;
    private CommentDAO $commentDao;

    public function performAction(): void
    {
        $userID = $_SESSION['usercreds']['userID'];
        $this->postDao = new PostDAO();
        $this->friendDao = new FriendListDAO();
        $this->userDao = new UserDAO();
        $this->commentDao = new CommentDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aboutMe = trim($_POST['aboutMe'] ?? '');

            if (!empty($aboutMe)) {
                $this->userDao->updateAboutMe($userID, $aboutMe);
            }

            header("Location: index.php?action=home");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $user = $this->userDao->getUserByID($userID);
            $friends = $this->friendDao->getFriends($userID);
            $friendPosts = $this->postDao->getPostsByFriends($friends);
            $posts = $this->postDao->getPostsByUser($userID);
            $friendsUser = $this->userDao->getFriendUsers($friends);
            $userAndFriendPosts = $this->postDao->getPostsByFriendsAndUser($friends, $userID);
            $likedPosts = $this->postDao->getLikedPostIdsByUser($userID);
            $aboutMe = $this->userDao->getAboutMe($userID);
            
            foreach ($userAndFriendPosts as $post) {
                $comments=$this->commentDao->getNumberOfComments($post->getPostID());
                $post->setComments($comments);
            }
            

            $this->renderView("home", [
                'friendPosts' => $friendPosts,
                'likedPosts' => $likedPosts,
                'userPosts' => $posts,
                'userAndFriendPosts' => $userAndFriendPosts,
                'friends' => $friends,
                'friendsUser' => $friendsUser,
                'user' => $user,
                'aboutMe' => $aboutMe
            ]);
            return;
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
        ;
    }
}
?>