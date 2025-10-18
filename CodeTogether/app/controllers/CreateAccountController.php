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

                if ($password === '' || $email === '' || $role === '' || $username === '') {
                    $this->renderView('createAccount', ['error' => 'Please fill out all fields!']);
                    return;
                }


                $this->userDao = new UserDAO();

                $existing = $this->userDao->getUserByName($username);

                if ($existing !== null) {
                    $this->renderView('createAccount', ['error' => 'This username is taken!']);
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

        public function renderView(string $view, $data = []):void {
            include "./public/$view.php";
        }
    }
?>