<?php
    declare(strict_types=1);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['username']) || empty($_SESSION['username']['userID'])) {
        header('Location: index.php?action=login');
        exit;
    }

    if (isset($requiredRoles) && is_array($requiredRoles)) {
        if (!in_array($_SESSION['role'], $requiredRoles)) {
            header('Location: index.php?action=noPermission');
            exit;
        }
    }
?>