<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/UserDAO.php";


    class LoginController extends Controller {
        private UserDAO $userDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->renderView("fancylogin");
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $identefier = $_POST['identefier'] ?? '';
                $password = $_POST['password'] ?? '';

                $this->userDao = new UserDAO();
                $result = $this->userDao->authenticate($identefier, $password);

                if ($result === null) {
                    header('Location: index.php?action=login');
                    exit;
                } else {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['userID'] = $result->getUserID();
                    $_SESSION['username'] = $result->getUsername();
                    $_SESSION['role'] = $result->getRoleID();

                    header('Location: index.php?action=home');
                    exit;
                }
            }
        }

        public function renderView(string $view, $data = []): void {
            include "./public/views/$view.php";
        }
    }
?>
