<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/UserDAO.php";

class EditPostController extends Controller
{
    private PostDAO $postDao;
    private UserDAO $userDao;

    public function performAction(): void
    {
        $this->postDao = new PostDAO();
        $this->userDao = new UserDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updatePost();
        } else {
            header('Location: index.php?action=home');
            exit;
        }
    }

    private function updatePost(): void
    {
        $postID = (int)$_POST['post_id'];
        $content = trim($_POST['content']);
        $userID = $_SESSION['usercreds']['userID'] ?? 0;
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=home';

        if ($postID && !empty($content)) {
            $post = $this->postDao->getPostByID($postID);
            if ($post && (int)$post->getUserID() === (int)$userID) {
                $this->postDao->updatePostContents($postID, $content);
            }
        }

        header("Location: $redirect");
        exit;
    }

}
?>
