<?php
include '../config/db.php';

session_start();
if ($_SESSION['role'] !== 'admin') {
    die(json_encode(['success' => false, 'message' => 'Access denied.']));
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM recipe_requests WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Recipe request rejected successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error rejecting request.']);
}
