<?php
declare(strict_types=1);
include_once __DIR__ . '/../../dao/UserDAO.php';

$userDao = new UserDAO();
$topUsers = $userDao->getTopUsersByPoints(3);
?>
<link rel="stylesheet" href="/public/css/leaderboard.css">
<div id="leaderboardContainer">
  <h3 class="leaderboard-title">🏆 Top Users</h3>
  <ul class="leaderboard-list">
    <?php foreach ($topUsers as $index => $user): ?>
      <?php
        $profilePic = $user->getProfilePicture() ?? '';
        $absolutePath = __DIR__ . '/../../uploads/' . $profilePic;
        $webPath = '/public/uploads/' . $profilePic;
        $fileExists = !empty($profilePic) && file_exists($absolutePath);

        // Simple random color for placeholder (rotate gold tones)
        $colors = ['FFD700', 'FFC300', 'FFB700'];
        $imageColor = $colors[$index % count($colors)];
        $initial = substr($user->getUsername(), 0, 1);
        $placeholderUrl = "https://placehold.co/40x40/{$imageColor}/000000?text={$initial}";
      ?>
      <li class="leaderboard-entry">
        <div class="rank">#<?= $index + 1 ?></div>

        <?php if ($fileExists): ?>
          <img src="<?= htmlspecialchars($webPath) ?>" alt="User Avatar"
            class="leaderboard-pfp">
        <?php else: ?>
          <img src="<?= $placeholderUrl ?>" alt="User Avatar"
            class="leaderboard-pfp">
        <?php endif; ?>

        <div class="leaderboard-info">
          <a href="index.php?action=profile&user_id=<?= $user->getUserID(); ?>"
             class="leaderboard-name text-decoration-none text-white">
            <?= htmlspecialchars($user->getUsername()); ?>
          </a>
          <span class="leaderboard-points"><?= $user->getPoints(); ?> pts</span>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
