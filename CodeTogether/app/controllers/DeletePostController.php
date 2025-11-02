<?php
declare(strict_types=1);

include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/UserDAO.php";

class DeletePostController extends Controller
{
    private PostDAO $postDao;
    private UserDAO $userDao;

    public function performAction(): void
    {
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=home';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->postDao = new PostDAO();
            $this->userDao = new UserDAO();

            $postID = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
            $userID = $_SESSION['usercreds']['userID'] ?? 0;

            if ($postID <= 0 || $userID <= 0) {
                $this->renderView('home', ['error' => 'Invalid delete request.']);
                return;
            }

            $post = $this->postDao->getPostByID($postID);

            if ($post && (int)$post->getUserID() === (int)$userID) {
                $this->postDao->deletePost($postID);
                $data['message'] = 'Post successfully deleted.';
            } else {
                $data['error'] = 'You are not authorized to delete this post.';
            }

            header("Location: $redirect");
            exit;
        } else {
            header("Location: $redirect");
            exit;
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>
