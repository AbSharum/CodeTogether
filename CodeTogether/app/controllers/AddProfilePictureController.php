<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/UserDAO.php";

class AddProfilePictureController extends Controller
{
    private UserDAO $userDao;

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('updateProfilePicture');
        } 
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fileName = '';

            if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/uploads/';

                $originalName = basename($_FILES['profilePic']['name']);
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);

                $newFileName = uniqid('pfp_', true) . '.' . $extension;
                $filePath = $uploadDir . $newFileName;

                if (!move_uploaded_file($_FILES['profilePic']['tmp_name'], $filePath)) {
                    $this->renderView('addProfilePicture', ['error' => 'Failed to upload the file.']);
                    return;
                }

                $fileName = $newFileName;
            } 
            else {
                $this->renderView('addProfilePicture', ['error' => 'Please select a file to upload.']);
                return;
            }

            $this->userDao = new UserDAO();
            $userID = $_SESSION['usercreds']['userID'];

            $success = $this->userDao->updateProfilePicture($userID, $fileName);

            if (!$success) {
                $this->renderView('addProfilePicture', ['error' => 'Database update failed.']);
                return;
            }

            header('Location: index.php?action=profile');
            exit;
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>
