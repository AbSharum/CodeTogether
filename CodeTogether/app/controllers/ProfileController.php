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

            // Initialize DAOs
            $this->userDao = new UserDAO();
            $this->postDao = new PostDAO();
            $this->friendDao = new FriendListDAO();

            // --- Determine which profile to show ---
            // If ?user_id= is provided in the URL, show that user's profile
            // Otherwise, fall back to the logged-in user's profile
            $userID = isset($_GET['user_id'])
                ? (int) $_GET['user_id']
                : (int) ($_SESSION['usercreds']['userID'] ?? 0);

            if ($userID <= 0) {
                // No valid ID? redirect or error
                header('Location: index.php?action=login');
                exit;
            }

            // --- Fetch main user profile data ---
            $user = $this->userDao->getUserByID($userID);
            if (!$user) {
                http_response_code(404);
                echo "User not found.";
                return;
            }

            // --- Gather profile-related data ---
            $posts       = $this->postDao->getPostsByUser($userID);
            $friends     = $this->friendDao->getFriends($userID);
            $friendsUser = $this->userDao->getFriendUsers($friends);

            // --- Render profile view (server-side) ---
            $this->renderView("profile", [
                'user'        => $user,
                'userPosts'   => $posts,
                'friends'     => $friends,
                'friendsUser' => $friendsUser
            ]);
        }
    }

    public function renderView(string $view, array $data = []): void {
        parent::renderView($view, $data);
    }
}
?>
