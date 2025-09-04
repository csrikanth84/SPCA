<?php
header("Content-Type: application/json");

$uploadDir = "uploads/";
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

        // Save $player in database (MySQL/Postgres/etc.)
        // Example: INSERT INTO players (...)

        echo json_encode(["success" => true]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "File upload failed"]);
