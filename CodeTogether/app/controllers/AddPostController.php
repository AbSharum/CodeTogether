<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/UserDAO.php";
include_once __DIR__ . "/../dao/PostDAO.php";
include_once __DIR__ . "/../dao/ThreadDAO.php";
include_once __DIR__ . "/../models/Thread.php";


class AddPostController extends Controller
{
    private UserDAO $userDao;
    private PostDAO $postDao;
    private ThreadDAO $threadDao;

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('addPost');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'] ?? '';
            $contents = $_POST['contents'] ?? '';
            $visibility = $_POST['visibility'] ?? '';
            $extension = '';

            $fileName = '';

            if (isset($_FILES['postFile']) && $_FILES['postFile']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/uploads/';
                $originalName = basename($_FILES['postFile']['name']);
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $newFileName = uniqid('post_', true) . '.' . $extension;
                $filePath = $uploadDir . $newFileName;

                move_uploaded_file($_FILES['postFile']['tmp_name'], $filePath);
                $fileName = $newFileName;
            }

            if (empty(trim($title)) || empty(trim($contents)) || empty(trim($visibility))) {
                $this->renderView('addPost', ['error' => 'Please fill out all fields!']);
                return;
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4'];

            if (!empty(trim($extension)) && !in_array($extension, $allowedExtensions)) {
                $this->renderView('addPost', [
                    'error' => "Invalid file type: .$extension — allowed types are JPG, JPEG, PNG, GIF."
                ]);
                return;
            }


            $this->userDao = new UserDAO();
            $this->threadDao = new ThreadDAO();
            $this->postDao = new PostDAO();

            $userID = $_SESSION['usercreds']['userID'];
            $username = $_SESSION['usercreds']['username'];

            $this->threadDao->addThread($title, $userID);
            $thread = $this->threadDao->getThreadByTitle($title);
            $threadId = $thread->getThreadID();

            $this->postDao->addPost($userID, $threadId, $username, $fileName, $title, $visibility,$contents);

            header('Location: index.php?action=home');
            exit;


        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>