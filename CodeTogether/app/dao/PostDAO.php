<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../models/Post.php';
    require_once __DIR__ . '/../config/DbConn.php';
    class PostDAO {

        public function addPost(int $userID, int $threadID, string $username, ?string $filePath, string $caption, string $visibility): void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("
                INSERT INTO post (user_id, username, thread_id, contents, caption, visibility) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("isssss", $userID, $username, $threadID, $filePath, $caption, $visibility);
            $stmt->execute();
            $stmt->close();
        }

        public function getAllPosts(): array {
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

        public function getPostsByUser(int $userId): array {
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

        public function getPostsByFriends(array $friends): array {
            if(empty($friends)) return [];

            $ids = [];
            foreach ($friends as $friend) $ids[] = $friend->getFriendID(); 
            $inClause = "('" . implode("','", $ids) . "')";

            $conn = Database::getConnection();
            $stmt = $conn->prepare("SELECT * FROM post WHERE user_id in $inClause AND is_deleted = FALSE ORDER BY created_on DESC");
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


        public function deletePost(int $postID): void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE post SET is_deleted = TRUE WHERE post_id = ?");
            $stmt->bind_param("i", $postID);
            $stmt->execute();
            $stmt->close();
            
        }

         public function searchPostsByTerm(string $searchTerm): array {
            $conn = Database::getConnection();

            
            $stmt = $conn->prepare("SELECT * FROM post WHERE caption LIKE CONCAT('%', ?, '%');");
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
    }
?>
