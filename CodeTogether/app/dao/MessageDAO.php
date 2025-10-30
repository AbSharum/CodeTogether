<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../config/DbConn.php';

class MessageDAO
{
    public function getDirectChatID(int $user1, int $user2): ?int
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            SELECT cb1.chat_id 
            FROM chat_bridge cb1
            JOIN chat_bridge cb2 ON cb1.chat_id = cb2.chat_id
            JOIN chat c ON c.chat_id = cb1.chat_id
            WHERE cb1.user_id = ? AND cb2.user_id = ? AND c.chat_type = 'direct'
            LIMIT 1
        ");
        $stmt->bind_param("ii", $user1, $user2);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result ? (int) $result['chat_id'] : null;
    }

    public function createDirectChat(int $user1, int $user2): int
    {
        $conn = Database::getConnection();
        $conn->begin_transaction();

        try {
            // Create chat room
            $stmt = $conn->prepare("INSERT INTO chat (chat_type) VALUES ('direct')");
            $stmt->execute();
            $chatID = $conn->insert_id;
            $stmt->close();

            // Add both users to chat_bridge
            $stmt = $conn->prepare("INSERT INTO chat_bridge (chat_id, user_id) VALUES (?, ?), (?, ?)");
            $stmt->bind_param("iiii", $chatID, $user1, $chatID, $user2);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            return $chatID;
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
    }

    public function getMessagesSince(int $chatID, string $since): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
        SELECT m.*, u.username
        FROM message m
        JOIN user u ON u.user_id = m.user_id
        WHERE m.chat_id = ? AND m.is_deleted = FALSE AND m.sent_at > ?
        ORDER BY m.sent_at ASC LIMIT 100
    ");
        $stmt->bind_param("is", $chatID, $since);
        $stmt->execute();
        $result = $stmt->get_result();

        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $msg = new Message();
            $msg->load($row);
            $messages[] = $msg;
        }
        $stmt->close();

        return $messages;
    }


    public function getMessagesByChatID(int $chatID): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            SELECT m.*, u.username
            FROM message m
            JOIN user u ON u.user_id = m.user_id
            WHERE m.chat_id = ? AND m.is_deleted = FALSE
            ORDER BY m.sent_at ASC LIMIT 100
        ");
        $stmt->bind_param("i", $chatID);
        $stmt->execute();
        $result = $stmt->get_result();

        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $msg = new Message();
            $msg->load($row);
            $messages[] = $msg;
        }

        $stmt->close();
        return $messages;
    }

    public function insertMessage(int $chatID, int $senderID, string $content): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("
            INSERT INTO message (chat_id, user_id, content)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("iis", $chatID, $senderID, $content);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
