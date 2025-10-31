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
            $liked = false;
        } else {
            $this->postDao->addLike($postId, $userId);
            $liked = true;
        }

        $newLikes = $this->postDao->countLikes($postId);
        $this->postDao->updateLikes($postId, $newLikes);

        //detect AJAX request, because reloading the page just for liking a post is dumb and I hate it!
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'liked' => $liked,
                'likes' => $newLikes
            ]);
            exit;
        }

        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=home';
        header("Location: $redirect");
        exit;
    }
}
