<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

include '../config/db.php';

// Fetch all recipe requests along with the username of the requester
$query = "
    SELECT 
        rr.id, rr.title, rr.description, rr.ingredients, rr.steps, 
        u.username AS requester
    FROM 
        recipe_requests rr
    JOIN 
        users u ON rr.user_id = u.id
";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
            <div class='request-card'>
                <h2>{$row['title']}</h2>
                <p>{$row['description']}</p>
                <p><strong>Ingredients:</strong> {$row['ingredients']}</p>
                <p><strong>Steps:</strong> {$row['steps']}</p>
                <p><strong>Submitted by:</strong> {$row['requester']}</p>
                <button class='btn btn-success' onclick='approveRequest({$row['id']})'>Approve</button>
                <button class='btn btn-danger' onclick='rejectRequest({$row['id']})'>Reject</button>
            </div>
        ";
    }
} else {
    echo "<p>No recipe requests found.</p>";
}
?>

<script>
    function approveRequest(id) {
        fetch(`approve-request.php?id=${id}`)
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Error:', error));
    }

    function rejectRequest(id) {
        fetch(`reject-request.php?id=${id}`)
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Error:', error));
    }
</script>