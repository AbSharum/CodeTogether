<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/public/css/home.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>

    <!-- Navbar -->
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <!-- Search Results -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">
                <h3 class="text-white mb-4">Search Results</h3>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="searchTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                            type="button" role="tab" aria-controls="users" aria-selected="true">
                            Users (<?= count($users ?? []) + count($friendsUsers ?? []) - 1 ?>)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                            type="button" role="tab" aria-controls="posts" aria-selected="false">
                            Posts (<?= count($posts ?? []) ?>)
                        </button>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- USERS TAB -->
                    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <?php if (empty($users)): ?>
                            <p class="text-white">No users found.</p>
                        <?php else: ?>

                            <!-- SEARCHED USERS -->
                            <?php foreach ($users as $user): ?>
                                <?php
                                // skip self
                                if ($user->getUserID() == $userID)
                                    continue;
                                $status = $user->getStatus();
                                ?>
                                <div class="profile-card mb-3 p-3 d-flex align-items-start">
                                    <img src="https://placehold.co/50x50/4a5568/ffffff?text=<?= substr($user->getUserName(), 0, 1) ?>"
                                        alt="User Avatar" class="rounded-circle me-3">

                                    <div>
                                        <h5 class="mb-1 text-white"><?= htmlspecialchars($user->getUserName()) ?></h5>
                                        <small
                                            class="d-block text-white mb-2"><?= htmlspecialchars($user->getEmail()) ?></small>

                                        <?php if ($status === 'pending'): ?>
                                            <?php if ($user->getRequestInitiatorID() === $userID): ?>
                                                <!-- You sent it -->
                                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                                            <?php else: ?>
                                                <!-- You received it -->
                                                <form method="POST" action="index.php?action=search" class="d-inline">
                                                    <input type="hidden" name="friendId"
                                                        value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                    <input type="hidden" name="task" value="accept">
                                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                                </form>
                                                <form method="POST" action="index.php?action=search" class="d-inline">
                                                    <input type="hidden" name="friendId"
                                                        value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                    <input type="hidden" name="task" value="reject">
                                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                </form>
                                            <?php endif; ?>

                                        <?php elseif ($status === 'friends'): ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Friends</button>
                                            <form method="POST" action="index.php?action=search" class="d-inline">
                                                <input type="hidden" name="friendId"
                                                    value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                                                <input type="hidden" name="task" value="block">
                                            </form> 
                                            <form method="POST" action="index.php?action=search" class="d-inline">
                                            <input type="hidden" name="friendId"
                                                value="<?= htmlspecialchars($user->getUserId()) ?>">
                                            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                                            <input type="hidden" name="task" value="remove">
                                            <button type="submit" class="btn btn-warning btn-sm">Remove Friend</button>
                                            </form>
                                            <form method="POST" action="index.php?action=search" class="d-inline">
                                                <input type="hidden" name="friendId"
                                                    value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                                                <input type="hidden" name="task" value="block">
                                                <button type="submit" class="btn btn-danger btn-sm">Block</button>
                                            </form>

                                        <?php elseif ($status === 'blocked'): ?>
                                            <?php if ($user->getRequestInitiatorID() === $userID): ?>
                                                <!-- You received it -->
                                                <form method="POST" action="index.php?action=search" class="d-inline">
                                                    <input type="hidden" name="friendId"
                                                        value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                    <input type="hidden" name="task" value="unblock">
                                                    <button type="submit" class="btn btn-success btn-sm">Unblock</button>
                                                </form>
                                            <?php endif; ?>
                                            <button class="btn btn-danger btn-sm" disabled>Blocked</button>


                                        <?php else: ?>
                                            <form method="POST" action="index.php?action=search" class="d-inline">
                                                <input type="hidden" name="friendId"
                                                    value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                                                <input type="hidden" name="task" value="request">
                                                <button type="submit" class="btn btn-success btn-sm">Add Friend</button>
                                            </form>
                                            <form method="POST" action="index.php?action=search" class="d-inline">
                                                <input type="hidden" name="friendId"
                                                    value="<?= htmlspecialchars($user->getUserId()) ?>">
                                                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                                                <input type="hidden" name="task" value="block">
                                                <button type="submit" class="btn btn-danger btn-sm">Block</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>

                    <!-- POSTS TAB -->
                    <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                        <?php if (empty($posts)): ?>
                            <p class="text-white">No posts found.</p>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <div class="post-card mb-4 p-3">
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
                                        <?php elseif (in_array(strtolower($extension), ['mp4','webm','ogg','mov'])): ?>
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="/public/js/home.js"></script>
</body>

</html>