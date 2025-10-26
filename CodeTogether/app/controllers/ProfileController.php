<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');

require_once __DIR__ . '/../dao/ProfileDAO.php';
session_start();


if (!isset($_SESSION['usercreds']['userID'])) {
    $_SESSION['usercreds']['userID'] = 1; //fallback user is Alice
}


if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $userId = (int)$_GET['user_id']; //viewing someone else's profile
} else {
    $userId = (int)$_SESSION['usercreds']['userID']; //viewing your own profile
}

try {
    $dao = new ProfileDAO();
    error_log("DEBUG userId: " . $userId);//Getting the id of the viewed user, just a debugging measure
    $user = $dao->getUserData($userId);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    $followers = $dao->getFollowerCount($userId);
    $following = $dao->getFollowingCount($userId);
    $posts = $dao->getUserPosts($userId);

    echo json_encode([
        'username' => $user['username'],
        'points' => $user['points'],
        'status' => $user['status'],
        'profilePic' => '/uploads/default.png',
        'followers' => $followers,
        'following' => $following,
        'posts' => array_map(fn($p) => $p->jsonSerialize(), $posts)
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'details' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}
?>
