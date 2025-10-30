<?php
declare(strict_types=1);

include_once __DIR__ . "/../dao/UserDAO.php";
include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/FriendListDAO.php";

class ProfileController extends Controller
{
    private UserDAO $userDao;
    private PostDAO $postDao;
    private FriendListDAO $friendDao;

    public function performAction(): void
    {
        $this->userDao = new UserDAO();
        $this->postDao = new PostDAO();
        $this->friendDao = new FriendListDAO();



        $userID = $_GET['user_id'] ?? ($_SESSION['usercreds']['userID'] ?? 0);
        if (!$userID) {
            header('Location: index.php?action=login');
            exit;
        }   

        $userID = (int) $userID;

        $user = $this->userDao->getUserByID((int) $userID);
        if (!$user) {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        

        $posts = $this->postDao->getPostsByUser($userID);
        $friends = $this->friendDao->getFriends($userID);
        $friendsUser = $this->userDao->getFriendUsers($friends);
        $likedPosts = $this->postDao->getLikedPostIdsByUser($userID);

        $this->renderView('profile', [
            'user' => $user,
            'friends' => $friends,
            'friendsUser' => $friendsUser,
            'userPosts' => $posts,
            'likedPosts' => $likedPosts
        ]);

        
    }


}
?>
