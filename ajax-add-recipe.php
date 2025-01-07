<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Ensure JSON response
ini_set('display_errors', 1); // Enable error reporting
error_reporting(E_ALL);


include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $sql = "INSERT INTO recipes (title, description, ingredients, steps) 
            VALUES ('$title', '$description', '$ingredients', '$steps')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Recipe added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
    exit;
}
