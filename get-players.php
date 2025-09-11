<?php
header("Content-Type: application/json");

$dataFile = "uploads/players.json";
$players = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $players = json_decode($json, true);
    if (!is_array($players)) {
        $players = [];
    }
}

echo json_encode($players);
