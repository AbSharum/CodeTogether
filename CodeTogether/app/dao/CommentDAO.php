<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../models/Comment.php';
    require_once __DIR__ . '/../config/DbConn.php';
    require_once __DIR__ . '/../config/EventDispatcher.php';

    class CommentDAO {

        public function addComment(int $userID=-1, int $postID=-1, string $contents=''): void {
            $conn = Database::getConnection();
            $stmt = $conn->prepare("INSERT INTO comment (user_id, post_id, contents) VALUES (?, ?, ?)");
            $stmt->bind_param("iis",$userID,$postID,$contents);
            $validStmt = $stmt->execute();
            $stmt->close();

            if ($validStmt) {
                EventDispatcher::brodcast([
                    'event' => 'newComment',
                    'data' => [
                        'userID' = $userID,
                        'postID' = $postID,
                        'contents' = $contents,
                        'time' = time()
                    ]
                ]);
            }
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
    }
?>
