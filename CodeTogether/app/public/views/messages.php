<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!--navigation icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJc5nI6Jj4QkI7U1vKjK+L0n4A0w4Z+T5E5R5B5B5Y5S5T5W5V5U5T5Q5V5W5X5Y5Z5"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/public/css/messages.css"> <!--change for file path-->
</head>

<body class="bg-dark text-light">
    <canvas id="matrix-canvas"></canvas>
    <!--NavBar-->
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <!--end of navigation-->

    <div class="container py-5">
        <div class="row justify-content-left">
            <div class="col-lg-3 mb-4 order-lg-3 order-2">
                <div class="friends-card">
                    <h4 class="text-info mb-3 text-white">Transmit Messages </h4>

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
                                    <div class="fw-bold text-white">
                                        <?= htmlspecialchars($friendUser->getUserName()); ?>
                                    </div>
                                    <small class="<?= $statusClass; ?>"><?= $statusText; ?></small>
                                </div>
                            </a>

                            <button class="btn btn-sm chat-open-btn ms-2" data-friend-id="<?= $friendUser->getUserID(); ?>">
                                <i class="fas fa-comment text-info"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>

                    <button class="btn btn-sm btn-secondary w-100 mt-3 rounded-pill">View All Friends</button>
                </div>

                <div class="col-lg-3 mb-4 order-lg-2 order-3">

                </div>
            </div>
        </div>
    </div>


    <script src="/public/js/messages.js"></script> <!--update for filepath for js-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        xintegrity="sha384-I7E8VVD/ismYTF4yFOWMaa4G8Hh8MfWfQ9SFJdFjO3/B5Gowu/Q7X9+l+O/Y5z4z0J"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        xintegrity="sha384-0pUGZvbkm6XF6gxjEnlwpMCEoV3f73SjJ+J8C6W6D2Kx5lM7B8K2FfR7R7E7Q"
        crossorigin="anonymous"></script>

</body>

</html>