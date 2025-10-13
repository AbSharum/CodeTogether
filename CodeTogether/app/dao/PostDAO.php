<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../config/dbConn.php';

class PostDAO {

    public function addPost(Post $post) {
        $conn = Database::getConnection(); //$conn = getConnection();
        if (!$conn) return;

        $stmt = $conn->prepare("INSERT INTO post (user_id, thread_id, contents, caption, visibility) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", 
            $post->getUserID(), 
            $post->getThreadID(), 
            $post->getContents(), 
            $post->getCaption(), 
            $post->getVisibility()
        );
        $stmt->execute();
        $stmt->close();
        Database::close(); //$conn->close();
    }

    public function getAllPosts() {
        $conn = Database::getConnection(); //$conn = getConnection();
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
        Database::close(); //$conn->close();
        return $posts;
    }

    public function getPostsByUser($userId) {
        $conn = Database::getConnection(); //$conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM post WHERE user_id = ? AND is_deleted = FALSE ORDER BY created_on DESC");
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
        Database::close(); //$conn->close();
        return $posts;
    }


    public function deletePost($postID) {
        $conn = Database::getConnection(); //$conn = getConnection();
        $stmt = $conn->prepare("UPDATE post SET is_deleted = TRUE WHERE post_id = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->close();
        Database::close(); //$conn->close();
    }
}
?>
