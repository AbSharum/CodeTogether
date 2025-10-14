<?php
include_once "./dao/UserDao.php";

class LoginController extends Controller {
    private $userDao;

    public function performAction() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView("fancyLogin");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $this->userDao = new UserDao();
            $result = $this->userDao->authenticate($email, $password);

            if ($result === null) {
                header('Location: index.php?action=login');
                exit;
            } else {
                $_SESSION['loggedin'] = true;
                $_SESSION['userID'] = $result->getUserID();
                $_SESSION['username'] = $result->getUsername();
                $_SESSION['role'] = $result->getRoleID();

                header('Location: index.php?action=social-feed');
                exit;
            }
        }
    }

    public function renderView($view, $data = []) {
        include "./public/$view.php";
    }
}
