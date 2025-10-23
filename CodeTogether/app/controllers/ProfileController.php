<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);

header('Content-Type: application/json');

require_once __DIR__ . '/../dao/ProfileDAO.php';
session_start();

//if (!isset($_SESSION['user_id'])) {
//    http_response_code(401);
//    echo json_encode(['error' => 'Not logged in']);
//    exit;
//}

// Temporary override for the Alice user, we can remove this once we get individual logins working
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
}



$userId = (int)$_SESSION['user_id'];

try {
    $dao = new ProfileDAO();
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
} //catch (Throwable $e) {
    //http_response_code(500);
    //echo json_encode(['error' => 'Server error']);
    catch (Throwable $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Server error',
            'details' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
}
?>
