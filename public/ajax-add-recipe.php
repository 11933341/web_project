<?php
include '../config/db.php';
header('Content-Type: application/json');
session_start();

// Admin-only restriction
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Access denied: Admins only.']);
    exit();
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $ingredients = $_POST['ingredients'] ?? '';
    $steps = $_POST['steps'] ?? '';

    if (empty($title) || empty($description) || empty($ingredients) || empty($steps)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, steps) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $ingredients, $steps);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Recipe added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
exit();
