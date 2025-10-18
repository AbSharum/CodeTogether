<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    declare(strict_types=1);


    include_once __DIR__ . "/config/Controller.php";
    include_once __DIR__ . "/config/Router.php";
    include_once __DIR__ . "/controllers/LoginController.php";
    include_once __DIR__ . "/controllers/CreateAccountController.php";
    include_once __DIR__ . "/controllers/SocialFeedController.php";

    class MyRouter extends Router {
        public function authCheck($action): void {
            if (!isset($this->controllers[$action])) {
                $action = 'default';
            }

            $controller = $this->controllers[$action];

            if ($controller) {
                $access = $controller->getAuth();
                if ($access != "PUBLIC" && !isset($_SESSION['loggedin'])) {
                    header("Location: start.php?action=login");
                    exit;
                }
            }
        }
    }

    # Create router instance
    $router = new MyRouter();
    $router->showErrors(1);

    # Register controllers
    $router->addController('login', new LoginController());
    $router->addController('createAccount', new CreateAccountController());
    $router->addController('social-feed', new SocialFeedController());

    # Register default controller (used when no action is specified)
    $router->addController('default', new LoginController()); 

    # Run router
    $router->run();
?>
