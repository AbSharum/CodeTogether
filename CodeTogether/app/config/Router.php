<?php
declare(strict_types=1);
include_once __DIR__ . "/Controller.php";

class Router
{
    public $controllers;

    public function __construct()
    {
        $this->showErrors(0);
        $this->controllers = [];
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function run(): void
    {
        $action = $_REQUEST['action'] ?? 'default';

        $this->authCheck($action);

        if (!isset($this->controllers[$action])) {
            $action = 'default';
        }

        $controller = $this->controllers[$action];
        $controller->performAction();
    }

    public function addController(string $action, Controller $controller): void
    {
        $this->controllers[$action] = $controller;
    }

    public function authCheck(string $action): void
    {
        $protectedRoutes = [
            'home' => ['student', 'teacher', 'moderator'],
            'accountSettings' => ['student', 'teacher', 'moderator'],
            'messages' => ['student', 'teacher', 'moderator'],
            'game' => ['student', 'teacher', 'moderator'],
            'profile' => ['student', 'teacher', 'moderator'],
            'search' => ['student', 'teacher', 'moderator']
        ];

        if (isset($protectedRoutes[$action])) {
            if (!isset($_SESSION['usercreds']) || empty($_SESSION['usercreds']['userID'])) {
                header('Location: index.php?action=login');
                exit;
            }

            $userRole = $_SESSION['usercreds']['role'] ?? null;
            if (!in_array($userRole, $protectedRoutes[$action])) {
                header('Location: index.php?action=noPermission');
                exit;
            }
        }
    }

    public function showErrors(int $debug): void
    {
        if ($debug === 1) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL & ~E_NOTICE);
        }
    }
}
?>