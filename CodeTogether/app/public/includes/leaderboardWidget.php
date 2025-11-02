<?php
declare(strict_types=1);
include_once __DIR__ . '/../../dao/UserDAO.php';

$userDao = new UserDAO();
$topUsers = $userDao->getTopUsersByPoints(3);
?>
<link rel="stylesheet" href="/public/css/core/main.css">
<link rel="stylesheet" href="/public/css/container/leaderboard.css">
<div id="leaderboardContainer">
  <h3 class="leaderboard-title">🏆 Top Users</h3>
  <ul class="leaderboard-list">
    <?php foreach ($topUsers as $index => $topUser): ?>
        <?php
        $profilePic = $topUser->getProfilePicture() ?? '';
        $absolutePath = __DIR__ . '/../../uploads/' . $profilePic;
        $webPath = '/public/uploads/' . $profilePic;
        $fileExists = !empty($profilePic) && file_exists($absolutePath);

        $colors = ['FFD700', 'FFC300', 'FFB700'];
        $imageColor = $colors[$index % count($colors)];
        $initial = substr($topUser->getUsername(), 0, 1);
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
                <a href="index.php?action=profile&user_id=<?= $topUser->getUserID(); ?>"
                class="leaderboard-name text-decoration-none">
                <?= htmlspecialchars($topUser->getUsername()); ?>
                </a>
                <span class="leaderboard-points"><?= $topUser->getPoints(); ?> pts</span>
            </div>
        </li>

    <?php endforeach; ?>
  </ul>
</div>
