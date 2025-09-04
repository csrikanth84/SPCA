<?php
header("Content-Type: application/json");

// DB connection (update with your credentials)
$conn = new mysqli("localhost", "db_user", "db_pass", "spca_db");

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT firstName, lastName, contactInfo, emergencyContact, cricClubsLink, profilePic FROM players";
$result = $conn->query($sql);

$players = [];
while ($row = $result->fetch_assoc()) {
    // prepend server URL if needed for images
    $row["profilePic"] = "http://spcanet.com/" . $row["profilePic"];
    $players[] = $row;
}

echo json_encode($players);
$conn->close();
