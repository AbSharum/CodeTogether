<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../config/DbConn.php';

class CommentDAO
{

    public function addComment(int $userID = -1, int $postID = -1, string $contents = ''): void
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO comment (user_id, post_id, contents) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $userID, $postID, $contents);
        $stmt->execute();
        $stmt->close();

    }

    public function getAllUserComments(int $userID): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            SELECT c.*, u.username 
            FROM comment c
            JOIN user u ON c.user_id = u.user_id
            WHERE c.user_id = ? AND c.is_deleted = FALSE
            ORDER BY c.created_on DESC
        ");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comment = new Comment();
            $comment->load($row);
            $comments[] = $comment;
        }

        $stmt->close();
        return $comments;
    }
    public function getAllPostComments(int $postID): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            SELECT c.*, u.username
            FROM comment c
            JOIN user u ON c.user_id = u.user_id
            WHERE c.post_id = ? AND c.is_deleted = FALSE
            ORDER BY c.created_on ASC
        ");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comment = new Comment();
            $comment->load($row);
            $comments[] = $comment;
        }

        $stmt->close();
        return $comments;
    }

    public function getAllComments(): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM comment WHERE is_deleted = FALSE ORDER BY created_on DESC");
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

    public function deleteComment($commentID): void
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE comment SET is_deleted = TRUE WHERE comment_id = ?");
        $stmt->bind_param("i", $commentID);
        $stmt->execute();
        $stmt->close();

    }
}
?>