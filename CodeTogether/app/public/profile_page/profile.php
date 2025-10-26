<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="/public/css/profile.css">

</head>
<body>
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
      <button type="button" class="btn btn-add">Add Friend</button>
      <button type="button" class="btn btn-add">Delete Friend</button>
      
    </aside>
  </main>

  <?php include __DIR__ . '/../ai/aiWidget.php'; ?>
  <script src="/public/ai/ai.js"></script>

  <script src="/public/js/profile.js"></script>
</body>
</html>