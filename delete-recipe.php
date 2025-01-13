<?php
header('Content-Type: application/json'); // Ensure JSON response
include 'db.php';

// Start session and restrict access to admins
session_start();
if ($_SESSION['role'] !== 'admin') {
    die(json_encode(['success' => false, 'message' => 'Access denied: Admins only.']));
}

// Read the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = intval($data['id']);

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Recipe deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting recipe: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
