<?php
header('Content-Type: application/json');

//Can remove these two later
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);


require_once __DIR__ . '/../../config/dbConn.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../dao/PostDAO.php';

// Testing for user 1 for now. Will delete later
$userId = 1;

$conn = Database::getConnection();

// --- Fetch user basic info ---
$stmt = $conn->prepare("SELECT username, email, points, status FROM user WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
$stmt->close();

// --- Follower / following counts from friend_list ---
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

// --- Get posts via DAO ---
$postDAO = new PostDAO();
$posts = $postDAO->getPostsByUser($userId);
//$posts = $postDAO->getAllPosts();  //Use this if we wanted to get all of the posts

Database::close();  //$conn->close();

// --- Prepare JSON ---
echo json_encode([
    "username" => $user["username"],
    "points" => $user["points"],
    "status" => $user["status"],
    "profilePic" => "/uploads/default.png", // or load from a profile table later
    "followers" => (int)$followers,
    "following" => (int)$following,
    "posts" => array_map(fn($p) => $p->jsonSerialize(), $posts)
]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
  <header>
    <div>
      <img src="https://via.placeholder.com/80" alt="User avatar" class="avatar">
      <button onclick="window.location='home.php'">Go to Home</button>
    </div>
  </header>

  <main class="main">
    <section>
      <h2>Posts</h2>
      <form id="postForm">
        <textarea name="newPost" id="newPost" rows="3" placeholder="What's on your mind?"></textarea><br>
        <button type="submit">Post</button>
      </form>
      <div id="posts"></div>
    </section>

    <aside class="profile-card">
      <img id="profilePic" src="default.png" alt="Profile picture">
      <form id="picForm" enctype="multipart/form-data">
        <input type="file" name="profilePic" id="profilePicInput"><br>
        <button type="submit">Change Picture</button>
      </form>

      <h3 id="fullname"></h3>
      <p id="username"></p>
      <textarea id="bio" rows="3"></textarea><br>
      <button id="saveBio">Save Bio</button>

      <p><strong>Location:</strong> <span id="location"></span></p>
      <p><strong>Joined:</strong> <span id="joined"></span></p>
      <p><strong>Followers:</strong> <span id="followers"></span> | 
         <strong>Following:</strong> <span id="following"></span></p>
    </aside>
  </main>

  <img src="images/maid.webp" id="maid" alt="AI assistant">
  <div id="speech"></div>

  <form id="maidForm">
    <input type="text" id="maidInput" placeholder="Ask the maid...">
    <button type="submit">Send</button>
  </form>

  <div id="personalityMenu">
    <h3>Select AI Personality</h3>
    <select id="personalitySelect">
      <option value="maid">Maid (default)</option>
      <option value="butler">Butler</option>
      <option value="scientist">Scientist</option>
      <option value="gamer">Gamer</option>
    </select><br><br>
    <button id="savePersonality">Confirm</button>
    <button id="closeMenu">Close</button>
  </div>

  <button id="openMenuBtn">Switch Personality</button>

  <script src="profile.js"></script>
</body>
</html>