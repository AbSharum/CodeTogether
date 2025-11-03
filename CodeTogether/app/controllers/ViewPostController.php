<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/UserDAO.php";
include_once __DIR__ . "/../dao/CommentDAO.php";

class ViewPostController extends Controller
{
    private PostDAO $postDao;
    private UserDAO $userDao;
    private CommentDAO $commentDao;

    public function performAction(): void
    {
        $this->postDao = new PostDAO();
        $this->userDao = new UserDAO();
        $this->commentDao = new CommentDAO();

        $userID = $_SESSION['usercreds']['userID'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $postID = $_GET['post_id'] ?? null;

            if ($postID) {
                $user = $this->userDao->getUserByID($userID);
                $post = $this->postDao->getPostByID((int)$postID);
                $comments = $this->commentDao->getAllPostComments((int)$postID);
                $commentCount=$this->commentDao->getNumberOfComments($post->getPostID());
                $post->setComments($commentCount);

                $this->renderView("viewPost", [
                    'user' => $user,
                    'post' => $post,
                    'comments' => $comments
                ]);
                return;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = $_POST['task'] ?? null;
            $postID = $_POST['postID'] ?? null;
            $contents = $_POST['contents'] ?? null;

            $user = $this->userDao->getUserByID($userID);
            $post = $this->postDao->getPostByID((int)$postID);
            $username = $user->getUsername();

            if ($postID && $task) {
                switch ($task) {
                    case 'reply':
                        $this->commentDao->addComment($userID, $username, (int)$postID, $contents);
                        break;
                    # need to add edit, delete, report for comments
                }
            }

            $comments = $this->commentDao->getAllPostComments((int)$postID);
            $commentCount = $this->commentDao->getNumberOfComments($post->getPostID());
            $post->setComments($commentCount);

            $this->renderView("viewPost", [
                'user' => $user,
                'post' => $post,
                'comments' => $comments
            ]);
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>
