<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="/public/css/profile.css">

  <!--bootsrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font - Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <!--navigation icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5nI6Jj4QkI7U1vKjK+L0n4A0w4Z+T5E5R5B5B5Y5S5T5W5V5U5T5Q5V5W5X5Y5Z5"
      crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/public/css/home.css">

</head>
<body>
  <canvas id="matrix-canvas"></canvas>

  <?php include __DIR__ .'/../includes/navbar.php'; ?>

  <header>
    <div>
      <img src="https://via.placeholder.com/80" alt="User avatar" class="avatar">
      <button onclick="window.location='/public/views/home.php'">Go to Home</button>
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

  <?php include __DIR__ . '/../ai/aiWidget.php'; ?>
  <script src="/public/ai/ai.js"></script>

  <script src="/public/js/profile.js"></script>
</body>
</html>