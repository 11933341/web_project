<?php
include '../config/db.php';
header('Content-Type: application/json');

// Start session to ensure the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Access denied: Login required.']);
    exit();
}

// Retrieve query parameter
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

try {
    if ($query) {
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE ? OR ingredients LIKE ? ORDER BY id DESC");
        $searchTerm = '%' . $query . '%';
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $stmt = $conn->query("SELECT * FROM recipes ORDER BY id DESC");
        $result = $stmt;
    }

    $recipes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    }

    echo json_encode($recipes);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error fetching recipes: ' . $e->getMessage()]);
}
exit();
