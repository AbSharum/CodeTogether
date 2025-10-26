<?php
    declare(strict_types=1);
    include_once __DIR__ . "/../dao/UserDAO.php";

    class LogoutController extends Controller {
        private UserDAO $userDao;

        public function performAction(): void {

            $this->userDao = new UserDAO();

            if (isset($_SESSION['usercreds']) || !empty($_SESSION['usercreds']['userID'])) {
                $this->userDao->updateUserStatus('offline',$_SESSION['usercreds']['userID']);
                $_SESSION = [];
                session_destroy();
                $this->renderView('landing');
            } else {
                $this->renderView('landing',['error' =>  'You are currently not logged in!']);
            }

        }

        public function renderView(string $view, array $data = []): void {
            extract($data);
            include "./public/views/$view.php";
        }
    }
?>
