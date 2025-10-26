<?php
declare(strict_types=1);

class EventDispatcher {
    public static function broadcast(array $payload): void {
        $data = json_encode($payload);
        $socketConn = @fsockopen("tcp://websocket", 8081, $errorNum, $errString, 1);
        if ($socketConn) {
            fwrite($socketConn, $data);
            fclose($socketConn);
        } else {
            error_log("WebSocket notify failed: $errString ($errorNum)");
        }
    }
}
