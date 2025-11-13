<?php include __DIR__ . '/../includes/sessionCheck.php'; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="/public/css/core/main.css">
    <link rel="stylesheet" href="/public/css/page/createPost.css">
</head>

<body>
    <canvas id="matrix-canvas"></canvas>

    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <main class="page-create-post">
        <div class="card shadow position-relative">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Create a Post</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=addPost" method="POST" enctype="multipart/form-data" id="addPostForm">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="caption" class="form-label">Contents</label>
                        <input type="text" class="form-control" id="contents" name="contents" required>
                    </div>

                    <div class="mb-3">
                        <label for="postFile" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="postFile" name="postFile" accept="image/*,video/*">
                    </div>

                    <div class="mb-3">
                        <label for="visibility" class="form-label">Visibility</label>
                        <select class="form-select" id="visibility" name="visibility" required>
                            <option value="" disabled selected>Visibility...</option>
                            <option value="public">Public</option>
                            <option value="friends">Friends</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-success">Create Post</button>
                    </div>
                </form>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='index.php?action=home'">
                        Return to Home
                    </button>
                </div>
            </div>
        </div>
    </main>
    <script src="/public/js/core/theme.js"></script>
    <script src="/public/js/core/rain.js"></script>
    <script src="/public/js/core/status.js"></script>
    <script src="/public/js/core/mentions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>