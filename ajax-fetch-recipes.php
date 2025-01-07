<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM recipes ORDER BY id DESC";
$result = $conn->query($sql);

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

echo json_encode($recipes);
exit;
?>
