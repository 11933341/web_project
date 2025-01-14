<?php
include '../config/db.php';
header('Content-Type: application/json');

// Start session and restrict access to admins
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Access denied: Admins only.']);
    exit();
}

// Decode JSON data from POST request
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['id'])) {
    $id = intval($data['id']);

    try {
        $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Recipe deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting recipe: ' . $stmt->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request: Recipe ID missing.']);
}
exit();
