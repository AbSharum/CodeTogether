<?php
declare(strict_types=1);
include_once __DIR__ . "/../dao/UserDAO.php";

class CreateAccountController extends Controller
{
    private UserDAO $userDao;

    public function performAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('createAccount');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            $role = trim(($_POST['role'] ?? 0));
            $keyEntered = trim($_POST['roleKey'] ?? '');

            if (empty(trim($password)) || empty($email) || empty($role) || empty($username)) {
                $this->renderView('createAccount', ['error' => 'Please fill out all fields!']);
                return;
            }


            $role = (int) $role;
            $this->userDao = new UserDAO();

            $existing = $this->userDao->getUserByName($username);

            $moderatorKey = getenv('MODERATOR_KEY');
            $teacherKey = getenv('TEACHER_KEY');

            if ($role === 1 && $keyEntered !== $moderatorKey) {
                $this->renderView('createAccount', ['error' => 'Invalid access key for Moderator role.']);
                return;
            }

            if ($role === 3 && $keyEntered !== $teacherKey) {
                $this->renderView('createAccount', ['error' => 'Invalid access key for Teacher role.']);
                return;
            }

            if (!is_null($existing)) {
                if ($existing->getUsername() === $username) {
                    $this->renderView('createAccount', ['error' => 'An account with this username already exists!']);
                    return;
                }
            }

            if (($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->renderView('createAccount', ['error' => 'Must be a valid email address!']);
                    return;
                }
            }


            if ($this->userDao->checkExistingEmail($email)) {
                $this->renderView('createAccount', ['error' => $email . ' is already associated with an account!']);
                return;
            }


            $this->userDao->addUser($username, $password, $email, $role);
            $success = $this->userDao->authenticate($email, $password);

            if ($success) {
                header('Location: index.php?action=login');
                exit;
            } else {
                $this->renderView('createAccount', ['error' => 'Could not create account']);
            }
        }
    }

    public function renderView(string $view, array $data = []): void
    {
        parent::renderView($view, $data);
    }
}
?>