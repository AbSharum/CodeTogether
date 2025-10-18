<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../models/Comment.php';
    require_once __DIR__ . '/../config/dbConn.php';

    class CommentDAO {

        public function addComment(int $userID=-1, int $postID=-1, string $contents=''): void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("INSERT INTO comment (user_id, post_id, contents) VALUES (?, ?, ?)");
            $stmt->bind_param("iis",$userID,$postID,$contents);
            $stmt->execute();
            $stmt->close();
            
        }

        public function getAllUserComments(int $userID=-1): array {}
        public function getAllPostComments(int $postID=-1): array {}

        public function getAllComments(): array {
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

        public function getPostsByUser($userId): array {
            $conn = Database::getConnection();
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
            
            return $posts;
        }


        public function deletePost($postID): void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE post SET is_deleted = TRUE WHERE post_id = ?");
            $stmt->bind_param("i", $postID);
            $stmt->execute();
            $stmt->close();
            
        }
    }
?>
