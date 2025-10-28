<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($user->getUserName()) ?>'s Profile</title>
  <link rel="stylesheet" href="/public/css/profile.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <canvas id="matrix-canvas"></canvas>

  <?php include __DIR__ . '/../includes/navbar.php'; ?>

  <main class="main container py-5">
    <div class="row justify-content-center">
      <!-- Left column -->
      <aside class="col-lg-3 mb-4">
        <div class="profile-card text-center p-3">
          <?php
          $loggedInID = $_SESSION['usercreds']['userID'] ?? 0;
          $isOwnProfile = ($loggedInID === $user->getUserID());
          $status;

          //check if logged in user is already friends with this profile user
          $isFriend = false;
          foreach ($friends as $friend) {
            if (
              method_exists($friend, 'getFriendID') &&
              $friend->getFriendID() === $user->getUserID()
            ) {
              $isFriend = true;
              break;
            }
          }
          ?>

          <?php
          $profilePic = '/public/uploads/' . $data['user']->getProfilePicture() ?? '';


          // Check extension type
          $extension = !empty($profilePic) ? strtolower(pathinfo($profilePic, PATHINFO_EXTENSION)) : ''; ?>

          <?php if (!empty($profilePic)): ?>
            <?php if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
              <img src="<?= htmlspecialchars($profilePic) ?>" class="profile-avatar mx-auto d-block rounded-circle mb-3"
                alt="" style="width:120px;height:120px;object-fit:cover;">
            <?php elseif (in_array($extension, ['mp4', 'webm', 'ogg'])): ?>
              <video controls class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                <source src="<?= htmlspecialchars($profilePic) ?>" type="video/<?= $extension ?>">
                Your browser does not support the video tag.
              </video>
            <?php endif; ?>
          <?php else: ?>
            <?= "this is not working" ?>
            <!-- Fallback placeholder -->
            <img src="https://placehold.co/120x120/4a5568/ffffff?text=<?= substr($data['user']->getUserName(), 0, 1) ?>"
              alt="Profile Avatar" class="profile-avatar mx-auto d-block rounded-circle mb-3"
              style="width:120px;height:120px;object-fit:cover;">
          <?php endif; ?>
          <?php if ($isOwnProfile): ?>
            <form action="index.php?action=addProfilePicture" method="POST" enctype="multipart/form-data" class="mt-2">
              <input type="file" name="profilePic" accept="image/*" class="form-control form-control-sm mb-2" required>
              <button type="submit" class="btn btn-outline-info btn-sm w-100">
                <i class="fas fa-upload me-1"></i> Update Picture
              </button>
            </form>
          <?php endif; ?>


          <h3 class="text-white"><?= htmlspecialchars($user->getUserName()) ?></h3>
          <p class="text-info mb-2"><?= htmlspecialchars($user->getEmail() ?? 'No email') ?></p>

          <div class="row mt-3 text-white">
            <div class="col-6">
              <strong>Points</strong><br><?= htmlspecialchars($user->getPoints()) ?>
            </div>
            <div class="col-6">
              <strong>Status</strong><br><?= htmlspecialchars($user->getStatus()) ?>
            </div>
          </div>

          <p class="text-secondary small mt-3">
            Joined: <?= htmlspecialchars($user->getCreatedOn()->format('Y-m-d')) ?>
          </p>

          <?php if (!$isOwnProfile): ?>
            <!-- Show only when viewing another user's profile -->
            <?php if ($isFriend): ?>
              <form action="index.php?action=search" method="POST" class="mb-2">
                <input type="hidden" name="friend_id" value="<?= $user->getUserID(); ?>">
                <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI']; ?>">
                <input type="hidden" name="task" value="remove">
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                  <i class="fas fa-user-minus me-1"></i> Remove Friend
                </button>
              </form>
            <?php else: ?>
              <form action="index.php?action=search" method="POST" class="mb-2">
                <input type="hidden" name="friend_id" value="<?= $user->getUserID(); ?>">
                <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI']; ?>">
                <input type="hidden" name="task" value="request">
                <button type="submit" class="btn btn-outline-success btn-sm w-100">
                  <i class="fas fa-user-plus me-1"></i> Add Friend
                </button>
              </form>
            <?php endif; ?>

            <!-- About Me card (read-only) -->
            <div id="aboutMeCard" class="profile-card mb-4 mt-3 p-3">
                <h4 class="text-info text-white mb-3">About <?= htmlspecialchars($user->getUserName()) ?></h4>
                <div class="text-white text-break" style="background-color: #4a4468; border: 1px solid #06a342; padding: 10px; border-radius: 8px;">
                    <?= htmlspecialchars($data['aboutMe'] ?? 'Nothing here yet!') ?></textarea>
                </div>
            </div>
          <?php endif; ?>

          <button class="btn btn-outline-info btn-sm mt-2 w-100" onclick="window.location='index.php?action=home'">
            <i class="fas fa-home me-1"></i> Back to Home
          </button>
        </div>



        <!-- Friends list -->
        <div class="friends-card mt-4 p-3">
          <h5 class="text-info mb-3">Friends (<?= count($friendsUser) ?>)</h5>
          <?php foreach ($friendsUser as $friendUser): ?>
            <?php
            $statusClass = 'text-danger';
            $statusText = 'Offline';
            $color = 'd9534f';
            if ($friendUser->getStatus() === 'online') {
              $statusClass = 'text-success';
              $statusText = 'Online';
              $color = '5cb85c';
            } elseif ($friendUser->getStatus() === 'away') {
              $statusClass = 'text-warning';
              $statusText = 'Away';
              $color = 'f0ad4e';
            }
            ?>
            <div class="friend-item d-flex align-items-center mb-2">
              <a href="index.php?action=profile&user_id=<?= $friendUser->getUserID(); ?>"
                class="d-flex align-items-center text-decoration-none flex-grow-1">
                <img
                  src="https://placehold.co/40x40/<?= $color ?>/ffffff?text=<?= substr($friendUser->getUserName(), 0, 1) ?>"
                  alt="Friend Avatar" class="friend-avatar me-2 rounded-circle">
                <div>
                  <div class="fw-bold text-white"><?= htmlspecialchars($friendUser->getUserName()); ?></div>
                  <small class="<?= $statusClass; ?>"><?= $statusText; ?></small>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </aside>

      <!-- Middle column: posts -->
      <section class="col-lg-6 mb-4">
        <h2 class="text-white mb-3"><?= htmlspecialchars($user->getUserName()) ?>'s Posts</h2>
        <?php if (empty($userPosts)): ?>
          <p class="text-secondary">No posts yet.</p>
        <?php else: ?>
          <?php foreach ($userPosts as $post): ?>
            <div class="post-card mb-3 p-3 border border-success rounded-3">
              <p class="fw-bold text-white mb-1">
                <?= htmlspecialchars($user->getUserName()) ?>
                <span class="small text-white" style="text-decoration: underline;">
                  <?= htmlspecialchars($post->getCaption()) ?>
                </span>
                <span class="text-secondary small">
                  <?= htmlspecialchars($post->getCreatedOn()->format('Y-m-d H:i')) ?>
                </span>
              </p>
              <p class="text-white"><?= htmlspecialchars($post->getContents()) ?></p>
              <?php if (!empty($post->getContents())): ?>
                <?php
                $filePath = '/public/uploads/' . $post->getContents();
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                ?>
                <?php if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                  <img src="<?= htmlspecialchars($filePath) ?>" class="img-fluid rounded mb-2" alt="Post file">
                <?php elseif (in_array(strtolower($extension), ['mp4', 'webm', 'ogg', 'mov'])): ?>
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
                  <i class="fas fa-comment me-1"></i> Comments TBD
                </span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </section>
    </div>
  </main>

  <?php include __DIR__ . '/../includes/aiWidget.php'; ?>
  <script src="/public/js/ai.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="/public/js/profile.js"></script>
</body>

</html>