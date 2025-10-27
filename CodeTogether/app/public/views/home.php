<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Home Page</title>
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
    <!--NavBar-->
    <?php include __DIR__ .'/../includes/navbar.php'; ?>
    <!--end of navigation-->

    <div class="container py-5">
        <div class="row justify-content-center">
            <!--left column; on lg screen it is 3/12 width-->
            <div class="col-lg-3 mb-4 order-lg-1 order-1">
                <!--profile summary card-->
                <div class="profile-card text-center mb-4">
                    <!-- if we get some avatar cards stored into the db we can use this just update the img src -->
                    <img src="https://placehold.co/120x120/4a5568/ffffff?text=<?= substr($data['user']->getUserName(), 0, 1) ?>" alt="Profile Avatar" class="profile-avatar mx-auto d-block">
                    <!--will need to change this info its just a placeholder as well-->
                    <h2 class="mb-0 text-white"><?= htmlspecialchars($data['user']->getUserName()) ?></h2>
                    <!--will need to change this info its just a placeholder as well-->
                    <p class="mb-2 text-white"><?= htmlspecialchars($data['user']->getEmail()) ?></p>
                    <!--will need to change this info its just a placeholder as well-->
                    <span class="d-block mt-1 text-sm text-info mb-3">📍 Fort Smith, AR</span>

                    <!-- Statistics Section if its a cool thing to have or not idk but would need to get the php to pull the db info  -->
                    <div class="row mt-3">
                        <div class="col-4 stat-item">
                            <h3 class="fw-bold mb-0 text-white"><?= htmlspecialchars($data['user']->getPoints()) ?></h3>
                            <small class="text-white">Game Points</small>
                        </div>
                        <div class="col-4 stat-item">
                            <h3 class="fw-bold mb-0 text-white"><?= htmlspecialchars(count($data['friends'])) ?></h3>
                            <small class="text-white">Friends</small>
                        </div>
                        <div class="col-4 stat-item">
                            <h3 class="fw-bold mb-0 text-white"><?= htmlspecialchars(count($data['friendPosts'])) ?>
                            </h3>
                            <small class="text-white">Posts</small>
                        </div>
                    </div>
                    <a href="index.php?action=addPost" class="btn btn-success w-100 mt-3 rounded-pill">
                    <i class="fas fa-plus me-2"></i> Add New Post
                    </a>
                </div>
                <!--end of profile card-->

                <!-- the about me info card-->
                <div id="aboutMeCard" class="profile-card mb-4">
                    <h4 class="text-info text-white d-flex justify-content-between align-items-center">
                        About Me
                    </h4>
                    <!-- php integration will need to edit this stuff just a placeholder for now-->
                    <div id="aboutMeContent" class="mb-3 text-white text-break">
                        Just a CS major tryin to make it happen while being fully caffinated and two screamin babies!
                    </div>
                    <textarea id="aboutMeEditor" class="form-control" row="4"
                        style="display: none; background-color: #4a4468; color: #fff; border: 1px solid #06a342; resize: none;">Just a CS major tryin to make it happen while being fully caffinated and two screamin babies!</textarea>
                    <button id="editSaveBtn" class="btn btn-sm btn-outline-info rounded-pill w-100 mt-2">Edit</button>
                </div>
                <!--end of the about me box-->
            </div>
            <!--end of left column-->

            <!-- middle column: posts will be 6/12 on large screens-->
            <div class="col-lg-6 mb-4 order-lg-2 order-3">
                <h3 class="mb-4 text-white">Latest Posts</h3>
                <!--php integration for posts somewhat complete. I added some fake posts and got them to display, but it could use some work this need comments to show up properly, and the ability to display image/video-->
                <?php foreach ($data['friendPosts'] as $post): ?>
                    <div class="post-card">
                        <p class="fw-bold text-white mb-1">
                            <?= htmlspecialchars($post->getUsername()) ?>
                            <span class="text-white fw-normal small">
                                <?= htmlspecialchars($post->getCreatedOn()->format('Y-m-d H:i')) ?>
                            </span>
                        </p>
                        <p class="mb-2 text-white"><?= htmlspecialchars($post->getCaption()) ?></p>

                        <?php if (!empty($post->getContents())): ?>
                            <?php
                               $filePath = '/public/uploads/' . $post->getContents();
                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                            ?>
                            <?php if (in_array(strtolower($extension), ['jpg','jpeg','png','gif'])): ?>
                                <img src="<?= htmlspecialchars($filePath) ?>" class="img-fluid rounded mb-2" alt="Post file">
                            <?php elseif (in_array(strtolower($extension), ['mp4','webm','ogg'])): ?>
                                <video controls class="w-100 rounded mb-2">
                                    <source src="<?= htmlspecialchars($filePath) ?>" type="video/<?= strtolower($extension) ?>">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="d-flex gap-3">
                            <span class="text-white">
                                <i class="fas fa-heart text-danger me-1"></i>
                                <?= htmlspecialchars($post->getLikes()) ?>
                            </span>
                            <span class="text-white">
                                <i class="fas fa-comment me-1"></i> 12
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- End Posts Feed (middle column) -->

            <!--right side of page for friends list  will be 3/12 width on large screens-->
            <div class="col-lg-3 mb-4 order-lg-3 order-2">
                <div class="friends-card">
                    <h4 class="text-info mb-3 text-white">Online Friends (<?php echo count($data['friends']); ?>)</h4>

                    <?php foreach ($data['friendsUser'] as $friendUser):
                        $statusClass = 'text-danger';
                        $imageColor = 'd9534f';
                        $statusText = 'Offline';
                        if ($friendUser->getStatus() === 'online') {
                            $statusClass = 'text-success';
                            $statusText = 'Online';
                            $imageColor = '5cb85c';
                        } elseif ($friendUser->getStatus() === 'away') {
                            $statusClass = 'text-warning';
                            $imageColor = 'f0ad4e';
                            $statusText = 'Away';
                        }
                        ?>
                        <!-- href="index.php?action=accountSettings" --> 
                         <!-- href="public/profile_page/profile.php?user_id=<?= $friendUser->getUserID(); ?>" -->
                        <div class="friend-item d-flex align-items-center mb-2" data-friend-id="<?= $friendUser->getUserID(); ?>">
                            <a href="index.php?action=profile&user_id=<?= $friendUser->getUserID(); ?>" class="d-flex align-items-center text-decoration-none flex-grow-1">
                                <img src="https://placehold.co/40x40/<?= $imageColor ?>/ffffff?text=<?= substr($friendUser->getUserName(), 0, 1) ?>"
                                    alt="Friend Avatar"
                                    class="friend-avatar me-2 rounded-circle">
                                <div>
                                    <div class="fw-bold text-white">
                                        <?= htmlspecialchars($friendUser->getUserName()); ?>
                                    </div>
                                    <small class="<?= $statusClass; ?>"><?= $statusText; ?></small>
                                </div>
                            </a>
                            <button class="btn btn-sm chat-open-btn ms-2"
                                    data-friend-id="<?= $friendUser->getUserID(); ?>">
                                <i class="fas fa-comment text-info"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>

                    <button class="btn btn-sm btn-secondary w-100 mt-3 rounded-pill">View All Friends</button>
                </div>
            </div>

            <!-- end of main container-->

            <!-- FLOATING CHAT BOX UI -->
            <div id="chatBox" class="chat-box shadow-lg">
                <!-- Chat Header (Drag Handle) -->
                <div id="chatHeader" class="chat-header p-2 d-flex justify-content-between align-items-center">
                    <h6 id="chatFriendName" class="mb-0 text-white">Transmitting:</h6>
                    <button id="chatCloseBtn" class="btn-close btn-close-white" aria-label="Close"></button>
                </div>

                <!-- Chat Body (Messages) -->
                <div id="chatBody" class="chat-body p-3">
                    <!-- Messages will be appended here -->
                    <div class="message received">Hi! Ready to code?</div>
                    <div class="message sent">Totally, what project are you working on?</div>
                    <div class="message received">Just trying to implement this chat box!</div>
                </div>

                <!-- Chat Footer (Input) -->
                <div class="chat-footer d-flex p-2">
                    <input type="text" class="form-control me-2" placeholder="Type a message..." id="chatInput">
                    <button class="btn btn-success" id="chatSendBtn"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
            <!-- END FLOATING CHAT BOX UI -->

            <!-- AI -->
            <?php include __DIR__ . '/../includes/aiWidget.php'; ?>
            <script src="/public/js/ai.js"></script>
            <!-- END OF AI -->

            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                xintegrity="sha384-I7E8VVD/ismYTF4yFOWMaa4G8Hh8MfWfQ9SFJdFjO3/B5Gowu/Q7X9+l+O/Y5z4z0J"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
                xintegrity="sha384-0pUGZvbkm6XF6gxjEnlwpMCEoV3f73SjJ+J8C6W6D2Kx5lM7B8K2FfR7R7E7Q"
                crossorigin="anonymous"></script>
            <script src="/public/js/home.js"></script>
            
</body>

</html>