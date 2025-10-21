<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/dbConn.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../dao/PostDAO.php';

$userId = 1;
$conn = Database::getConnection();

$stmt = $conn->prepare("SELECT username, email, points, status FROM user WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS followers FROM friend_list WHERE user_id_2 = ? AND status = 'friends'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$followers = $stmt->get_result()->fetch_assoc()['followers'] ?? 0;
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS following FROM friend_list WHERE user_id_1 = ? AND status = 'friends'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$following = $stmt->get_result()->fetch_assoc()['following'] ?? 0;
$stmt->close();

$postDAO = new PostDAO();
$posts = $postDAO->getPostsByUser($userId);
Database::close();

echo json_encode([
    "username" => $user["username"],
    "points" => $user["points"],
    "status" => $user["status"],
    "profilePic" => "/uploads/default.png",
    "followers" => (int)$followers,
    "following" => (int)$following,
    "posts" => array_map(fn($p) => $p->jsonSerialize(), $posts)
]);
