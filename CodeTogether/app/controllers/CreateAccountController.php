<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/UserDAO.php";

    class CreateAccountController extends Controller {
        private UserDAO $userDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->renderView('createAccount');
            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirmPassword'] ?? '';
                $role = $_POST['role'] ?? '';

                if (empty(trim($password)) || empty(trim($email)) || empty(trim($role)) || empty(trim($username))) {
                    $this->renderView('createAccount', ['error' => 'Please fill out all fields!']);
                    return;
                }


                $this->userDao = new UserDAO();

                $existing = $this->userDao->getUserByName($username);

                if (!is_null($existing)) {
                    if ($existing->getUsername() === $username) {
                        $this->renderView('createAccount', ['error' => 'An account with this username already exists!']);
                        return;
                    }
                }

                if(($email)) {
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                        $this->renderView('createAccount', ['error' => 'Must be a valid email address!']);
                        return;
                    }
                }


                if ($this->userDao->checkExistingEmail($email)) {
                    $this->renderView('createAccount', ['error' => $email .' is already associated with an account!']);
                    return;
                }


                $this->userDao->addUser($username, $password, $email,(int) $role);
                $success = $this->userDao->authenticate($email,$password);

                if ($success) {
                    header('Location: index.php?action=login');
                    exit;
                } else {
                    $this->renderView('createAccount', ['error' => 'Could not create account']);
                }
            }
        }

        public function renderView(string $view, array $data = []):void {
            parent::renderView($view,$data);
        }
    }
?>