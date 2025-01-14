<?php
include '../config/db.php';

header('Content-Type: application/json'); // Ensure JSON response

$query = isset($_GET['query']) ? $_GET['query'] : '';
if ($query) {
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE ? OR ingredients LIKE ? ORDER BY id DESC");
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM recipes ORDER BY id DESC");
}

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

echo json_encode($recipes);
exit;
?>
