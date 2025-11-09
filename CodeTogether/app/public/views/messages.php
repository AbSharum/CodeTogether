<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="/public/css/core/main.css">
    <link rel="stylesheet" href="/public/css/page/messages.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <canvas id="matrix-canvas"></canvas>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <main class="page-messages">
        <div class="container py-5">
            <div class="row justify-content-center">

                <!-- Friends List -->
                <div class="col-lg-3 mb-4">
                    <div class="friends-card">
                        <h4 class="text-info mb-3 ">Transmit Messages</h4>

                        <?php foreach ($data['friendsUser'] as $friendUser): ?>
                            <?php
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

                            <div class="friend-item d-flex align-items-center mb-2"
                                data-friend-id="<?= $friendUser->getUserID(); ?>">

                                <a href="index.php?action=profile&user_id=<?= $friendUser->getUserID(); ?>"
                                    class="d-flex align-items-center text-decoration-none flex-grow-1">

                                    <?php
                                    $profilePic = $friendUser->getProfilePicture() ?? '';
                                    $absolutePath = __DIR__ . '/../uploads/' . $profilePic;
                                    $webPath = '/public/uploads/' . $profilePic;
                                    $fileExists = !empty($profilePic) && file_exists($absolutePath);

                                    // Fallback color + placeholder text (initial)
                                    $initial = substr($friendUser->getUserName(), 0, 1);
                                    $placeholderUrl = "https://placehold.co/40x40/{$imageColor}/ffffff?text={$initial}";
                                    ?>

                                    <?php if ($fileExists): ?>
                                        <img src="<?= htmlspecialchars($webPath) ?>" alt=""
                                            class="friend-avatar me-2 rounded-circle"
                                            style="width:40px; height:40px; object-fit:cover;">
                                    <?php else: ?>
                                        <img src="<?= $placeholderUrl ?>" alt="Friend Avatar"
                                            class="friend-avatar me-2 rounded-circle"
                                            style="width:40px; height:40px; object-fit:cover;">
                                    <?php endif; ?>

                                    <div>
                                        <div class="fw-bold ">
                                            <?= htmlspecialchars($friendUser->getUserName()); ?>
                                        </div>
                                        <small class="<?= $statusClass; ?>"><?= $statusText; ?></small>
                                    </div>
                                </a>
                                <button class="btn btn-sm chat-open-btn" data-friend-id="<?= $friendUser->getUserID(); ?>">
                                    <i class="fas fa-comment text-info"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <!-- Chat Window (centered) -->
                <div class="col-lg-6 mb-4 d-flex justify-content-center">
                    <div id="messageArea" class="message-card p-4 rounded">
                        <h5 id="chatHeader" class="text-info mb-3">Select a friend to start chatting</h5>
                        <div id="chatMessages" class="chat-body mb-3"></div>
                        <form id="messageForm" class="d-flex justify-content-center align-items-center gap-2"
                            style="display:none;">
                            <input type="text" id="messageInput" class="form-control" placeholder="Type a message..."
                                required>
                            <button type="submit" class="btn btn-success rounded-circle">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/page/messages.js"></script>
    <script src="/public/js/core/status.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
</body>

</html>