<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    die(json_encode(['success' => false, 'message' => 'Access denied.']));
}

// include 'db.php';
include '../config/db.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, steps)
                        SELECT title, description, ingredients, steps FROM recipe_requests WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $conn->query("DELETE FROM recipe_requests WHERE id = $id");
    echo json_encode(['success' => true, 'message' => 'Recipe approved and added!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error approving request.']);
} 
?>
 