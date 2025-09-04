<?php
header("Content-Type: application/json");

$uploadDir = "uploads/";
$dataFile = "players.json";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_FILES["profilePic"]["error"] === UPLOAD_ERR_OK) {
    $fileName = time() . "_" . basename($_FILES["profilePic"]["name"]);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $filePath)) {
        $player = [
            "firstName" => $_POST["firstName"],
            "lastName" => $_POST["lastName"],
            "contactInfo" => $_POST["contactInfo"],
            "emergencyContact" => $_POST["emergencyContact"],
            "cricClubsLink" => $_POST["cricClubsLink"],
            "profilePic" => $filePath
        ];

        // Load existing players
        $players = [];
        if (file_exists($dataFile)) {
            $json = file_get_contents($dataFile);
            $players = json_decode($json, true);
            if (!is_array($players)) $players = [];
        }

        // Add new player
        $players[] = $player;

        // Save back to file
        if (file_put_contents($dataFile, json_encode($players, JSON_PRETTY_PRINT))) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to save player data"]);
        }
        exit;
    }
}

echo json_encode(["success" => false, "message" => "File upload failed"]);
