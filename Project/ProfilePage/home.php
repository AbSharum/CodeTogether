<?php



// Example: test data, replace with database query later
$posts = [
    [
        'username' => 'Alice',
        'message' => 'Just joined this site!',
        'time' => '2025-10-08 10:30',
        'pfp' => 'https://via.placeholder.com/50'
    ],
    [
        'username' => 'Bob',
        'message' => 'What a nice day!',
        'time' => '2025-10-08 09:15',
        'pfp' => 'https://via.placeholder.com/50'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Test</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f7;
        }
        .container {
            display: grid;
            grid-template-columns: 20% 1fr 25%;
            gap: 15px;
            padding: 10px;
        }
        header {
            background: white;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #searchBar {
            width: 300px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .left, .right {
            background: white;
            border-radius: 8px;
            padding: 15px;
            height: calc(100vh - 90px);
            overflow-y: auto;
        }
        .center {
            display: flex;
            flex-direction: column;
            gap: 15px;
            overflow-y: auto;
            height: calc(100vh - 90px);
        }
        .post {
            background: white;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .post img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
        .post-content {
            flex: 1;
        }
        .post-username {
            font-weight: bold;
        }
        .post-time {
            color: gray;
            font-size: 0.85em;
        }
        .make-post {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .make-post textarea {
            resize: none;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .make-post button {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h2>Social Media Test</h2>
        <input type="text" id="searchBar" placeholder="Search posts...">
    </header>

    <div class="container">
        <div class="left">
            <h3>Categories</h3>
            <ul>
                <li>General</li>
                <li>Technology</li>
                <li>Art</li>
                <li>Gaming</li>
                <li>News</li>
            </ul>
        </div>

        <div class="center" id="postsContainer">
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <img src="<?= htmlspecialchars($post['pfp']) ?>" alt="pfp">
                    <div class="post-content">
                        <div class="post-username"><?= htmlspecialchars($post['username']) ?></div>
                        <div class="post-time"><?= htmlspecialchars($post['time']) ?></div>
                        <div class="post-message"><?= htmlspecialchars($post['message']) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="right">
            <h3>Your Profile</h3>
            <div>
                <img src="https://via.placeholder.com/80" style="border-radius:50%">
                <p><b>TestUser</b></p>
                <button onclick="window.location='profile.html'">Go to Profile</button>
                <button onclick="window.location='3d_virtual_world.php'">Go to Virtual Home</button>
            </div>
            <hr>
            <div class="make-post">
                <h4>Make a Post</h4>
                <textarea id="postText" rows="3" placeholder="What's on your mind?"></textarea>
                <button onclick="makePost()">Post</button>
            </div>
        </div>
    </div>

    <script>
        function makePost() {
            const text = document.getElementById('postText').value.trim();
            if (!text) return;

            const container = document.getElementById('postsContainer');
            const post = document.createElement('div');
            post.className = 'post';
            post.innerHTML = `
                <img src="https://via.placeholder.com/50" alt="pfp">
                <div class="post-content">
                    <div class="post-username">TestUser</div>
                    <div class="post-time">${new Date().toLocaleString()}</div>
                    <div class="post-message">${text}</div>
                </div>
            `;
            container.prepend(post);
            document.getElementById('postText').value = '';
        }
    </script>
</body>
</html>
