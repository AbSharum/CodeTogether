<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/UserDAO.php";

class AccountSettingsController extends Controller
{
    private UserDAO $userDao;

    public function __construct()
    {
        $this->userDao = new UserDAO();
    }

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView('accountSettings', [
                'username' => $_SESSION['usercreds']['username'] ?? '',
                'email' => $_SESSION['usercreds']['email'] ?? '',
                'rain_enabled' => $_SESSION['rain_enabled'] ?? false,
                'theme' => $_SESSION['theme'] ?? 'light'
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateType = $_POST['update'] ?? '';
            $error = '';

            switch ($updateType) {
                case 'username':
                    $newUsername = trim($_POST['username'] ?? '');
                    if (empty($newUsername)) {
                        $error = 'Username cannot be empty.';
                        break;
                    }
                    if ($this->userDao->checkExistingUser($newUsername)) {
                        $error = 'An account with this username already exists!';
                        break;
                    }
                    $this->userDao->updateUsername($_SESSION['usercreds']['userID'], $newUsername);
                    $_SESSION['usercreds']['username'] = $newUsername;
                    break;

                case 'email':
                    $newEmail = trim($_POST['email'] ?? '');
                    if (empty($newEmail)) {
                        $error = 'Email cannot be empty.';
                        break;
                    }
                    if ($this->userDao->checkExistingEmail($newEmail)) {
                        $error = 'An account with this email already exists!';
                        break;
                    }
                    $this->userDao->updateEmail($_SESSION['usercreds']['userID'], $newEmail);
                    $_SESSION['usercreds']['email'] = $newEmail;
                    break;

                case 'password':
                    $newPassword = trim($_POST['password'] ?? '');
                    if (empty($newPassword)) {
                        $error = 'Password cannot be empty.';
                        break;
                    }
                    $this->userDao->updatePassword($_SESSION['usercreds']['userID'], $newPassword);
                    break;

                case 'preferences':
                    $rain = isset($_POST['rain']) ? 1 : 0;
                    $theme = $_POST['theme'] ?? 'light';
                    $_SESSION['rain_enabled'] = (bool) $rain;
                    $_SESSION['theme'] = $theme;
                    $this->userDao->updatePreferences($_SESSION['usercreds']['userID'], $rain, $theme);
                    break;
            }

            $this->renderView('accountSettings', [
                'username' => $_SESSION['usercreds']['username'],
                'email' => $_SESSION['usercreds']['email'],
                'rain_enabled' => $_SESSION['rain_enabled'],
                'theme' => $_SESSION['theme'],
                'error' => $error
            ]);
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>