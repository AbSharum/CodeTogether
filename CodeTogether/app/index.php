<?php
    declare(strict_types=1);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();


    include_once __DIR__ . "/config/Controller.php";
    include_once __DIR__ . "/config/Router.php";
    include_once __DIR__ . "/controllers/LoginController.php";
    include_once __DIR__ . "/controllers/CreateAccountController.php";
    include_once __DIR__ . "/controllers/SocialFeedController.php";
    include_once __DIR__ . "/controllers/HomeController.php";
    include_once __DIR__ . "/controllers/AccountSettingsController.php";
    include_once __DIR__ . "/controllers/MessagesController.php";


    class MyRouter extends Router {
        public function authCheck($action): void {
            if (!isset($this->controllers[$action])) {
                $action = 'default';
            }

            $controller = $this->controllers[$action];

            if ($controller) {
                $access = $controller->getAuth();
                #still working on the below. Trying to get it to redirect logged in users
                #to the 404 page if what they try to go to isnt found.
                if (!isset($this->controllers[$action])) {
                    header("Location: index.php?action=404");
                    exit;
                }
                if ($access != "PUBLIC" && !isset($_SESSION['loggedin'])) {
                    header("Location: index.php?action=login");
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
    $router->addController('home', new HomeController());
    $router->addController('accountSettings', new AccountSettingsController());
    $router->addController('messages', new MessagesController());

    # Register default controller (used when no action is specified)
    $router->addController('default', new LoginController()); 

    # Run router
    $router->run();
?>
