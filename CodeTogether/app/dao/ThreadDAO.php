<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../config/DbConn.php';
require_once __DIR__ . '/../models/Thread.php';
class ThreadDAO
{

    public function addThread(string $title, int $userID): void
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO thread (title) VALUES (?)");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $threadID = $conn->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO thread_bridge (user_id, thread_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userID, $threadID);
        $stmt->execute();
        $stmt->close();

    }

    public function getThreadByTitle(string $title): Thread|null
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM thread WHERE title = ?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $threadID = $conn->insert_id;
        $result = $stmt->get_result();
        $thread = null;
        if ($row = $result->fetch_assoc()) {
            $thread = new Thread();
            $thread->load($row);
        }
        $stmt->close();

        return $thread;

    }
}
?>