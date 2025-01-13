<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

include 'db.php';

$result = $conn->query("SELECT * FROM recipe_requests");
while ($row = $result->fetch_assoc()) {
    echo "<div>
        <h2>{$row['title']}</h2>
        <p>{$row['description']}</p>
        <button onclick='approveRequest({$row['id']})'>Approve</button>
        <button onclick='rejectRequest({$row['id']})'>Reject</button>
    </div>";
}
?>

<script>
    function approveRequest(id) {
        fetch(`approve-request.php?id=${id}`)
            .then(response => response.json())
            .then(data => alert(data.message));
    }

    function rejectRequest(id) {
        fetch(`reject-request.php?id=${id}`)
            .then(response => response.json())
            .then(data => alert(data.message));
    }
</script>