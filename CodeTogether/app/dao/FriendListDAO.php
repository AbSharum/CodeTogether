<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/DbConn.php';
require_once __DIR__ . '/../models/Friend.php';
class FriendListDAO
{

    public function sendFriendRequest(int $userID, int $friendID): bool
    {
        $user1 = min($userID, $friendID);
        $user2 = max($userID, $friendID);

        if ($user1 === $user2) {
            return false;
        }

        $conn = Database::getConnection();
        $stmt = null;

        if ($this->friendshipExists($user1, $user2)) {
            return false;
        } elseif ($this->relationShipExists($user1, $user2)) {
            $stmt = $conn->prepare("UPDATE 
                friend_list SET status = 'pending' WHERE user_id_1 = ? AND user_id_2 = ?
            ");
            $stmt->bind_param("ii", $user1, $user2);
        } else {
            $stmt = $conn->prepare("INSERT 
                INTO friend_list (user_id_1, user_id_2, status,initiated_by)
                VALUES (?, ?, 'pending',?)
            ");
            $stmt->bind_param("iii", $user1, $user2, $userID);
        }

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Accept a pending friend request
    public function acceptFriendRequest(int $userID, int $friendID): bool
    {
        $user1 = min($userID, $friendID);
        $user2 = max($userID, $friendID);

        if ($user1 === $user2) {
            return false;
        }

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE friend_list SET status = 'friends' WHERE user_id_1 = ? AND user_id_2 = ? AND status = 'pending'");
        $stmt->bind_param("ii", $user1, $user2);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();


        return $success;
    }

    public function removeFriend(int $userID, int $friendID): bool
    {
        $user1 = min($userID, $friendID);
        $user2 = max($userID, $friendID);

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE friend_list SET status = 'not-friends', initiated_by = -1 WHERE user_id_1 = ? AND user_id_2 = ?");
        $stmt->bind_param("ii", $user1, $user2);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();

        return $success;
    }


    public function getAllRelationships(int $userID): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT 
                CASE 
                    WHEN user_id_1 = ? THEN user_id_2 
                    ELSE user_id_1 
                END AS friend_id,
                status,
                created_on,
                initiated_by
            FROM friend_list
            WHERE user_id_1 = ? OR user_id_2 = ?
        ");
        $stmt->bind_param("iii", $userID, $userID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $relations = [];
        while ($row = $result->fetch_assoc()) {
            $relations[$row['friend_id']] = [
                'status' => $row['status'],
                'initiated_by' => $row['initiated_by']
            ];
        }

        $stmt->close();
        return $relations;
    }


    // Block a user
    public function blockUser(int $userID, int $friendID): bool
    {
        $user1 = min($userID, $friendID);
        $user2 = max($userID, $friendID);

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE friend_list SET status = 'blocked', initiated_by = ? WHERE user_id_1 = ? AND user_id_2 = ?");
        $stmt->bind_param("iii", $userID, $user1, $user2);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();

        return $success;
    }


    public function unblockUser(int $userID, int $friendID): bool
    {
        $user1 = min($userID, $friendID);
        $user2 = max($userID, $friendID);

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE friend_list SET status = 'not-friends' WHERE user_id_1 = ? AND user_id_2 = ? AND initiated_by = ?");
        $stmt->bind_param("iii", $user1, $user2, $userID);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();

        return $success;
    }


    public function getFriends(int $userID): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT 
                CASE 
                    WHEN 
                        user_id_1 = ? 
                    THEN 
                        user_id_2 
                    ELSE 
                        user_id_1 
                END AS friend_id,
                status,
                created_on
            FROM friend_list
            WHERE 
                (user_id_1 = ? OR user_id_2 = ?)
            AND 
                status = 'friends'
        ");
        $stmt->bind_param("iii", $userID, $userID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $friends = [];
        while ($row = $result->fetch_assoc()) {
            $f = new Friend();
            $f->load($row);
            $friends[] = $f;
        }

        $stmt->close();
        return $friends;
    }

    public function friendshipExists(int $user1, int $user2): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM friend_list WHERE user_id_1 = ? AND user_id_2 = ? AND status = 'friends'");
        $stmt->bind_param("ii", $user1, $user2);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['cnt'] > 0;
    }


    public function relationShipExists(int $user1, int $user2): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM friend_list WHERE user_id_1 = ? AND user_id_2 = ?");
        $stmt->bind_param("ii", $user1, $user2);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['cnt'] > 0;
    }

    public function getPendingRequests(int $userID): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT 
                CASE 
                    WHEN 
                        user_id_1 = ? 
                    THEN 
                        user_id_2 
                    ELSE 
                        user_id_1 
                END AS friend_id,
                status,
                created_on
            FROM friend_list
            WHERE 
                (user_id_1 = ? OR user_id_2 = ?)
            AND 
                status = 'pending'
        ");
        $stmt->bind_param("iii", $userID, $userID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        $pending = [];
        while ($row = $result->fetch_assoc()) {
            $pending[] = $row;
        }

        $stmt->close();
        return $pending;
    }
}
?>