<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Student data array matching the required fields
$student = [
    "name"       => "Asif Iqbal",
    "id"         => "23-42123-1",
    "department" => "Computer Science & Engineering",
    "cgpa"       => 3.82
];

// Encode to JSON
$jsonOutput = json_encode($student);

// Check if JSON encoding failed
if ($jsonOutput === false) {
    echo json_encode(["error" => "Failed to encode student data"]);
    exit;
}

echo $jsonOutput;
?>