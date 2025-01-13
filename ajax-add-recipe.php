<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Ensure JSON response
ini_set('display_errors', 1); // Enable error reporting
error_reporting(E_ALL);


include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, steps) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $ingredients, $steps);
    // $sql = "INSERT INTO recipes (title, description, ingredients, steps) 
    //         VALUES ('$title', '$description', '$ingredients', '$steps')";

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Recipe added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }
    exit;
}
