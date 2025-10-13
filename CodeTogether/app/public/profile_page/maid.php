<?php
header('Content-Type: application/json');

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);
$event = $input["event"] ?? "";
$question = $input["question"] ?? "";
$personality = $input["personality"] ?? "maid";

if ($event === "userChat" && $question) {
    $apiKey = getenv('OPEN_API_KEY') ?: ($_ENV['OPEN_API_KEY'] ?? null); //$apiKey = $_ENV['OPEN_API_KEY'] ?? null;
    if (!$apiKey) {
        echo json_encode(["error" => "API key missing"]);
        exit;
    }

    // Define system prompts (AI "memories") for each personality
    $personalities = [
        "maid" => "You are a playful maid assistant on a social media profile page. Speak politely, with cheerful tone, calling the user 'master'. Offer witty or kind comments but stay concise.",
        "butler" => "You are a formal butler assistant. Speak with calm precision, addressing the user as 'sir' or 'madam'. Maintain professionalism and efficiency.",
        "scientist" => "You are a logical scientist assistant. You analyze everything methodically and speak in clear, data-driven sentences. Avoid humor, focus on reason.",
        "gamer" => "You are an energetic gamer companion. Speak casually, use gamer slang, and treat the user like a teammate. Respond with enthusiasm and confidence."
    ];

    // Pick system message
    $systemPrompt = $personalities[$personality] ?? $personalities["maid"];

    // Prepare OpenAI request
    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);

    $messages = [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $question]
    ];

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode([
            "model" => "gpt-5-nano",  // your chosen model
            "messages" => $messages,
            "temperature" => 1
        ])
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
    } else {
        echo $response;
    }

    curl_close($ch);
    exit;
}

// Fallback if no valid event
echo json_encode(["reply" => "Sorry master, I couldn't reach the library of wisdom."]);
?>
