
<link rel="stylesheet" href="/public/css/container/postVisual.css">
<div class="post-card">
  <div class="comment-header d-flex justify-content-between align-items-start mb-2">
    <p class="fw-bold mb-0 flex-grow-1">
      <?= htmlspecialchars($comment->getUsername()) ?>:
      <span class="fw-normal small">
        <?= htmlspecialchars($comment->getCreatedOn()->format('l, F j h:i A')) ?>
      </span>
      <br>
    </p>
  </div>

  <?php if (!empty($comment->getContents())): ?>

    <div class="comment-content" id="comment-content-<?= $comment->getCommentID(); ?>">
      <?= nl2br(htmlspecialchars($comment->getContents())) ?>
    </div>

  <?php endif; ?>

</div>