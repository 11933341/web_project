<?php
include 'db.php';

header('Content-Type: application/json');
$query = isset($_Get['query']) ? $_Get['query'] : '';

if ($query) {
    $sql = $conn->prepare("SElect * from recipes where title like ? OR    ingredient like?order by id desc");
    $searchTerm='%'.$query.'%';
    $sql->bind_param("ss",$searchTerm,$searchTerm);
    $sql->execute();
    $result=$sql->get_result();

}else{
    $result=$conn->query("select * from recipes order by id desc");
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
