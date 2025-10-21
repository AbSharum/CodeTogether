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