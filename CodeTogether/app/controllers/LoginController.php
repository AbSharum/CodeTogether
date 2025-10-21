<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/UserDAO.php";
    include_once __DIR__ . "/../dao/RoleDAO.php";


    class LoginController extends Controller {
        private UserDAO $userDao;
        private RoleDAO $roleDao;

        public function performAction(): void {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->renderView("fancylogin");
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $identifier = $_POST['identifier'] ?? '';
                $password = $_POST['password'] ?? '';

                if (empty(trim($identifier)) || empty(trim($password))) {
                    $this->renderView("fancylogin",['error' =>  'Please fill out all fields']);
                    exit;
                }

                $this->userDao = new UserDAO();
                $this->roleDao = new RoleDAO();
                $result = $this->userDao->authenticate($identifier, $password);

                if ($result !== null) {
                    $role = $this->roleDao->getUserRole($result);
                }
                

                if ($result === null || $role === null) {
                    $this->renderView("fancylogin",['error' =>  'An account with this username or email does not exist!']);
                    exit;
                } else {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['userID'] = $result->getUserID();
                    $_SESSION['username'] = $result->getUsername();
                    $_SESSION['role'] = $role->getRoleName();
                    header('Location: index.php?action=home');
                    exit;
                }
            }
        }

        public function renderView(string $view, $data = []): void {
            extract($data);
            include "./public/views/$view.php";
        }
    }
?>
