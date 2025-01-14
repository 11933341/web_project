<?php
include '../config/db.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <?php
                $id = intval($_GET['id']);
                $stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<h1 class='card-title'>{$row['title']}</h1>";
                    echo "<p class='card-text'><strong>Description:</strong> {$row['description']}</p>";
                    echo "<p class='card-text'><strong>Ingredients:</strong> {$row['ingredients']}</p>";
                    echo "<p class='card-text'><strong>Steps:</strong> {$row['steps']}</p>";
                } else {
                    echo "<p class='text-danger'>Recipe not found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
