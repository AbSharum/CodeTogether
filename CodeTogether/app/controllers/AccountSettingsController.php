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

            switch ($updateType) {
                case 'username':
                    $this->userDao->updateUsername($_SESSION['usercreds']['userID'], $_POST['username']);
                    $_SESSION['usercreds']['username'] = $_POST['username'];
                    break;

                case 'email':
                    $this->userDao->updateEmail($_SESSION['usercreds']['userID'], $_POST['usercreds']['email']);
                    $_SESSION['email'] = $_POST['email'];
                    break;

                case 'password':
                    $this->userDao->updatePassword($_SESSION['usercreds']['userID'], $_POST['password']);
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
                'theme' => $_SESSION['theme']
            ]);
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>