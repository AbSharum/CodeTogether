
<?php
  declare(strict_types=1)

  $filename = 'user.json';

  // Initialize fake "database" if missing
  if (!file_exists($filename)) {
      $init = [
          "username" => "sarcasticUser42",
          "fullname" => "Alex Human",
          "bio" => "Trying to look interesting on the internet since 2009.",
          "location" => "Somewhere, Earth",
          "joined" => "2021-03-14",
          "followers" => 128,
          "following" => 87,
          "profilePic" => "default.png",
          "posts" => []
      ];
      file_put_contents($filename, json_encode($init));
  }

  $data = json_decode(file_get_contents($filename), true);

  // Handle updates
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['bio'])) {
          $data['bio'] = $_POST['bio'];
      }
      if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
          $target = "uploads/" . basename($_FILES['profilePic']['name']);
          move_uploaded_file($_FILES['profilePic']['tmp_name'], $target);
          $data['profilePic'] = $target;
      }
      if (isset($_POST['newPost'])) {
          $data['posts'][] = [
              "content" => $_POST['newPost'],
              "time" => date("Y-m-d H:i:s")
          ];
      }
      file_put_contents($filename, json_encode($data));
      header("Location: profile.php");
      exit;
  }
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

  <img src="maid.webp" id="maid" alt="AI assistant">
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