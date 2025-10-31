<?php
//Expects: $post (Post object), $user (User object), and optionally $likedPosts (array)
?>
<link rel="stylesheet" href="/public/css/postVisual.css">
<div class="post-card">
  <p class="fw-bold text-white mb-1">
    <?= htmlspecialchars($post->getUsername()) ?>:
    <span class="text-white fw-normal small">
      <?= htmlspecialchars($post->getCreatedOn()->format('l, F j h:i A')) ?>
    </span>
    <br>
    <span class="small text-white" style="text-decoration: underline;">
      <?= htmlspecialchars($post->getCaption()) ?>
    </span>

    <div class="dropdown post-options ms-auto" style="float:right;">
      <button class="btn btn-sm btn-dark text-white dropdown-toggle" type="button"
        id="dropdownMenuButton<?= $post->getPostID(); ?>" data-bs-toggle="dropdown"
        aria-expanded="false" style="background-color:#141414;border:none;">
        <i class="fas fa-ellipsis-h"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-dark"
          aria-labelledby="dropdownMenuButton<?= $post->getPostID(); ?>">
        <li><a class="dropdown-item text-warning" href="#">Report Post</a></li>
        <li><a class="dropdown-item text-info" href="#">Save Post</a></li>
        <?php if ((int)$post->getUserID() === (int)$user->getUserID()): ?>
          <li>
            <form action="index.php?action=deletePost" method="POST" class="m-0">
              <input type="hidden" name="post_id" value="<?= $post->getPostID(); ?>">
              <button type="submit" class="dropdown-item text-danger">Delete Post</button>
            </form>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </p>

  <?php if (!empty($post->getContents())): ?>
    <?php
      $filePath = '/public/uploads/' . $post->getFilePath();
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

    <div class="post-content" id="post-content-<?= $post->getPostID(); ?>">
      <?= nl2br(htmlspecialchars($post->getContents())) ?>
    </div>

    <form action="index.php?action=editPost" method="POST"
          class="edit-post-form d-none" id="edit-form-<?= $post->getPostID(); ?>">
      <input type="hidden" name="post_id" value="<?= $post->getPostID(); ?>">
      <textarea name="content" class="form-control mb-2"><?= htmlspecialchars($post->getContents()) ?></textarea>
      <button type="submit" class="btn btn-success btn-sm">Save</button>
      <button type="button" class="btn btn-secondary btn-sm cancel-edit"
              data-post-id="<?= $post->getPostID(); ?>">Cancel</button>
    </form>
  <?php endif; ?>

  <div class="d-flex gap-3 align-items-center">
    <?php
      $isLiked = isset($likedPosts) && in_array($post->getPostID(), $likedPosts);
      $heartClass = $isLiked ? 'text-danger' : 'text-secondary';
    ?>
    <form action="index.php?action=likePost" method="POST" class="d-inline">
      <input type="hidden" name="post_id" value="<?= $post->getPostID(); ?>">
      <button type="submit" class="btn btn-sm btn-link text-decoration-none text-white p-0">
        <i class="fas fa-heart <?= $heartClass ?> me-1"></i>
        <?= htmlspecialchars($post->getLikes()) ?>
      </button>
    </form>

    <span class="text-white">
      <i class="fas fa-comment me-1"></i> 12
    </span>

    <?php if ((int)$post->getUserID() === (int)$user->getUserID()): ?>
      <button class="btn btn-sm btn-outline-light edit-post-btn"
              data-post-id="<?= $post->getPostID(); ?>">
        Edit
      </button>
    <?php endif; ?>
  </div>
</div>
