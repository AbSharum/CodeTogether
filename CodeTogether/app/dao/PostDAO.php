<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../config/DbConn.php';
class PostDAO
{

    public function addPost(int $userID, int $threadID, string $username, ?string $filePath, string $caption, string $visibility, string $contents): void
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
                INSERT INTO post (user_id, username, thread_id, file_path, caption, visibility, contents) 
                VALUES (?, ?, ?, ?, ?, ?,?)
            ");
        $stmt->bind_param("issssss", $userID, $username, $threadID, $filePath, $caption, $visibility, $contents);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllPosts(): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM post WHERE is_deleted = FALSE ORDER BY created_on DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $p = new Post();
            $p->load($row);
            $posts[] = $p;
        }

        $stmt->close();

        return $posts;
    }

    public function getPostsByUser(int $userId): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM post WHERE user_id = ? AND is_deleted = FALSE ORDER BY created_on DESC LIMIT 100");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $p = new Post();
            $p->load($row);
            $posts[] = $p;
        }

        $stmt->close();

        return $posts;
    }

    public function getPostsByFriends(array $friends): array
    {
        if (empty($friends))
            return [];

        $ids = [];
        foreach ($friends as $friend)
            $ids[] = $friend->getFriendID();
        $inClause = "('" . implode("','", $ids) . "')";

        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM post WHERE user_id in $inClause AND is_deleted = FALSE AND visibility in ('public','friends') ORDER BY created_on DESC LIMIT 100");
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $p = new Post();
            $p->load($row);
            $posts[] = $p;
        }

        $stmt->close();

        return $posts;
    }

    public function getLikesByPostId(int $postId): int
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT likes FROM post WHERE post_id = ?");
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result > 0 ? (int) $result['likes'] : 0;
    }

    public function updateLikes(int $postId, int $newLikes): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE post SET likes = ? WHERE post_id = ?");
        $stmt->bind_param("ii", $newLikes, $postId);
        return $stmt->execute();
    }



    public function getPostsByFriendsAndUser(array $friends, int $userID): array
    {
        if (empty($friends))
            return [];

        $ids = [];
        foreach ($friends as $friend)
            $ids[] = $friend->getFriendID();
        $inClause = "('" . implode("','", $ids) . "')";

        $conn = Database::getConnection();
        $stmt = $conn->prepare("
        SELECT * FROM post WHERE user_id in $inClause AND is_deleted = FALSE AND visibility in ('public','friends')
        UNION ALL
        SELECT * FROM post WHERE user_id = ? AND is_deleted = FALSE
        ORDER BY created_on DESC LIMIT 100");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $p = new Post();
            $p->load($row);
            $posts[] = $p;
        }

        $stmt->close();

        return $posts;
    }


    public function deletePost(int $postID): void
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE post SET is_deleted = TRUE WHERE post_id = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->close();

    }

    public function searchPostsByTerm(string $searchTerm): array
    {
        $conn = Database::getConnection();


        $stmt = $conn->prepare("SELECT * FROM post WHERE caption LIKE CONCAT('%', ?, '%') and visibility = 'public';");
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();

        $result = $stmt->get_result();
        $posts = [];

        while ($row = $result->fetch_assoc()) {
            $post = new Post();
            $post->load($row);
            $posts[] = $post;
        }

        $stmt->close();

        return $posts; // Return an array of post objects
    }

    public function hasUserLikedPost(int $postId, int $userId): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $hasLiked = $result->num_rows > 0;
        $stmt->close();
        return $hasLiked;
    }

    public function addLike(int $postId, int $userId): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $postId, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function removeLike(int $postId, int $userId): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $postId, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function countLikes(int $postId): int
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM post_likes WHERE post_id = ?");
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return (int) ($result['total'] ?? 0);
    }

    public function getLikedPostIdsByUser(int $userId): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT post_id FROM post_likes WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $likedPosts = [];

        while ($row = $result->fetch_assoc()) {
            $likedPosts[] = (int) $row['post_id'];
        }

        $stmt->close();
        return $likedPosts;
    }


}
?>