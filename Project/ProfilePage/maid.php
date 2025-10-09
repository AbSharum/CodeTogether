<?php
header('Content-Type: application/json');

// Simple .env loader
function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$name, $value] = array_map('trim', explode('=', $line, 2));
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}
loadEnv(__DIR__ . '/.env');

$input = json_decode(file_get_contents("php://input"), true);
$event = $input["event"] ?? "";

if ($event === "userChat" && isset($input["question"])) {
    $apiKey = $_ENV['OPEN_API_KEY'] ?? null;
    if (!$apiKey) {
        echo json_encode(["error" => "API key missing"]);
        exit;
    }

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);

    $messages = [
        ["role" => "system", "content" => "You are a playful maid assistant in a social media profile page. You are light, witty, but helpful."],
        ["role" => "user", "content" => $input["question"]]
    ];

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "model" => "gpt-4o-mini", //"gpt-5-nano",//"gpt-4o-mini",
        "messages" => $messages,
        "temperature" => 0.7
    ]));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    } else {
        echo $response;
    }

    curl_close($ch);
    exit;
}

// fallback response
echo json_encode(["reply" => "Sorry master, I couldn't reach the library of wisdom."]);




