<?php
// include 'db.php';
include '../config/db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$query = isset($_GET['query']) ? $_GET['query'] : '';
if ($query) {
    $sql = $conn->prepare("select * from recipes where title like ? OR ingredients like ? order by id desc");
    $searchTerm = '%' . $query . '%';
    $sql->bind_param("ss", $searchTerm, $searchTerm);
    $sql->execute();
    $result = $sql->get_result();
} else {
    $result = $conn->query("select * from recipes order by id desc");
}
// $sql->execute();
// $result=$sql->get_result();

// $sql = "SELECT * FROM recipes ORDER BY id DESC";
// $result = $conn->query($sql);

$recipes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
}

echo json_encode($recipes);
exit;
