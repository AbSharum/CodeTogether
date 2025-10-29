<?php
declare(strict_types=1);
require_once __DIR__ . '/../dao/MessageDAO.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/FriendListDAO.php';

class MessagesController extends Controller
{
    private MessageDAO $messageDao;
    private UserDAO $userDao;
    private FriendListDAO $friendDao;

    public function performAction(): void
    {
        $this->messageDao = new MessageDAO();
        $this->userDao = new UserDAO();
        $this->friendDao = new FriendListDAO();

        $userID = $_SESSION['usercreds']['userID'] ?? null;

        if (!$userID) {
            header('Location: index.php?action=login');
            exit;
        }

        $friends = $this->friendDao->getFriends($userID);
        $friendUsers = $this->userDao->getFriendUsers($friends);

        $this->renderView('messages', [
            'friendsUser' => $friendUsers
        ]);
    }

    public function getMessages(): void
    {
        header('Content-Type: application/json');

        $this->messageDao = new MessageDAO();

        $userID = $_SESSION['usercreds']['userID'] ?? null;
        $friendID = intval($_GET['friend_id'] ?? 0);
        $since = $_GET['since'] ?? null;

        if (!$userID || !$friendID) {
            echo json_encode([]);
            return;
        }

        $chatID = $this->messageDao->getDirectChatID($userID, $friendID);
        if (!$chatID) {
            $chatID = $this->messageDao->createDirectChat($userID, $friendID);
        }

        $messages = $since
            ? $this->messageDao->getMessagesSince($chatID, $since)
            : $this->messageDao->getMessagesByChatID($chatID);

        $data = array_map(fn($msg) => [
            'username' => $msg->getUsername(),
            'content' => $msg->getContent(),
            'sent_at' => $msg->getSentAt()->format('Y-m-d H:i:s'),
            'isSender' => $msg->getUserID() === $userID
        ], $messages);

        echo json_encode($data);
    }



    public function sendMessage(): void
    {
        header('Content-Type: application/json');
        ob_clean();

        if (!isset($this->messageDao)) {
            $this->messageDao = new MessageDAO();
        }

        $userID = $_SESSION['usercreds']['userID'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);
        $friendID = intval($data['recipient_id'] ?? 0);
        $content = trim($data['message'] ?? '');

        if (!$userID || !$friendID || $content === '') {
            echo json_encode(['success' => false]);
            exit;
        }

        $chatID = $this->messageDao->getDirectChatID($userID, $friendID);
        if (!$chatID) {
            $chatID = $this->messageDao->createDirectChat($userID, $friendID);
        }

        $success = $this->messageDao->insertMessage($chatID, $userID, $content);

        echo json_encode(['success' => $success]);
        exit;
    }

}
