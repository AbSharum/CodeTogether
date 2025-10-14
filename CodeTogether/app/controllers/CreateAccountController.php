<?php
include_once "./dao/UserDao.php";

class CreateAccountController extends Controller {
    private $userDao;

    public function performAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->renderView('createAccount');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            if ($password !== $confirmPassword) {
                $this->renderView('createAccount', ['error' => 'Passwords do not match']);
                return;
            }

            $this->userDao = new UserDao();

            $success = $this->userDao->addUser($username, $password, $email);

            if ($success) {
                header('Location: index.php?action=login');
                exit;
            } else {
                $this->renderView('createAccount', ['error' => 'Could not create account']);
            }
        }
    }

    public function renderView($view, $data = []) {
        include "./public/$view.php";
    }
}
