<?php
declare(strict_types=1);
include_once __DIR__ . '/../dao/PostDAO.php';

class LikePostController extends Controller
{
    private PostDAO $postDao;

    public function performAction(): void
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=home");
            exit;
        }

        $userId = $_SESSION['usercreds']['userID'] ?? null;
        $postId = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;

        if (!$userId || !$postId) {
            header("Location: index.php?action=home");
            exit;
        }

        $this->postDao = new PostDAO();

        if ($this->postDao->hasUserLikedPost($postId, $userId)) {
            $this->postDao->removeLike($postId, $userId);
        } else {
            $this->postDao->addLike($postId, $userId);
        }

        $newLikes = $this->postDao->countLikes($postId);
        $this->postDao->updateLikes($postId, $newLikes);

        $redirect = $_POST['redirect'] ?? 'index.php?action=home';
        header("Location: $redirect");
        exit;
    }
}
