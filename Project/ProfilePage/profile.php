<?php
// profile.php
header('Content-Type: application/json');

$filename = 'user.json';

// Initialize fake "database" if missing
if (!file_exists($filename)) {
    $init = [
        "username" => "sarcasticUser42",
        "fullname" => "Alex Human",
        "bio" => "Trying to look interesting on the internet since 2009.",
        "location" => "Somewhere, Earth",
        "joined" => "2021-03-14",
        "followers" => 128,
        "following" => 87,
        "profilePic" => "default.png",
        "posts" => []
    ];
    file_put_contents($filename, json_encode($init));
}

$data = json_decode(file_get_contents($filename), true);

// Handle updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['bio'])) {
        $data['bio'] = $_POST['bio'];
    }
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        $target = "uploads/" . basename($_FILES['profilePic']['name']);
        move_uploaded_file($_FILES['profilePic']['tmp_name'], $target);
        $data['profilePic'] = $target;
    }
    if (isset($_POST['newPost'])) {
        $data['posts'][] = [
            "content" => $_POST['newPost'],
            "time" => date("Y-m-d H:i:s")
        ];
    }
    file_put_contents($filename, json_encode($data));
}

// Output current state
echo json_encode($data);
