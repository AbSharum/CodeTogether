<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/UserDAO.php";

class AddProfilePictureController extends Controller
{
    private UserDAO $userDao;

    public function performAction(): void
    {
        $fileName = '';

        if (!isset($_FILES['profilePic']) || $_FILES['profilePic']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['upload_error'] = 'Please select a valid file to upload.';
            header('Location: index.php?action=profile');
            exit;
        }

        $uploadDir = __DIR__ . '/../public/uploads/';

        // testing this out
        if (!is_dir($uploadDir)) {
            // Create the directory recursively (the 'true' argument) with 0775 permissions
            if (!mkdir($uploadDir, 0775, true)) {
                $_SESSION['upload_error'] = 'Upload directory does not exist and could not be created.';
                header('Location: index.php?action=profile');
                exit;
            }
        }


        $originalName = basename($_FILES['profilePic']['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowedExtensions)) {
            $_SESSION['upload_error'] = "Invalid file type: .$extension — allowed types are JPG, JPEG, PNG, GIF.";
            header('Location: index.php?action=profile');
            exit;
        }

        $newFileName = uniqid('pfp_', true) . '.' . $extension;
        $filePath = $uploadDir . $newFileName;

        if (!move_uploaded_file($_FILES['profilePic']['tmp_name'], $filePath)) {
            $_SESSION['upload_error'] = 'Failed to upload the file. Please try again.';
            header('Location: index.php?action=profile');
            exit;
        }

        $this->userDao = new UserDAO();
        $userID = $_SESSION['usercreds']['userID'];

        $success = $this->userDao->updateProfilePicture($userID, $newFileName);

        if (!$success) {
            $_SESSION['upload_error'] = 'Database update failed.';
            header('Location: index.php?action=profile');
            exit;
        }

        $_SESSION['upload_success'] = 'Profile picture updated successfully!';
        header('Location: index.php?action=profile');
        exit;
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>
